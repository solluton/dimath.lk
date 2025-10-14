<?php
header('Content-Type: application/json');

// Include authentication
require_once __DIR__ . '/../config/database.php';

// Require login
requireLogin();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log the request for debugging (removed for security)
// error_log("Upload request received: " . print_r($_POST, true));
// error_log("Files received: " . print_r($_FILES, true));

/**
 * Enhanced server-side file validation
 */
function validateImageFile($filePath) {
    // Check if file exists
    if (!file_exists($filePath)) {
        return ['valid' => false, 'message' => 'File does not exist'];
    }
    
    // Check if file is actually an image using getimagesize()
    $imageInfo = getimagesize($filePath);
    if ($imageInfo === false) {
        return ['valid' => false, 'message' => 'File is not a valid image'];
    }
    
    // Check for malicious content by examining image dimensions
    if ($imageInfo[0] <= 0 || $imageInfo[1] <= 0) {
        return ['valid' => false, 'message' => 'Invalid image dimensions'];
    }
    
    // Check for extremely large dimensions (potential DoS)
    if ($imageInfo[0] > 10000 || $imageInfo[1] > 10000) {
        return ['valid' => false, 'message' => 'Image dimensions too large'];
    }
    
    // Validate MIME type
    $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/avif'];
    if (!in_array($imageInfo['mime'], $allowedMimes)) {
        return ['valid' => false, 'message' => 'Invalid image MIME type'];
    }
    
    // Check for embedded PHP code in image metadata
    $imageData = file_get_contents($filePath);
    if (strpos($imageData, '<?php') !== false || strpos($imageData, '<?=') !== false) {
        return ['valid' => false, 'message' => 'Suspicious content detected'];
    }
    
    return ['valid' => true, 'message' => 'File validation passed'];
}

/**
 * Enhanced file extension validation
 */
function validateFileExtension($filename) {
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'];
    $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    
    if (!in_array($fileExtension, $allowedExtensions)) {
        return ['valid' => false, 'message' => 'Invalid file extension'];
    }
    
    // Check for double extensions (e.g., image.jpg.php)
    $pathParts = explode('.', $filename);
    if (count($pathParts) > 2) {
        return ['valid' => false, 'message' => 'Multiple file extensions detected'];
    }
    
    return ['valid' => true, 'message' => 'Extension validation passed'];
}

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Check if file was uploaded
if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    $errorCode = $_FILES['image']['error'] ?? 'No file uploaded';
    $maxFileSize = ini_get('upload_max_filesize');
    $maxPostSize = ini_get('post_max_size');
    
    $errorMessages = [
        UPLOAD_ERR_INI_SIZE => "File exceeds server upload limit. Maximum file size: $maxFileSize",
        UPLOAD_ERR_FORM_SIZE => "File exceeds form size limit. Maximum file size: $maxPostSize",
        UPLOAD_ERR_PARTIAL => 'File was only partially uploaded. Please try again.',
        UPLOAD_ERR_NO_FILE => 'No file was uploaded. Please select a file.',
        UPLOAD_ERR_NO_TMP_DIR => 'Server configuration error: Missing temporary folder.',
        UPLOAD_ERR_CANT_WRITE => 'Server error: Failed to write file to disk.',
        UPLOAD_ERR_EXTENSION => 'File upload stopped by server extension.'
    ];
    
    $errorMessage = $errorMessages[$errorCode] ?? 'Unknown upload error: ' . $errorCode;
    error_log("Upload error: " . $errorMessage);
    echo json_encode(['success' => false, 'message' => $errorMessage]);
    exit;
}

$file = $_FILES['image'];
$type = $_POST['type'] ?? 'general';

error_log("Processing file: " . $file['name'] . " of type: " . $type);

// Enhanced file extension validation
$extensionValidation = validateFileExtension($file['name']);
if (!$extensionValidation['valid']) {
    error_log("Extension validation failed: " . $extensionValidation['message']);
    echo json_encode(['success' => false, 'message' => $extensionValidation['message']]);
    exit;
}

// Validate file type (basic MIME type check)
$allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp', 'image/avif'];
if (!in_array($file['type'], $allowedTypes)) {
    error_log("Invalid file type: " . $file['type']);
    echo json_encode(['success' => false, 'message' => 'Invalid file type. Only images are allowed.']);
    exit;
}

// Validate file size (10MB max - increased for better quality)
$maxSize = 10 * 1024 * 1024; // 10MB
if ($file['size'] > $maxSize) {
    $maxSizeMB = round($maxSize / (1024 * 1024), 1);
    $fileSizeMB = round($file['size'] / (1024 * 1024), 1);
    error_log("File too large: " . $file['size']);
    echo json_encode(['success' => false, 'message' => "File too large. Your file is {$fileSizeMB}MB, but maximum allowed size is {$maxSizeMB}MB."]);
    exit;
}

// Create uploads directory if it doesn't exist (relative to admin folder)
$uploadDir = '../uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
    error_log("Created upload directory: " . $uploadDir);
}

// Create subdirectory based on type
$typeDir = $uploadDir . $type . '/';
if (!is_dir($typeDir)) {
    mkdir($typeDir, 0755, true);
    error_log("Created type directory: " . $typeDir);
}

// Generate unique filename
$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = uniqid() . '_' . time() . '.' . $extension;
$filepath = $typeDir . $filename;

error_log("Saving file to: " . $filepath);

// Move uploaded file
if (move_uploaded_file($file['tmp_name'], $filepath)) {
    // Enhanced server-side image validation after upload
    $imageValidation = validateImageFile($filepath);
    if (!$imageValidation['valid']) {
        // Remove the uploaded file if validation fails
        unlink($filepath);
        error_log("Image validation failed: " . $imageValidation['message']);
        echo json_encode(['success' => false, 'message' => $imageValidation['message']]);
        exit;
    }
    
    // Return success with web-accessible file path
    $webPath = 'uploads/' . $type . '/' . $filename;
    error_log("File uploaded and validated successfully: " . $webPath);
    echo json_encode([
        'success' => true,
        'file_path' => $webPath,
        'filename' => $filename,
        'size' => $file['size'],
        'type' => $file['type']
    ]);
} else {
    error_log("Failed to move uploaded file");
    echo json_encode(['success' => false, 'message' => 'Failed to save file']);
}
?>
