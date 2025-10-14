<?php
/**
 * AJAX Product Validation Endpoint
 * Validates product data without saving to database
 */

require_once '../config/database.php';
require_once '../config/csrf.php';

// Set JSON response header
header('Content-Type: application/json');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Validate CSRF token
if (!validateCSRFToken($_POST['csrf_token'] ?? '')) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
    exit;
}

try {
    // Extract form data
    $title_black = trim($_POST['title_black'] ?? '');
    $title_green = trim($_POST['title_green'] ?? '');
    $subtitle = trim($_POST['subtitle'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $main_image = trim($_POST['main_image'] ?? '');
    $featured_home_image = trim($_POST['featured_home_image'] ?? '');
    $meta_title = trim($_POST['meta_title'] ?? '');
    $meta_description = trim($_POST['meta_description'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $display_order = (int)($_POST['display_order'] ?? 0);
    
    // Validation array
    $errors = [];
    $warnings = [];
    
    // Required field validation
    if (empty($title_black)) {
        $errors[] = 'Product Title (Black) is required';
    }
    
    if (empty($title_green)) {
        $errors[] = 'Product Title (Green) is required';
    }
    
    if (empty($subtitle)) {
        $errors[] = 'Product Subtitle is required';
    }
    
    if (empty($description)) {
        $errors[] = 'Product Description is required';
    }
    
    if (empty($main_image)) {
        $errors[] = 'Main Product Image is required';
    }
    
    if (empty($featured_home_image)) {
        $errors[] = 'Featured Home Image is required';
    }
    
    if (empty($meta_title)) {
        $errors[] = 'Meta Title is required';
    }
    
    if (empty($meta_description)) {
        $errors[] = 'Meta Description is required';
    }
    
    if (empty($slug)) {
        $errors[] = 'URL Slug is required';
    }
    
    // Field length validation
    if (!empty($title_black) && strlen($title_black) > 255) {
        $errors[] = 'Product Title (Black) must be 255 characters or less';
    }
    
    if (!empty($title_green) && strlen($title_green) > 255) {
        $errors[] = 'Product Title (Green) must be 255 characters or less';
    }
    
    if (!empty($subtitle) && strlen($subtitle) > 255) {
        $errors[] = 'Product Subtitle must be 255 characters or less';
    }
    
    if (!empty($meta_title) && strlen($meta_title) > 255) {
        $errors[] = 'Meta Title must be 255 characters or less';
    }
    
    if (!empty($meta_description) && strlen($meta_description) > 500) {
        $errors[] = 'Meta Description must be 500 characters or less';
    }
    
    if (!empty($slug) && strlen($slug) > 191) {
        $errors[] = 'URL Slug must be 191 characters or less';
    }
    
    // Slug format validation
    if (!empty($slug) && !preg_match('/^[a-z0-9-]+$/', $slug)) {
        $errors[] = 'URL Slug can only contain lowercase letters, numbers, and hyphens';
    }
    
    // Display order validation
    if ($display_order < 0) {
        $errors[] = 'Display Order must be 0 or greater';
    }
    
    // SEO warnings
    if (!empty($meta_title) && strlen($meta_title) < 30) {
        $warnings[] = 'Meta Title is quite short (recommended: 30-60 characters)';
    }
    
    if (!empty($meta_description) && strlen($meta_description) < 120) {
        $warnings[] = 'Meta Description is quite short (recommended: 120-160 characters)';
    }
    
    // Check for duplicate slug (only if editing)
    if (!empty($slug)) {
        $pdo = getDBConnection();
        $product_id = $_POST['product_id'] ?? null; // For edit mode
        
        if ($product_id) {
            // Edit mode - check if slug exists for other products
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE slug = ? AND id != ?");
            $stmt->execute([$slug, $product_id]);
        } else {
            // Create mode - check if slug exists
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM products WHERE slug = ?");
            $stmt->execute([$slug]);
        }
        
        if ($stmt->fetchColumn() > 0) {
            $errors[] = 'URL Slug already exists. Please choose a different slug.';
        }
    }
    
    // JSON validation
    $features_json = $_POST['features_json'] ?? '[]';
    $specifications_json = $_POST['specifications_json'] ?? '[]';
    
    $features = json_decode($features_json, true);
    $specifications = json_decode($specifications_json, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        $errors[] = 'Invalid JSON in features or specifications section';
    }
    
    // Prepare response
    $response = [
        'success' => empty($errors),
        'errors' => $errors,
        'warnings' => $warnings,
        'field_errors' => []
    ];
    
    // Add field-specific errors for better UX
    if (empty($title_black)) {
        $response['field_errors']['title_black'] = 'Required';
    }
    if (empty($title_green)) {
        $response['field_errors']['title_green'] = 'Required';
    }
    if (empty($subtitle)) {
        $response['field_errors']['subtitle'] = 'Required';
    }
    if (empty($description)) {
        $response['field_errors']['description'] = 'Required';
    }
    if (empty($main_image)) {
        $response['field_errors']['main_image'] = 'Required';
    }
    if (empty($featured_home_image)) {
        $response['field_errors']['featured_home_image'] = 'Required';
    }
    if (empty($meta_title)) {
        $response['field_errors']['meta_title'] = 'Required';
    }
    if (empty($meta_description)) {
        $response['field_errors']['meta_description'] = 'Required';
    }
    if (empty($slug)) {
        $response['field_errors']['slug'] = 'Required';
    }
    
    echo json_encode($response);
    
} catch (Exception $e) {
    error_log("Validation error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'message' => 'Validation error occurred',
        'errors' => ['An unexpected error occurred during validation']
    ]);
}
?>
