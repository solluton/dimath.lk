<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/csrf.php';

// Require login
requireLogin();

$user = getCurrentUser();

// Check if we're in edit mode
$isEditMode = isset($_GET['id']) && !empty($_GET['id']);
$product_id = $isEditMode ? (int)$_GET['id'] : null;
$product = null;

// Ensure we have a valid product ID for update mode
if (!$isEditMode || !$product_id) {
    $_SESSION['error'] = 'Invalid product ID for update.';
    header('Location: products.php');
    exit();
}

// If in edit mode, load existing product data
if ($isEditMode) {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$product) {
            $_SESSION['error'] = 'Product not found.';
            header('Location: products.php');
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['error'] = 'Error loading product: ' . $e->getMessage();
        header('Location: products.php');
        exit();
    }
}

// Form data defaults
$formData = [
    'title_black' => '',
    'title_green' => '',
    'subtitle' => '',
    'description' => '',
    'main_image' => '',
    'featured_home_image' => '',
    'specifications_image' => '',
    'features_json' => '[]',
    'specifications_json' => '[]',
    'why_choose_title_black' => '',
    'why_choose_title_green' => '',
    'why_choose_subtitle' => '',
    'ordering_description' => '',
    'meta_title' => '',
    'meta_description' => '',
    'status' => 'active',
    'display_order' => 0,
    'enable_order_now' => true,
    'enable_featured_home' => false,
    'slug' => ''
];

// If in edit mode, populate form data with existing product data
if ($isEditMode && $product) {
    $formData = [
        'title_black' => $product['title_black'] ?? '',
        'title_green' => $product['title_green'] ?? '',
        'subtitle' => $product['subtitle'] ?? '',
        'description' => $product['description'] ?? '',
        'main_image' => $product['main_image'] ?? '',
        'featured_home_image' => $product['featured_home_image'] ?? '',
        'specifications_image' => $product['specifications_image'] ?? '',
        'features_json' => $product['features_json'] ?? '[]',
        'specifications_json' => $product['specifications_json'] ?? '[]',
        'why_choose_title_black' => $product['why_choose_title_black'] ?? '',
        'why_choose_title_green' => $product['why_choose_title_green'] ?? '',
        'why_choose_subtitle' => $product['why_choose_subtitle'] ?? '',
        'ordering_description' => $product['ordering_description'] ?? '',
        'meta_title' => $product['meta_title'] ?? '',
        'meta_description' => $product['meta_description'] ?? '',
        'status' => $product['status'] ?? 'active',
        'display_order' => $product['display_order'] ?? 0,
        'enable_order_now' => (bool)($product['enable_order_now'] ?? true),
        'enable_featured_home' => (bool)($product['enable_featured_home'] ?? false),
        'slug' => $product['slug'] ?? ''
    ];
}

$message = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    requireCSRFValidation();
    
    try {
        // Get and validate form data
        $title_black = trim($_POST['title_black'] ?? '');
        $title_green = trim($_POST['title_green'] ?? '');
        $subtitle = trim($_POST['subtitle'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $main_image = trim($_POST['main_image'] ?? '');
        $featured_home_image = trim($_POST['featured_home_image'] ?? '');
        
        // Build features JSON from individual UI fields
        $features = [];
        for ($i = 0; $i < 6; $i++) {
            $title = trim($_POST["feature_title_$i"] ?? '');
            $feature_description = trim($_POST["feature_description_$i"] ?? '');
            
            $features[] = [
                'title' => $title,
                'description' => $feature_description
            ];
        }
        
        $features_json = json_encode($features);
        
        // Build specifications JSON from individual UI fields  
        $specifications = [];
        for ($i = 0; $i < 3; $i++) {
            $title = trim($_POST["spec_title_$i"] ?? '');
            $spec_description = trim($_POST["spec_description_$i"] ?? '');
            
            $specifications[] = [
                'title' => $title,
                'description' => $spec_description
            ];
        }
        
        $specifications_json = json_encode($specifications);
        $specifications_image = trim($_POST['specifications_image'] ?? '');
        $why_choose_title_black = trim($_POST['why_choose_title_black'] ?? '');
        $why_choose_title_green = trim($_POST['why_choose_title_green'] ?? '');
        $why_choose_subtitle = trim($_POST['why_choose_subtitle'] ?? '');
        
        $meta_title = trim($_POST['meta_title'] ?? '');
        $meta_description = trim($_POST['meta_description'] ?? '');
        $status = $_POST['status'] ?? 'active';
        $display_order = (int)($_POST['display_order'] ?? 0);
        $slug = trim($_POST['slug'] ?? '');
        $enable_order_now = (bool)($_POST['enable_order_now'] ?? true);
        $enable_featured_home = (bool)($_POST['enable_featured_home'] ?? false);
        
        // Validation
        $errors = [];
        
        // Required field validation
        if (empty(trim($title_black))) {
            $errors[] = 'Product Title (Black) is required';
        }
        
        if (empty(trim($title_green))) {
            $errors[] = 'Product Title (Green) is required';
        }
        
        if (empty(trim($subtitle))) {
            $errors[] = 'Product Subtitle is required';
        }
        
        if (empty(trim($description))) {
            $errors[] = 'Product Description is required';
        }
        
        if (empty(trim($_POST['main_image'] ?? ''))) {
            $errors[] = 'Main Product Image is required';
        }
        
        if (empty(trim($_POST['featured_home_image'] ?? ''))) {
            $errors[] = 'Featured Home Image is required';
        }
        
        if (empty(trim($meta_title))) {
            $errors[] = 'Meta Title is required';
        }
        
        if (empty(trim($meta_description))) {
            $errors[] = 'Meta Description is required';
        }
        
        if (empty(trim($slug))) {
            $errors[] = 'URL Slug is required';
        }
        
        // Field length validation
        if (strlen($title_black) > 255) {
            $errors[] = 'Product Title (Black) must be 255 characters or less';
        }
        
        if (strlen($title_green) > 255) {
            $errors[] = 'Product Title (Green) must be 255 characters or less';
        }
        
        if (strlen($subtitle) > 255) {
            $errors[] = 'Product Subtitle must be 255 characters or less';
        }
        
        if (strlen($meta_title) > 255) {
            $errors[] = 'Meta Title must be 255 characters or less';
        }
        
        if (strlen($meta_description) > 500) {
            $errors[] = 'Meta Description must be 500 characters or less';
        }
        
        if (strlen($slug) > 191) {
            $errors[] = 'URL Slug must be 191 characters or less';
        }
        
        // Slug format validation
        if (!preg_match('/^[a-z0-9-]+$/', $slug)) {
            $errors[] = 'URL Slug can only contain lowercase letters, numbers, and hyphens';
        }
        
        // Display order validation
        if ($display_order < 0) {
            $errors[] = 'Display Order must be 0 or greater';
        }
        
        // If there are validation errors, don't proceed
        if (!empty($errors)) {
            $error = 'Please fix the following errors:' . "\n" . implode("\n", $errors);
            $formData = [
                'title_black' => $title_black ?? '',
                'title_green' => $title_green ?? '',
                'subtitle' => $subtitle ?? '',
                'description' => $description ?? '',
                'main_image' => $main_image ?? '',
                'featured_home_image' => $featured_home_image ?? '',
                'features_json' => $features_json ?? '[]',
                'specifications_json' => $specifications_json ?? '[]',
                'why_choose_title_black' => $why_choose_title_black ?? '',
                'why_choose_title_green' => $why_choose_title_green ?? '',
                'why_choose_subtitle' => $why_choose_subtitle ?? '',
                'ordering_description' => $ordering_description ?? '',
                'meta_title' => $meta_title ?? '',
                'meta_description' => $meta_description ?? '',
                'status' => $status ?? 'active',
                'display_order' => $display_order ?? 0,
                'enable_order_now' => $enable_order_now ?? true,
                'enable_featured_home' => $enable_featured_home ?? false
            ];
        } else {
            // Validate JSON
            $features = json_decode($features_json, true);
            $specifications = json_decode($specifications_json, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $error = 'Invalid JSON in features or specifications section.';
                $formData = [
                    'title_black' => $title_black ?? '',
                    'title_green' => $title_green ?? '',
                    'subtitle' => $subtitle ?? '',
                    'description' => $description ?? '',
                    'main_image' => $main_image ?? '',
                    'featured_home_image' => $featured_home_image ?? '',
                    'features_json' => $features_json ?? '[]',
                    'specifications_json' => $specifications_json ?? '[]',
                    'why_choose_title_black' => $why_choose_title_black ?? '',
                    'why_choose_title_green' => $why_choose_title_green ?? '',
                    'why_choose_subtitle' => $why_choose_subtitle ?? '',
                    'ordering_description' => $ordering_description ?? '',
                    'meta_title' => $meta_title ?? '',
                    'meta_description' => $meta_description ?? '',
                    'status' => $status ?? 'active',
                    'display_order' => $display_order ?? 0,
                    'enable_order_now' => $enable_order_now ?? true,
                    'enable_featured_home' => $enable_featured_home ?? false
                ];
            } else {
        
        // Combine title parts
        $title = $title_black . ($title_green ? ' ' . $title_green : '');
        
        $pdo = getDBConnection();
        
        // Handle slug - use manual slug if provided, otherwise generate from title
        $manualSlug = trim($_POST['slug'] ?? '');
        if (!empty($manualSlug)) {
            // Use manual slug, but clean it up
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $manualSlug)));
            $slug = trim($slug, '-');
            if ($slug === '') {
                throw new Exception('Invalid slug format. Please use only letters, numbers, and hyphens.');
            }
        } else {
            // Generate slug from title
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
            $slug = trim($slug, '-');
            if ($slug === '') {
                $slug = 'product';
            }
        }
        
        // Ensure slug uniqueness
        $originalSlug = $slug;
        $counter = 1;
        while (true) {
            $check = $pdo->prepare("SELECT id FROM products WHERE slug = ? LIMIT 1");
            $check->execute([$slug]);
            if (!$check->fetch()) break;
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        // Insert or Update product based on mode
        if ($isEditMode) {
            // Update existing product
            $stmt = $pdo->prepare("
                UPDATE products SET 
                    title = ?, title_black = ?, title_green = ?, subtitle = ?, 
                    description = ?, main_image = ?, featured_home_image = ?, why_choose_title_black = ?, 
                    why_choose_title_green = ?, why_choose_subtitle = ?, features_json = ?, 
                    specifications_json = ?, specifications_image = ?, meta_title = ?, 
                    meta_description = ?, status = ?, display_order = ?, enable_order_now = ?, enable_featured_home = ?, slug = ?, 
                    updated_at = NOW()
                WHERE id = ?
            ");
            
            $stmt->execute([
                $title, $title_black, $title_green, $subtitle, $description, 
                $main_image, $featured_home_image, $why_choose_title_black, $why_choose_title_green, $why_choose_subtitle, 
                $features_json, $specifications_json, $specifications_image, $meta_title, 
                $meta_description, $status, $display_order, $enable_order_now, $enable_featured_home, $slug, $product_id
            ]);
            
            $message = 'Product updated successfully!';
        } else {
            // Insert new product
            $stmt = $pdo->prepare("
                INSERT INTO products (title, title_black, title_green, subtitle, description, main_image, featured_home_image, why_choose_title_black, why_choose_title_green, why_choose_subtitle, features_json, specifications_json, specifications_image, meta_title, meta_description, status, display_order, enable_order_now, enable_featured_home, slug, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
            ");
            
            $stmt->execute([
                $title, $title_black, $title_green, $subtitle, $description, 
                $main_image, $featured_home_image, $why_choose_title_black, $why_choose_title_green, $why_choose_subtitle, $features_json, $specifications_json, $specifications_image, $meta_title, $meta_description, $status, $display_order, $enable_order_now, $enable_featured_home, $slug
            ]);
            
            $message = 'Product created successfully!';
        }
        
        // Check if this is an AJAX request
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            // Return JSON response for AJAX
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Product updated successfully!',
                'redirect' => 'products.php'
            ]);
            exit();
        } else {
            // Redirect after successful operation for regular form submission
            header('Location: products.php');
            exit();
        }
        
            } // Close JSON validation else block
        } // Close main validation else block
        
    } catch (Exception $e) {
        $error = 'Error creating product: ' . $e->getMessage();
        // Refill form with submitted data on error
        $formData = [
            'title_black' => $title_black ?? '',
            'title_green' => $title_green ?? '',
            'subtitle' => $subtitle ?? '',
            'description' => $description ?? '',
            'main_image' => $main_image ?? '',
            'featured_home_image' => $featured_home_image ?? '',
            'features_json' => $features_json ?? '[]',
            'specifications_json' => $specifications_json ?? '[]',
            'why_choose_title_black' => $why_choose_title_black ?? '',
            'why_choose_title_green' => $why_choose_title_green ?? '',
            'why_choose_subtitle' => $why_choose_subtitle ?? '',
            'ordering_description' => $ordering_description ?? '',
            'meta_title' => $meta_title ?? '',
            'meta_description' => $meta_description ?? '',
            'status' => $status ?? 'active',
            'display_order' => $display_order ?? 0,
            'enable_order_now' => $enable_order_now ?? true,
            'enable_featured_home' => $enable_featured_home ?? false
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Dimath Cinnamon - Update Product" />
  <meta name="keyword" content="dimath, cinnamon, create, product" />
  <meta name="author" content="Dimath Cinnamon" />
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
  
  <!-- Favicon -->
  <link href="../images/favicon.png" rel="shortcut icon" type="image/x-icon">
  <link href="../images/webclip.png" rel="apple-touch-icon">
  
  <!-- Title -->
  <title>Update Product | Dimath Cinnamon - Admin Dashboard</title>
  
  <!-- Dashboard UI CSS -->
  <link rel="stylesheet" href="../dashboard ui/dist/assets/vendors/metismenu/metisMenu.min.css">
  <link rel="stylesheet" href="../dashboard ui/dist/assets/vendors/@flaticon/flaticon-uicons/css/all/all.css">
  <link rel="stylesheet" type="text/css" href="../dashboard ui/dist/assets/css/theme.min.css">
  
  <!-- NeoMed Custom Dashboard Colors -->
  <link rel="stylesheet" type="text/css" href="../css/dashboard-custom.css">
  
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <!-- Color Modes JS - DISABLED to force light mode -->
  <!-- <script src="../dashboard ui/dist/assets/js/color-modes.min.js"></script> -->
  
  <!-- Force Light Mode Script -->
  <script>
    // Force light mode and prevent dark mode
    document.documentElement.setAttribute('data-bs-theme', 'light');
    localStorage.setItem('theme', 'light');
  </script>
  
  <!-- HTML5 shim and Respond.js for IE8 support -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  
  <!-- Custom CSS for validation animations -->
  <style>
    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      10%, 30%, 50%, 70%, 90% { transform: translateX(-2px); }
      20%, 40%, 60%, 80% { transform: translateX(2px); }
    }
    
    .field-error {
      font-size: 0.875rem;
      margin-top: 0.25rem;
    }
    
    .is-invalid {
      border-color: #dc3545 !important;
      box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
    }
    
    .is-invalid:focus {
      border-color: #dc3545 !important;
      box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
    }
  </style>
</head>

<body>
  <!-- Main Wrapper -->
  <div class="main-wrapper">
    <?php include 'includes/sidebar-global.php'; ?>
    
    <!-- Main Content -->
    <main id="edash-main">
      <?php include 'includes/header-global.php'; ?>

      <!-- Page Content -->
      <div class="edash-page-container" id="edash-page-container">
        <!-- Breadcrumb -->
        <div class="edash-content-breadcumb row mb-4 mb-md-6 pt-md-2 px-4">
          <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <h2 class="h4 fw-semibold text-dark">Update Product</h2>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                      <a href="dashboard.php">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                      <a href="products.php">Products</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Update Product
                    </li>
                  </ol>
                </nav>
              </div>
              <div class="d-flex align-items-center gap-2">
                <a href="/admin/products" class="btn btn-outline-primary">
                  <i class="fi fi-rr-arrow-left me-2"></i>Back to Products
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Error/Success Messages -->
        <?php if (!empty($message)): ?>
          <div class="alert alert-success alert-dismissible fade show mx-4 mb-4">
            <i class="fi fi-rr-checkbox me-2"></i><?php echo htmlspecialchars($message); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
          <div class="alert alert-danger alert-dismissible fade show mx-4 mb-4">
            <i class="fi fi-rr-exclamation me-2"></i><?php echo nl2br(htmlspecialchars($error)); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>

        <!-- Product Form -->
        <div class="px-4">
          <form method="post" enctype="multipart/form-data" onsubmit="return <?= $isEditMode ? 'confirmUpdate' : 'confirmCreate' ?>()">
            <?= getCSRFTokenField() ?>
            <?php if ($isEditMode): ?>
              <input type="hidden" name="id" value="<?= $product_id ?>">
            <?php endif; ?>
            <div class="row">
              <!-- Basic Information -->
              <div class="col-lg-8">
                <div class="card">
                  <div class="card-header">
                    <h6 class="card-title mb-0">Basic Information</h6>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-8">
                        <div class="mb-3">
                          <div class="row">
                            <div class="col-md-6">
                              <label for="title_black" class="form-label">Product Title - Part 1 (Black Text) *</label>
                              <input type="text" class="form-control" id="title_black" name="title_black" required maxlength="255"
                                     value="<?= htmlspecialchars($formData['title_black'] ?? '') ?>"
                                     placeholder="e.g., Dimath Cinnamon">
                              <div class="form-text">First part that appears in black color</div>
                            </div>
                            <div class="col-md-6">
                              <label for="title_green" class="form-label">Product Title - Part 2 (Green Text) *</label>
                              <input type="text" class="form-control" id="title_green" name="title_green" required maxlength="255"
                                     value="<?= htmlspecialchars($formData['title_green'] ?? '') ?>"
                                     placeholder="e.g., Softball">
                              <div class="form-text">Second part that appears in green color</div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- Subtitle -->
                      <div class="col-md-6 mb-3">
                        <label for="subtitle" class="form-label">Product Subtitle *</label>
                        <input type="text" class="form-control" id="subtitle" name="subtitle" required maxlength="255"
                               value="<?= htmlspecialchars($formData['subtitle']) ?>"
                               placeholder="e.g., The Ball That Never Quits">
                      </div>
                      
                      <!-- Description -->
                      <div class="col-12 mb-3">
                        <label for="description" class="form-label">Product Description *</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required
                                  placeholder="Detailed product description..."><?= htmlspecialchars($formData['description']) ?></textarea>
                      </div>
                      
                      <!-- Main Image -->
                      <div class="col-12 mb-3">
                        <label for="main_image_upload" class="form-label">Main Product Image *</label>
                        <div class="input-group">
                          <input type="file" class="form-control" id="main_image_upload" accept="image/*" onchange="handleImageUpload(this, 'main-image-preview', 'main_image', 'main-image-preview-container', 'main')">
                          <button class="btn btn-outline-secondary" type="button" onclick="clearMainImagePath()">
                            <i class="fi fi-rr-cross me-1"></i>Clear
                          </button>
                        </div>
                        <?php if ($isEditMode && !empty($formData['main_image'])): ?>
                          <div class="mt-2">
                            <small class="text-muted">
                              <i class="fi fi-rr-picture me-1"></i>Current: <?= htmlspecialchars(basename($formData['main_image'])) ?>
                            </small>
                          </div>
                        <?php endif; ?>
                        <div class="form-text">Upload the main product image (JPG, PNG, AVIF)</div>
                        <input type="hidden" id="main_image" name="main_image" required value="<?= htmlspecialchars($formData['main_image'] ?? '') ?>">
                        <!-- Image Preview -->
                        <div class="mt-2" id="main-image-preview-container" style="display: none;">
                          <img id="main-image-preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                          <div class="mt-2">
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearMainImagePath()">
                              <i class="fi fi-rr-cross me-1"></i>Remove Image
                            </button>
                          </div>
                        </div>
                        </div>
                      </div>
                      
                      <!-- Featured Home Image -->
                      <div class="col-12 mb-3">
                        <label for="featured_home_image_upload" class="form-label">Featured Home Image *</label>
                        <div class="input-group">
                          <input type="file" class="form-control" id="featured_home_image_upload" accept="image/*" onchange="handleImageUpload(this, 'featured-home-image-preview', 'featured_home_image', 'featured-home-image-preview-container', 'featured-home')">
                          <button class="btn btn-outline-secondary" type="button" onclick="clearFeaturedHomeImagePath()">
                            <i class="fi fi-rr-cross me-1"></i>Clear
                          </button>
                        </div>
                        <?php if ($isEditMode && !empty($formData['featured_home_image'])): ?>
                          <div class="mt-2">
                            <small class="text-muted">
                              <i class="fi fi-rr-picture me-1"></i>Current: <?= htmlspecialchars(basename($formData['featured_home_image'])) ?>
                            </small>
                          </div>
                        <?php endif; ?>
                        <div class="form-text">Upload the featured image for home page display (JPG, PNG, AVIF)</div>
                        <input type="hidden" id="featured_home_image" name="featured_home_image" required value="<?= htmlspecialchars($formData['featured_home_image'] ?? '') ?>">
                        <!-- Image Preview -->
                        <div class="mt-2" id="featured-home-image-preview-container" style="display: none;">
                          <img id="featured-home-image-preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                          <div class="mt-2">
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearFeaturedHomeImagePath()">
                              <i class="fi fi-rr-cross me-1"></i>Remove Image
                            </button>
                          </div>
                        </div>
                        </div>
                  </div>
                </div>

                <!-- Product Settings -->
                <div class="card mt-4">
                  <div class="card-header">
                    <h6 class="card-title mb-0">
                      <i class="fi fi-rr-settings me-2"></i>Product Settings
                    </h6>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <!-- Status -->
                      <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                          <option value="active" <?= $formData['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                          <option value="inactive" <?= $formData['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                      </div>
                      
                      <!-- Display Order -->
                      <div class="col-md-6 mb-3">
                        <label for="display_order" class="form-label">Display Order</label>
                        <input type="number" class="form-control" id="display_order" name="display_order"
                               value="<?= $formData['display_order'] ?>"
                               min="0">
                        <div class="form-text">Lower numbers appear first</div>
                      </div>
                      
                      <!-- Enable Order Now -->
                      <div class="col-md-6 mb-3">
                        <label for="enable_order_now" class="form-label">Enable Order Now Button</label>
                        <select class="form-select" id="enable_order_now" name="enable_order_now">
                          <option value="1" <?= ($formData['enable_order_now'] ?? true) ? 'selected' : '' ?>>Enabled</option>
                          <option value="0" <?= !($formData['enable_order_now'] ?? true) ? 'selected' : '' ?>>Disabled</option>
                        </select>
                        <div class="form-text">Show "Order Now" button on product pages</div>
                      </div>
                      
                      <!-- Enable Featured Home -->
                      <div class="col-md-6 mb-3">
                        <label for="enable_featured_home" class="form-label">Enable Featured on Home Page</label>
                        <select class="form-select" id="enable_featured_home" name="enable_featured_home">
                          <option value="1" <?= ($formData['enable_featured_home'] ?? false) ? 'selected' : '' ?>>Enabled</option>
                          <option value="0" <?= !($formData['enable_featured_home'] ?? false) ? 'selected' : '' ?>>Disabled</option>
                        </select>
                        <div class="form-text">Show this product in "Gear That Hits Different" section on home page</div>
                      </div>
                      
                      <!-- URL Slug -->
                      <div class="col-12 mb-3">
                        <label for="slug" class="form-label">URL Slug *</label>
                        <div class="input-group">
                          <input type="text" class="form-control" id="slug" name="slug" required maxlength="191" pattern="[a-z0-9\-]+"
                                 value="<?= htmlspecialchars($formData['slug'] ?? '') ?>"
                                 placeholder="e.g., alba-cinnamon">
                          <button class="btn btn-outline-secondary" type="button" onclick="generateSlug()">
                            <i class="fi fi-rr-magic-wand me-1"></i>Auto Generate
                          </button>
                        </div>
                        <div class="form-text">URL-friendly version of the product name (e.g., /product/alba-cinnamon)</div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Why Choose Us Section -->
                <div class="card mt-4">
                  <div class="card-header">
                    <h6 class="card-title mb-0">Why Choose Us Section</h6>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <!-- Why Choose Title Fields -->
                      <div class="col-md-6 mb-3">
                        <label for="why_choose_title_black" class="form-label">
                          Why Choose Title - Part 1 (Black Text)
                        </label>
                        <input type="text" class="form-control" id="why_choose_title_black" name="why_choose_title_black" 
                               value="<?= htmlspecialchars($formData['why_choose_title_black'] ?? '') ?>" 
                               placeholder="e.g., Why Choose Dimath Cinnamon">
                        <div class="form-text">First part that appears in black color</div>
                      </div>
                      
                      <div class="col-md-6 mb-3">
                        <label for="why_choose_title_green" class="form-label">
                          Why Choose Title - Part 2 (Green Text)
                        </label>
                        <input type="text" class="form-control" id="why_choose_title_green" name="why_choose_title_green" 
                               value="<?= htmlspecialchars($formData['why_choose_title_green'] ?? '') ?>" 
                               placeholder="e.g., Cricket Softball?">
                        <div class="form-text">Second part that appears in green color</div>
                      </div>
                      
                      <!-- Why Choose Subtitle -->
                      <div class="col-12 mb-3">
                        <label for="why_choose_subtitle" class="form-label">Why Choose Subtitle</label>
                        <input type="text" class="form-control" id="why_choose_subtitle" name="why_choose_subtitle" 
                               value="<?= htmlspecialchars($formData['why_choose_subtitle'] ?? '') ?>" 
                               placeholder="e.g., Engineered for excellence, built for champions">
                      </div>
                      
                      <!-- Features Individual Input Boxes -->
                      <div class="col-12 mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                          <label class="form-label mb-0">
                            <i class="fi fi-rr-box me-2"></i>Why Choose Us - 6 Feature Boxes
                          </label>
                          <div>
                            <button type="button" class="btn btn-sm btn-primary" onclick="loadDefaultFeatures()">
                              <i class="fi fi-rr-magic-wand me-1"></i>Load Defaults
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="previewFeatureBoxes()">
                              <i class="fi fi-rr-eye me-1"></i>Preview
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearAllFeatures()">
                              <i class="fi fi-rr-refresh me-1"></i>Clear All
                            </button>
                          </div>
                        </div>
                        
                        <div class="alert alert-info mb-3">
                          <strong>📦 Easily manage 6 feature boxes:</strong> Each box has a title and description that will appear on the product page.
                        </div>
                        
                        <!-- Feature Box Input Fields -->
                        <div class="row g-3">
                          <?php 
                          $existingFeatures = json_decode($formData['features_json'] ?? '[]', true) ?: [];
                          for ($i = 0; $i < 6; $i++): 
                            $feature = $existingFeatures[$i] ?? ['title' => '', 'description' => ''];
                          ?>
                          <div class="col-md-6">
                            <div class="card">
                              <div class="card-header bg-light">
                                <h6 class="mb-0 text-primary">
                                  <i class="fi fi-rr-box me-1"></i>Feature Box <?= $i + 1 ?>
                                </h6>
                              </div>
                              <div class="card-body">
                                <div class="mb-3">
                                  <label for="feature_title_<?= $i ?>" class="form-label">Title</label>
                                  <input type="text" class="form-control feature-title-input" id="feature_title_<?= $i ?>" 
                                         name="feature_title_<?= $i ?>" 
                                         value="<?= htmlspecialchars($feature['title']) ?>" 
                                         placeholder="Enter feature title...">
                                </div>
                                <div class="mb-0">
                                  <label for="feature_description_<?= $i ?>" class="form-label">Description</label>
                                  <textarea class="form-control feature-desc-input" id="feature_description_<?= $i ?>" 
                                            name="feature_description_<?= $i ?>" rows="3" 
                                            placeholder="Enter feature description..."><?= htmlspecialchars($feature['description']) ?></textarea>
                                </div>
                              </div>
                            </div>
                          </div>
                          <?php endfor; ?>
                        </div>
                        
                        <!-- Hidden field for JSON (automatically updated) -->
                        <input type="hidden" id="features_json" name="features_json" value="<?= htmlspecialchars($formData['features_json'] ?? '[]') ?>">
                        <div class="alert alert-success mt-3">
                          <small class="text-muted">
                            <i class="fi fi-rr-info me-1"></i>
                            ✅ Easy to use! Individual input boxes automatically create the JSON. 
                            You can leave fields empty if you don't want to use all 6 boxes.
                          </small>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Specifications Section -->
                <div class="card mt-4">
                  <div class="card-header">
                    <h6 class="card-title mb-0">Product Specifications</h6>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <!-- Specifications Image -->
                      <div class="col-12 mb-3">
                        <label for="spec_image_upload" class="form-label">
                          <i class="fi fi-rr-picture me-2"></i>Specifications Section Image
                        </label>
                        <div class="input-group">
                          <input type="file" class="form-control" id="spec_image_upload" accept="image/*" onchange="handleImageUpload(this, 'spec-image-preview', 'specifications_image', 'spec-image-preview-container', 'spec')">
                          <button class="btn btn-outline-secondary" type="button" onclick="clearSpecImagePath()">
                            <i class="fi fi-rr-cross me-1"></i>Clear
                          </button>
                        </div>
                        <?php if ($isEditMode && !empty($formData['specifications_image'])): ?>
                          <div class="mt-2">
                            <small class="text-muted">
                              <i class="fi fi-rr-picture me-1"></i>Current: <?= htmlspecialchars(basename($formData['specifications_image'])) ?>
                            </small>
                          </div>
                        <?php endif; ?>
                        <input type="hidden" id="specifications_image" name="specifications_image" value="<?= htmlspecialchars($formData['specifications_image'] ?? '') ?>">
                        <div class="form-text">Upload specifications section image (JPG, PNG, AVIF)</div>
                        <!-- Image Preview -->
                        <div class="mt-2" id="spec-image-preview-container" style="display: none;">
                          <img id="spec-image-preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                          <div class="mt-2">
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearSpecImagePath()">
                              <i class="fi fi-rr-cross me-1"></i>Remove Image
                            </button>
                          </div>
                        </div>
                      </div>

                      <!-- Specifications Individual Input Boxes -->
                      <div class="col-12 mb-3">
                        <div class="mb-3">
                          <label class="form-label mb-0">
                            <i class="fi fi-rr-list me-2"></i>Product Specifications
                          </label>
                        </div>
                        
                        <div class="alert alert-info mb-3">
                          <strong>⚙️ Product specifications:</strong> Technical details and features that customers want to know.
                        </div>
                        
                        <!-- Specification Input Fields -->
                        <div class="row g-3">
                          <?php 
                          $existingSpecs = json_decode($formData['specifications_json'] ?? '[]', true) ?: [];
                          for ($i = 0; $i < 3; $i++): 
                            $spec = $existingSpecs[$i] ?? ['title' => '', 'description' => ''];
                          ?>
                          <div class="col-md-6">
                            <div class="card">
                              <div class="card-header">
                                <h6 class="mb-0">
                                  Specification <?= $i + 1 ?>
                                </h6>
                              </div>
                              <div class="card-body">
                                <div class="mb-3">
                                  <label for="spec_title_<?= $i ?>" class="form-label">Title</label>
                                  <input type="text" class="form-control spec-title-input" id="spec_title_<?= $i ?>" 
                                         name="spec_title_<?= $i ?>" 
                                         value="<?= htmlspecialchars($spec['title']) ?>" 
                                         placeholder="Enter specification title...">
                                </div>
                                <div class="mb-0">
                                  <label for="spec_description_<?= $i ?>" class="form-label">Description</label>
                                  <textarea class="form-control spec-desc-input" id="spec_description_<?= $i ?>" 
                                            name="spec_description_<?= $i ?>" rows="3" 
                                            placeholder="Enter specification description..."><?= htmlspecialchars($spec['description']) ?></textarea>
                                </div>
                              </div>
                            </div>
                          </div>
                          <?php endfor; ?>
                        </div>
                        
                        <!-- Hidden field for JSON (automatically updated) -->
                        <input type="hidden" id="specifications_json" name="specifications_json" value="<?= htmlspecialchars($formData['specifications_json'] ?? '[]') ?>">
                        <div class="alert alert-success mt-3">
                          <small class="text-muted">
                            <i class="fi fi-rr-info me-1"></i>
                            ✅ Easy to use! Individual specification boxes automatically create the JSON. 
                            You can leave fields empty if you don't need all specifications.
                          </small>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

              <!-- SEO Settings -->
              <div class="col-lg-4">
                <div class="card">
                  <div class="card-header">
                    <h6 class="card-title mb-0">SEO Settings</h6>
                  </div>
                  <div class="card-body">
                    <div class="mb-3">
                      <label for="meta_title" class="form-label">Meta Title *</label>
                      <input type="text" class="form-control" id="meta_title" name="meta_title" required maxlength="255"
                             value="<?= htmlspecialchars($formData['meta_title']) ?>"
                             placeholder="SEO title for search engines">
                      <div id="meta_title_count" class="text-muted small">0/60 characters</div>
                    </div>
                    
                    <div class="mb-3">
                      <label for="meta_description" class="form-label">Meta Description *</label>
                      <textarea class="form-control" id="meta_description" name="meta_description" rows="3" required maxlength="500"
                                placeholder="SEO description..."><?= htmlspecialchars($formData['meta_description']) ?></textarea>
                      <div id="meta_description_count" class="text-muted small">0/160 characters</div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="d-grid gap-2">
                      <button type="submit" class="btn btn-primary">
                        <i class="fi fi-rr-check me-2"></i>Update Product
                      </button>
                      <a href="/admin/products" class="btn btn-outline-primary">
                        <i class="fi fi-rr-times me-2"></i>Cancel
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      
      <?php include 'includes/footer-content-global.php'; ?>
    </main>
  </div>

  <!-- Required JavaScript -->
  
  <script>
    // Combine title parts for live preview
    function updateTitlePreview() {
      const titleBlack = document.getElementById('title_black').value;
      const titleGreen = document.getElementById('title_green').value;
      const fullTitle = titleBlack + (titleGreen ? ' ' + titleGreen : '');
      
      // Add live preview
      const previewDiv = document.getElementById('title-preview');
      if (previewDiv) {
        previewDiv.innerHTML = '<strong>Preview:</strong> ' + 
          (titleBlack ? '<span class="text-dark">' + titleBlack + '</span>' : '') +
          (titleGreen ? ' <span class="text-success">' + titleGreen + '</span>' : '');
      }
    }
    
    // Load features template
    function loadFeaturesTemplate() {
      const template = [
        {
          "title": "Oxygenated Technology",
          "description": "Advanced oxygen injection for consistent bounce and durability from match to match."
        },
        {
          "title": "Street-Tested Durability", 
          "description": "Built to withstand the toughest playing conditions and heavy usage on any surface."
        },
        {
          "title": "Enhanced Performance",
          "description": "Superior grip and flight characteristics that enhance gameplay experience."
        },
        {
          "title": "Best in Sri Lanka",
          "description": "Manufactured with pride in Sri Lanka using the finest materials and techniques."
        },
        {
          "title": "Consistent Quality",
          "description": "Every ball maintains its shape, feel, and performance throughout its lifespan."
        },
        {
          "title": "Proven Performance",
          "description": "Trusted by players across Sri Lanka for superior playability and reliability."
        }
      ];
      
      document.getElementById('features_json').value = JSON.stringify(template, null, 2);
    }
    
    // Load specifications template
    function loadSpecsTemplate() {
      const template = [
        {
          "title": "Material",
          "description": "High-quality leather with synthetic reinforcement for durability"
        },
        {
          "title": "Weight", 
          "description": "Official weight standards (140-163g) meeting international regulations"
        },
        {
          "title": "Diameter",
          "description": "Regulation size (71-73mm circumference) for consistent performance"
        },
        {
          "title": "Core Technology",
          "description": "Advanced oxygen injection system for enhanced bounce retention"
        },
        {
          "title": "Finish",
          "description": "Premium surface treatment for optimal grip and longevity"
        }
      ];
      
      document.getElementById('specifications_json').value = JSON.stringify(template, null, 2);
    }
    
    // Preview features in modal
    function previewFeatures() {
      try {
        const featuresJson = document.getElementById('features_json').value;
        const features = JSON.parse(featuresJson || '[]');
        
        // Ensure we have 6 features
        while (features.length < 6) {
          features.push({title: '', description: ''});
        }
        
        // Create preview HTML
        let previewHTML = `
          <div class="alert alert-info mb-3">
            <strong>🎯 Preview: 6 Feature Boxes for "Why Choose Us" Section</strong>
            <br><small>This is how the 6 boxes will appear on the product page</small>
          </div>
          <div class="row g-3 mb-4">
        `;
        
        features.slice(0, 6).forEach((feature, index) => {
          previewHTML += `
          <div class="col-md-4">
            <div class="card h-100">
              <div class="card-body">
                <h6 class="card-title text-muted">Box ${index + 1}</h6>
                ${feature.title ? `<h6 class="text-primary">${feature.title}</h6>` : '<small class="text-muted">❌ No title</small>'}
                ${feature.description ? `<p class="card-text">${feature.description}</p>` : '<small class="text-muted">❌ No description</small>'}
              </div>
            </div>
          </div>
          `;
        });
        
        previewHTML += `</div>`;
        
        // Show in Swal modal if available, otherwise alert
        if (typeof Swal !== 'undefined') {
          Swal.fire({
            title: '6 Feature Boxes Preview',
            html: previewHTML,
            width: '800px',
            confirmButtonText: 'Close'
          });
        } else {
          // Simple alert fallback
          let message = 'Feature Preview:\n\n';
          features.slice(0, 6).forEach((feature, index) => {
            message += `${index + 1}. ${feature.title || 'No Title'}\n`;
            if (feature.description) message += `   ${feature.description.substring(0, 50)}...\n`;
            message += '\n';
          });
        Swal.fire({
          title: 'Feature Preview',
          text: message,
          icon: 'info',
          confirmButtonText: 'Close'
        });
        }
        
      } catch (e) {
        Swal.fire({
          title: 'Invalid Format',
          text: 'Invalid JSON format. Please check your features data.',
          icon: 'error',
          confirmButtonText: 'OK'
        });
      }
    }
    
    // Clear features
    function clearFeatures() {
      // Clear all UI fields
      for (let i = 0; i < 6; i++) {
        document.getElementById(`feature_title_${i}`).value = '';
        document.getElementById(`feature_description_${i}`).value = '';
      }
      
      // Update hidden JSON field
      updateFeaturesJSON();
      
      // Show success message
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          title: 'Cleared!',
          text: 'All feature boxes have been cleared.',
          icon: 'info',
          timer: 1500,
          showConfirmButton: false
        });
      }
    }
    
    // Update features JSON from UI fields
    function updateFeaturesJSON() {
      const features = [];
      
      for (let i = 0; i < 6; i++) {
        const title = document.getElementById(`feature_title_${i}`).value.trim();
        const description = document.getElementById(`feature_description_${i}`).value.trim();
        
        if (title || description) {
          features.push({
            title: title,
            description: description
          });
        } else {
          features.push({
            title: '',
            description: ''
          });
        }
      }
      
      document.getElementById('features_json').value = JSON.stringify(features, null, 2);
    }
    
    // Preview feature boxes
    function previewFeatureBoxes() {
      const features = [];
      
      for (let i = 0; i < 6; i++) {
        const title = document.getElementById(`feature_title_${i}`).value.trim();
        const description = document.getElementById(`feature_description_${i}`).value.trim();
        features.push({title, description});
      }
      
      let previewHTML = `
        <div class="alert alert-info mb-3">
          <strong>🎯 Preview: 6 Feature Boxes</strong>
          <br><small>This is how they'll appear on the product page</small>
        </div>
        <div class="row g-3 mb-4">
      `;
      
      features.forEach((feature, index) => {
        previewHTML += `
        <div class="col-md-4">
          <div class="card h-100">
            <div class="card-body">
              <h6 class="card-title text-muted">Box ${index + 1}</h6>
              ${feature.title ? `<h6 class="text-primary">${feature.title}</h6>` : '<small class="text-muted">❌ No title</small>'}
              ${feature.description ? `<p class="card-text">${feature.description}</p>` : '<small class="text-muted">❌ No description</small>'}
            </div>
          </div>
        </div>
        `;
      });
      
      previewHTML += '</div>';
      
      // Show in SweetAlert modal
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          title: 'Feature Boxes Preview',
          html: previewHTML,
          width: '800px',
          confirmButtonText: 'Close'
        });
      } else {
        // Simple alert fallback
        let message = 'Feature Preview:\n\n';
        features.forEach((feature, index) => {
          message += `${index + 1}. ${feature.title || 'No Title'}\n`;
          if (feature.description) message += `   ${feature.description.substring(0, 50)}...\n`;
          message += '\n';
        });
        Swal.fire({
          title: 'Feature Preview',
          text: message,
          icon: 'info',
          confirmButtonText: 'Close'
        });
      }
    }
    
    // Load default features
    function loadDefaultFeatures() {
      const defaultFeatures = [
        {
          title: 'Oxygenated Technology',
          description: 'Our cutting-edge oxygen injection system ensures consistent bounce and durability from match match.'
        },
        {
          title: 'Street-Tested Durability',
          description: 'Built to withstand the toughest playing conditions, this ball maintains its shape and performance.'
        },
        {
          title: 'Enhanced Performance',
          description: 'Superior grip and flight characteristics that enhance gameplay for players of all levels.'
        },
        {
          title: 'Best in Sri Lanka',
          description: 'Manufactured with pride in Sri Lanka using the finest materials and techniques.'
        },
        {
          title: 'Consistent Quality',
          description: 'Every ball maintains its shape, feel, and performance throughout its entire lifespan.'
        },
        {
          title: 'Proven Performance',
          description: 'Trusted by players across Sri Lanka for superior playability and unmatched reliability.'
        }
      ];
      
      defaultFeatures.forEach((feature, index) => {
        document.getElementById(`feature_title_${index}`).value = feature.title;
        document.getElementById(`feature_description_${index}`).value = feature.description;
      });
      
      // Update hidden JSON field
      updateFeaturesJSON();
      
      // Show success message
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          title: 'Loaded!',
          text: '6 default features have been loaded.',
          icon: 'success',
          timer: 1500,
          showConfirmButton: false
        });
      }
    }
    
    // Clear all features
    function clearAllFeatures() {
      clearFeatures();
    }
    
    // SPECIFICATIONS FUNCTIONS
    
    // Load default specifications
    function loadDefaultSpecs() {
      const defaultSpecs = [
        {
          title: 'Material',
          description: 'High-quality leather with synthetic reinforcement for durability'
        },
        {
          title: 'Weight', 
          description: 'Official weight standards (140-163g) meeting international regulations'
        },
        {
          title: 'Diameter',
          description: 'Regulation size (71-73mm circumference) for consistent performance'
        }
      ];
      
      defaultSpecs.forEach((spec, index) => {
        document.getElementById(`spec_title_${index}`).value = spec.title;
        document.getElementById(`spec_description_${index}`).value = spec.description;
      });
      
      // Update hidden JSON field
      updateSpecificationsJSON();
      
      // Show success message
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          title: 'Loaded!',
          text: 'Default specifications have been loaded.',
          icon: 'success',
          timer: 1500,
          showConfirmButton: false
        });
      }
    }
    
    // Preview specifications
    function previewSpecifications() {
      const specs = [];
      
      for (let i = 0; i < 3; i++) {
        const title = document.getElementById(`spec_title_${i}`).value.trim();
        const description = document.getElementById(`spec_description_${i}`).value.trim();
        specs.push({title, description});
      }
      
      let previewHTML = `
        <div class="alert alert-info mb-3">
          <strong>⚙️ Preview: Product Specifications</strong>
          <br><small>This is how they'll appear on the product page</small>
        </div>
        <div class="row g-3 mb-4">
      `;
      
      specs.forEach((spec, index) => {
        previewHTML += `
        <div class="col-md-6">
          <div class="card h-100">
            <div class="card-body">
              <h6 class="card-title text-muted">Spec ${index + 1}</h6>
              ${spec.title ? `<h6 class="text-secondary">${spec.title}</h6>` : '<small class="text-muted">❌ No title</small>'}
              ${spec.description ? `<p class="card-text">${spec.description}</p>` : '<small class="text-muted">❌ No description</small>'}
            </div>
          </div>
        </div>
        `;
      });
      
      previewHTML += '</div>';
      
      // Show in SweetAlert modal
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          title: 'Specifications Preview',
          html: previewHTML,
          width: '800px',
          confirmButtonText: 'Close'
        });
      } else {
        // Simple alert fallback
        let message = 'Specifications Preview:\n\n';
        specs.forEach((spec, index) => {
          message += `${index + 1}. ${spec.title || 'No Title'}\n`;
          if (spec.description) message += `   ${spec.description.replace(0, 50)}...\n`;
          message += '\n';
        });
        Swal.fire({
          title: 'Feature Preview',
          text: message,
          icon: 'info',
          confirmButtonText: 'Close'
        });
      }
    }
    
    // Clear specifications
    function clearAllSpecs() {
      // Clear all UI fields
      for (let i = 0; i < 3; i++) {
        document.getElementById(`spec_title_${i}`).value = '';
        document.getElementById(`spec_description_${i}`).value = '';
      }
      
      // Update hidden JSON field
      updateSpecificationsJSON();
      
      // Show success message
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          title: 'Cleared!',
          text: 'All specifications have been cleared.',
          icon: 'info',
          timer: 1500,
          showConfirmButton: false
        });
      }
    }
    
    // Update specifications JSON from UI fields
    function updateSpecificationsJSON() {
      const specifications = [];
      
      for (let i = 0; i < 3; i++) {
        const title = document.getElementById(`spec_title_${i}`).value.trim();
        const description = document.getElementById(`spec_description_${i}`).value.trim();
        
        if (title || description) {
          specifications.push({
            title: title,
            description: description
          });
        } else {
          specifications.push({
            title: '',
            description: ''
          });
        }
      }
      
      document.getElementById('specifications_json').value = JSON.stringify(specifications, null, 2);
    }
    
    // IMAGE UPLOAD FUNCTIONS
    
    // Handle main product image upload
    document.addEventListener('DOMContentLoaded', function() {
      const mainImageUpload = document.getElementById('main_image_upload');
      const featuredHomeImageUpload = document.getElementById('featured_home_image_upload');
      const specImageUpload = document.getElementById('spec_image_upload');
      
      if (mainImageUpload) {
        mainImageUpload.addEventListener('change', function(e) {
          handleImageUpload(e, 'main-image-preview', 'main_image', 'main-image-preview-container', 'main');
          // Trigger validation after image upload
          setTimeout(() => validateField('main_image', document.getElementById('main_image').value), 1000);
        });
      }
      
      if (featuredHomeImageUpload) {
        featuredHomeImageUpload.addEventListener('change', function(e) {
          handleImageUpload(e, 'featured-home-image-preview', 'featured_home_image', 'featured-home-image-preview-container', 'featured-home');
          // Trigger validation after image upload
          setTimeout(() => validateField('featured_home_image', document.getElementById('featured_home_image').value), 1000);
        });
      }
      
      if (specImageUpload) {
        specImageUpload.addEventListener('change', function(e) {
          handleImageUpload(e, 'spec-image-preview', 'specifications_image', 'spec-image-preview-container', 'spec');
        });
      }
    });
    
    // AJAX Validation Functions
    let validationTimeout;
    let isValidationInProgress = false;
    
    // Debounced validation function
    function validateField(fieldName, value) {
        clearTimeout(validationTimeout);
        validationTimeout = setTimeout(() => {
            performValidation();
        }, 500); // Wait 500ms after user stops typing
    }
    
    // Auto-format slug as user types
    function formatSlug(input) {
        let value = input.value;
        
        // Convert to lowercase
        value = value.toLowerCase();
        
        // Replace spaces and special characters with hyphens
        value = value.replace(/[^a-z0-9\-]/g, '-');
        
        // Remove multiple consecutive hyphens
        value = value.replace(/-+/g, '-');
        
        // Remove leading and trailing hyphens
        value = value.replace(/^-+|-+$/g, '');
        
        // Update the input value
        input.value = value;
        
        // Trigger validation
        validateField('slug', value);
    }
    
    // Perform AJAX validation
    function performValidation() {
        if (isValidationInProgress) return Promise.resolve();
        
        isValidationInProgress = true;
        
        // Collect form data
        const formData = new FormData();
        formData.append('csrf_token', document.querySelector('input[name="csrf_token"]').value);
        formData.append('title_black', document.getElementById('title_black').value);
        formData.append('title_green', document.getElementById('title_green').value);
        formData.append('subtitle', document.getElementById('subtitle').value);
        formData.append('description', document.getElementById('description').value);
        formData.append('main_image', document.getElementById('main_image').value);
        formData.append('featured_home_image', document.getElementById('featured_home_image').value);
        formData.append('meta_title', document.getElementById('meta_title').value);
        formData.append('meta_description', document.getElementById('meta_description').value);
        formData.append('slug', document.getElementById('slug').value);
        formData.append('display_order', document.getElementById('display_order').value);
        formData.append('features_json', document.getElementById('features_json').value);
        formData.append('specifications_json', document.getElementById('specifications_json').value);
        formData.append('product_id', <?= $product_id ?>); // Pass product ID for edit mode
        
        return fetch('validate-product.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            displayValidationResults(data);
            isValidationInProgress = false;
            return data; // Return data for further processing
        })
        .catch(error => {
            isValidationInProgress = false;
            throw error; // Re-throw error for catch handling
        });
    }
    
    // Display validation results
    function displayValidationResults(data) {
        // Clear previous validation states
        clearValidationStates();
        
        // Display field-specific errors below each field
        if (data.field_errors) {
            Object.keys(data.field_errors).forEach(fieldName => {
                const field = document.getElementById(fieldName);
                if (field) {
                    field.classList.add('is-invalid');
                    showFieldError(fieldName, data.field_errors[fieldName]);
                }
            });
        }
        
        // Display general errors (non-field specific) in a small box
        if (data.errors && data.errors.length > 0) {
            // Filter out field-specific errors to show only general ones
            const generalErrors = data.errors.filter(error => {
                // Check if this error is already shown as a field error
                return !Object.values(data.field_errors || {}).some(fieldError => 
                    fieldError.toLowerCase().includes(error.toLowerCase()) || 
                    error.toLowerCase().includes(fieldError.toLowerCase())
                );
            });
            
            if (generalErrors.length > 0) {
                showGeneralErrors(generalErrors);
            }
        }
        
        // Display warnings
        if (data.warnings && data.warnings.length > 0) {
            showWarnings(data.warnings);
        }
        
        // Update form validation state
        updateFormValidationState(data.success);
    }
    
    // Clear all validation states
    function clearValidationStates() {
        // Remove invalid classes
        document.querySelectorAll('.is-invalid').forEach(field => {
            field.classList.remove('is-invalid');
        });
        
        // Remove field error messages
        document.querySelectorAll('.field-error').forEach(error => {
            error.remove();
        });
        
        // Clear general error/warning messages
        const errorContainer = document.getElementById('validation-errors');
        const warningContainer = document.getElementById('validation-warnings');
        if (errorContainer) errorContainer.innerHTML = '';
        if (warningContainer) warningContainer.innerHTML = '';
    }
    
    // Show field-specific error
    function showFieldError(fieldName, message) {
        const field = document.getElementById(fieldName);
        if (!field) return;
        
        // Remove existing error
        const existingError = field.parentNode.querySelector('.field-error');
        if (existingError) existingError.remove();
        
        // Create error message container
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error invalid-feedback d-block text-danger small mt-1';
        errorDiv.innerHTML = `<i class="fi fi-rr-exclamation me-1"></i>${message}`;
        
        // Insert after the field's parent container
        const fieldContainer = field.closest('.mb-3') || field.parentNode;
        fieldContainer.appendChild(errorDiv);
        
        // Add shake animation to draw attention
        field.style.animation = 'shake 0.5s ease-in-out';
        setTimeout(() => {
            field.style.animation = '';
        }, 500);
    }
    
    // Show general errors
    function showGeneralErrors(errors) {
        let container = document.getElementById('validation-errors');
        if (!container) {
            container = document.createElement('div');
            container.id = 'validation-errors';
            container.className = 'alert alert-danger mt-3';
            document.querySelector('form').insertBefore(container, document.querySelector('form').firstChild);
        }
        
        container.innerHTML = '<strong>Please fix the following errors:</strong><ul class="mb-0 mt-2">' +
            errors.map(error => `<li>${error}</li>`).join('') + '</ul>';
    }
    
    // Show warnings
    function showWarnings(warnings) {
        let container = document.getElementById('validation-warnings');
        if (!container) {
            container = document.createElement('div');
            container.id = 'validation-warnings';
            container.className = 'alert alert-warning mt-3';
            document.querySelector('form').insertBefore(container, document.querySelector('form').firstChild);
        }
        
        container.innerHTML = '<strong>Recommendations:</strong><ul class="mb-0 mt-2">' +
            warnings.map(warning => `<li>${warning}</li>`).join('') + '</ul>';
    }
    
    // Update form validation state
    function updateFormValidationState(isValid) {
        const submitButton = document.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = !isValid;
            if (isValid) {
                submitButton.classList.remove('btn-secondary');
                submitButton.classList.add('btn-primary');
            } else {
                submitButton.classList.remove('btn-primary');
                submitButton.classList.add('btn-secondary');
            }
        }
    }
    
    // Generic image upload handler with compression
    function handleImageUpload(e, previewId, pathFieldId, containerId, type) {
      // Handle both event object and direct element reference
      const input = e.target || e;
      const file = input.files[0];
      if (file) {
        // Check file size (max 10MB - we'll compress it)
        if (file.size > 10 * 1024 * 1024) {
          Swal.fire({
            title: 'File Too Large',
            text: 'File size should be less than 10MB',
            icon: 'warning',
            confirmButtonText: 'OK'
          });
          input.value = '';
          return;
        }
        
        // Check file type
        if (!file.type.match('image.*')) {
          Swal.fire({
            title: 'Invalid File Type',
            text: 'Please select an image file',
            icon: 'warning',
            confirmButtonText: 'OK'
          });
          input.value = '';
          return;
        }
        
        // Show loading message
        showLoadingMessage(type);
        
        // Compress and process image
        compressImage(file, type, previewId, pathFieldId, containerId);
      }
    }
    
    // Image compression function
    function compressImage(file, type, previewId, pathFieldId, containerId) {
      const canvas = document.createElement('canvas');
      const ctx = canvas.getContext('2d');
      const img = new Image();
      
      img.onload = function() {
        // Calculate optimal dimensions
        const maxWidth = type === 'main' ? 1200 : 800;
        const maxHeight = type === 'main' ? 1200 : 600;
        
        let { width, height } = img;
        
        // Calculate new dimensions maintaining aspect ratio
        if (width > maxWidth || height > maxHeight) {
          const aspectRatio = width / height;
          if (width > height) {
            width = maxWidth;
            height = width / aspectRatio;
          } else {
            height = maxHeight;
            width = height * aspectRatio;
          }
        }
        
        // Set canvas dimensions
        canvas.width = width;
        canvas.height = height;
        
        // Draw image with high quality settings
        ctx.imageSmoothingEnabled = true;
        ctx.imageSmoothingQuality = 'high';
        ctx.drawImage(img, 0, 0, width, height);
        
        // Convert to compressed blob with quality settings based on file type
        const outputFormat = 'image/jpeg'; // Use JPEG for better compression
        const quality = 0.85; // High quality (85%)
        
        canvas.toBlob(function(compressedBlob) {
          // Generate unique filename with timestamp
          const timestamp = new Date().getTime();
          const fileName = `${type}_${timestamp}.jpg`;
          
          // Set appropriate upload directory based on type
          let uploadDir = 'uploads/main/';
          if (type === 'featured-home') {
            uploadDir = 'uploads/featured-home/';
          } else if (type === 'spec') {
            uploadDir = 'uploads/spec/';
          }
          
          const imagePath = uploadDir + fileName;
          
          // Store compression details for later use
          const originalSize = formatFileSize(file.size);
          const compressedSize = formatFileSize(compressedBlob.size);
          const compressionRatio = ((file.size - compressedBlob.size) / file.size * 100).toFixed(1);
          
          // Upload the compressed image to server
          uploadCompressedImage(compressedBlob, fileName, type, pathFieldId, previewId, containerId, originalSize, compressedSize, compressionRatio);
          
          // Store compressed blob for later use
          storeCompressedImage(type, compressedBlob, fileName);
          
          hideLoadingMessage();
          
        }, outputFormat, quality);
      };
      
      // Load the image
      const reader = new FileReader();
      reader.onload = function(e) {
        img.src = e.target.result;
      };
      reader.readAsDataURL(file);
    }
    
    // Store compressed images for upload
    window.compressedImages = window.compressedImages || {};
    
    function storeCompressedImage(type, blob, fileName) {
      window.compressedImages[type] = {
        blob: blob,
        fileName: fileName
      };
    }
    
    // Upload compressed image to server
    function uploadCompressedImage(blob, fileName, type, pathFieldId, previewId, containerId, originalSize, compressedSize, compressionRatio) {
      const formData = new FormData();
      formData.append('image', blob, fileName);
      formData.append('type', type);
      
      fetch('upload-image.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Update the path field with the actual uploaded path
          document.getElementById(pathFieldId).value = data.path;
          
          // Show preview with the uploaded image
          const preview = document.getElementById(previewId);
          const container = document.getElementById(containerId);
          preview.src = '../' + data.path;
          container.style.display = 'block';
          
          // Show success message with compression details
          if (typeof Swal !== 'undefined') {
            Swal.fire({
              title: 'Image Compressed & Uploaded!',
              html: `Original: <strong>${originalSize}</strong><br>Compressed: <strong>${compressedSize}</strong><br>Saved: <strong>${compressionRatio}%</strong>`,
              icon: 'success',
              timer: 2000,
              showConfirmButton: false
            });
          }
        } else {
          if (typeof Swal !== 'undefined') {
            Swal.fire({
              title: 'Upload Failed',
              text: data.message,
              icon: 'error'
            });
          }
        }
      })
      .catch(error => {
        if (typeof Swal !== 'undefined') {
          Swal.fire({
            title: 'Upload Error',
            text: 'Failed to upload image. Please try again.',
            icon: 'error'
          });
        }
      });
    }
    
    // Get compressed image for upload
    function getCompressedImage(type) {
      return window.compressedImages[type] || null;
    }
    
    // Clear compressed image storage
    function clearCompressedImage(type) {
      if (window.compressedImages[type]) {
        delete window.compressedImages[type];
      }
    }
    
    // Showing messages and handling UI
    function showLoadingMessage(type) {
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          title: 'Compressing Image...',
          text: `Please wait while we compress your ${type} image for optimal quality.`,
          icon: 'info',
          allowOutsideClick: false,
          showConfirmButton: false,
          timerProgressBar: true,
          timer: 3000
        });
      }
    }
    
    function hideLoadingMessage() {
      if (typeof Swal !== 'undefined') {
        Swal.close();
      }
    }
    
    function showCompressionMessage(type, originalSize, compressedSize, compressionRatio, imagePath) {
      if (typeof Swal !== 'undefined') {
        const message = `
          <div style="text-align: left;">
            <strong>✅ Image Compressed Successfully!</strong><br><br>
            <strong>Original Size:</strong> ${originalSize}<br>
            <strong>Compressed Size:</strong> ${compressedSize}<br>
            <strong>Space Saved:</strong> ${compressionRatio}%<br><br>
            <strong>Path:</strong> ${imagePath}<br>
            <small class="text-muted">📱 Optimized for web without quality loss</small>
          </div>
        `;
        
        Swal.fire({
          title: `${type.charAt(0).toUpperCase() + type.slice(1)} Image Ready!`,
          html: message,
          icon: 'success',
          timer: 4000,
          showConfirmButton: false
        });
      } else {
        Swal.fire({
          title: 'Image Compressed',
          text: `${type.charAt(0).toUpperCase() + type.slice(1)} image compressed! Size reduced by ${compressionRatio}%`,
          icon: 'success',
          confirmButtonText: 'OK'
        });
      }
    }
    
    
    // Format file size helper function
    function formatFileSize(bytes) {
      if (bytes === 0) return '0 Bytes';
      const k = 1024;
      const sizes = ['Bytes', 'KB', 'MB', 'GB'];
      const i = Math.floor(Math.log(bytes) / Math.log(k));
      return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
    // Product creation confirmation with AJAX validation
    function confirmCreate() {
      // First, perform AJAX validation
      performValidation().then(() => {
        // Check if validation passed
        const hasErrors = document.querySelectorAll('.is-invalid').length > 0;
        const hasGeneralErrors = document.getElementById('validation-errors');
        
        if (hasErrors || (hasGeneralErrors && hasGeneralErrors.innerHTML.trim() !== '')) {
          // Show validation errors
          Swal.fire({
            title: 'Please Fix Validation Errors',
            html: 'There are validation errors that need to be fixed before creating the product. Please review the form and correct any issues.',
            icon: 'error',
            confirmButtonText: 'OK',
            confirmButtonColor: '#d33'
          });
          return false;
        }
        
        // If validation passed, show confirmation dialog
        Swal.fire({
          title: 'Update Product?',
          text: 'Are you sure you want to update this product? Please review all information before proceeding.',
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, update product!',
          cancelButtonText: 'Cancel',
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {
            // Submit the form
            document.querySelector('form[onsubmit*="confirmCreate"]').submit();
          } else {
            // Prevent form submission
            return false;
          }
        });
      }).catch(error => {
        // If validation fails, show error and don't proceed
        Swal.fire({
          title: 'Validation Error',
          text: 'Unable to validate the form. Please check your connection and try again.',
          icon: 'error',
          confirmButtonText: 'OK',
          confirmButtonColor: '#d33'
        });
        return false;
      });
      
      return false; // Prevent immediate form submission
    }
    
    // Product update confirmation with AJAX validation
    function confirmUpdate() {
      // First, perform AJAX validation
      performValidation().then(() => {
        // Check if validation passed
        const hasErrors = document.querySelectorAll('.is-invalid').length > 0;
        const hasGeneralErrors = document.getElementById('validation-errors');
        
        if (hasErrors || (hasGeneralErrors && hasGeneralErrors.innerHTML.trim() !== '')) {
          // Show validation errors
          Swal.fire({
            title: 'Please Fix Validation Errors',
            html: 'There are validation errors that need to be fixed before updating the product. Please review the form and correct any issues.',
            icon: 'error',
            confirmButtonText: 'OK',
            confirmButtonColor: '#d33'
          });
          return false;
        }
        
        // If validation passed, show confirmation dialog
        Swal.fire({
          title: 'Update Product?',
          text: 'Are you sure you want to update this product? This will change the product information visible to website visitors.',
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, update product!',
          cancelButtonText: 'Cancel',
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {
            // Show loading
            Swal.fire({
              title: 'Updating Product...',
              text: 'Please wait while we update your product.',
              icon: 'info',
              allowOutsideClick: false,
              showConfirmButton: false,
              didOpen: () => {
                Swal.showLoading();
              }
            });
            
            // Submit the form via AJAX
            const form = document.querySelector('form[onsubmit*="confirmUpdate"]');
            const formData = new FormData(form);
            
            fetch(form.action || window.location.href, {
              method: 'POST',
              body: formData,
              headers: {
                'X-Requested-With': 'XMLHttpRequest'
              }
            })
            .then(response => {
              if (response.ok) {
                // Show success message
                Swal.fire({
                  title: 'Product Updated!',
                  text: 'Your product has been successfully updated.',
                  icon: 'success',
                  confirmButtonText: 'View Products',
                  confirmButtonColor: '#28a745'
                }).then(() => {
                  // Redirect to products page
                  window.location.href = 'products.php';
                });
              } else {
                throw new Error('Server error');
              }
            })
            .catch(error => {
              Swal.fire({
                title: 'Error',
                text: 'There was an error updating the product. Please try again.',
                icon: 'error',
                confirmButtonText: 'OK'
              });
            });
          } else {
            // Prevent form submission
            return false;
          }
        });
      }).catch(error => {
        // If validation fails, show error and don't proceed
        Swal.fire({
          title: 'Validation Error',
          text: 'Unable to validate the form. Please check your connection and try again.',
          icon: 'error',
          confirmButtonText: 'OK',
          confirmButtonColor: '#d33'
        });
        return false;
      });
      
      return false; // Prevent immediate form submission
    }
    
    // Clear main image path
    function clearMainImagePath() {
      document.getElementById('main_image').value = '';
      document.getElementById('main_image_upload').value = '';
      document.getElementById('main-image-preview').src = '';
      document.getElementById('main-image-preview-container').style.display = 'none';
      clearCompressedImage('main'); // Clear compressed image storage
      
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          title: 'Cleared!',
          text: 'Main image path and compressed data cleared.',
          icon: 'info',
          timer: 1500,
          showConfirmButton: false
        });
      }
    }
    
    // Clear featured home image path
    function clearFeaturedHomeImagePath() {
      document.getElementById('featured_home_image').value = '';
      document.getElementById('featured_home_image_upload').value = '';
      document.getElementById('featured-home-image-preview').src = '';
      document.getElementById('featured-home-image-preview-container').style.display = 'none';
      clearCompressedImage('featured-home'); // Clear compressed image storage
      
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          title: 'Cleared!',
          text: 'Featured home image path and compressed data cleared.',
          icon: 'info',
          timer: 1500,
          showConfirmButton: false
        });
      }
    }
    
    // Clear specifications image path
    function clearSpecImagePath() {
      document.getElementById('specifications_image').value = '';
      document.getElementById('spec_image_upload').value = '';
      document.getElementById('spec-image-preview').src = '';
      document.getElementById('spec-image-preview-container').style.display = 'none';
      clearCompressedImage('spec'); // Clear compressed image storage
      
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          title: 'Cleared!',
          text: 'Specifications image path and compressed data cleared.',
          icon: 'info',
          timer: 1500,
          showConfirmButton: false
        });
      }
    }
    
    // Generate slug from product title
    function generateSlug() {
      const titleBlack = document.getElementById('title_black').value;
      const titleGreen = document.getElementById('title_green').value;
      const fullTitle = (titleBlack + ' ' + titleGreen).trim();
      
      if (fullTitle) {
        // Convert to slug format using the same logic as formatSlug
        let slug = fullTitle.toLowerCase()
          .replace(/[^a-z0-9\-]/g, '-') // Replace spaces and special characters with hyphens
          .replace(/-+/g, '-') // Remove multiple consecutive hyphens
          .replace(/^-+|-+$/g, ''); // Remove leading and trailing hyphens
        
        document.getElementById('slug').value = slug;
        
        // Trigger validation
        validateField('slug', slug);
        
        if (typeof Swal !== 'undefined') {
          Swal.fire({
            title: 'Slug Generated!',
            text: `Generated slug: ${slug}`,
            icon: 'success',
            timer: 2000,
            showConfirmButton: false
          });
        }
      } else {
        if (typeof Swal !== 'undefined') {
          Swal.fire({
            title: 'No Title Found',
            text: 'Please enter a product title first.',
            icon: 'warning',
            timer: 2000,
            showConfirmButton: false
          });
        }
      }
    }
    
    // Update character count for meta fields
    function updateMetaTitleCount() {
      const metaTitle = document.getElementById('meta_title');
      const countElement = document.getElementById('meta_title_count');
      
      if (!metaTitle || !countElement) return;
      
      const count = metaTitle.value.length;
      countElement.textContent = `${count}/60 characters`;
      
      if (count > 60) {
        countElement.className = 'text-danger small';
      } else if (count > 50) {
        countElement.className = 'text-warning small';
      } else {
        countElement.className = 'text-muted small';
      }
    }
    
    function updateMetaDescriptionCount() {
      const metaDescription = document.getElementById('meta_description');
      const countElement = document.getElementById('meta_description_count');
      
      if (!metaDescription || !countElement) return;
      
      const count = metaDescription.value.length;
      countElement.textContent = `${count}/160 characters`;
      
      if (count > 160) {
        countElement.className = 'text-danger small';
      } else if (count > 150) {
        countElement.className = 'text-warning small';
      } else {
        countElement.className = 'text-muted small';
      }
    }
    
    // Show existing images on page load
    function showExistingImages() {
      // Main image
      const mainImagePath = document.getElementById('main_image').value;
      if (mainImagePath) {
        const preview = document.getElementById('main-image-preview');
        const container = document.getElementById('main-image-preview-container');
        if (preview && container) {
          // Try different path approaches
          const paths = [
            '../' + mainImagePath,
            '/' + mainImagePath,
            mainImagePath
          ];
          
          let currentPathIndex = 0;
          
          function tryNextPath() {
            if (currentPathIndex < paths.length) {
              const testPath = paths[currentPathIndex];
              
              preview.src = testPath;
              preview.onload = function() {
                container.style.display = 'block';
              };
              preview.onerror = function() {
                currentPathIndex++;
                tryNextPath();
              };
            } else {
              container.style.display = 'none';
            }
          }
          
          tryNextPath();
        }
      }
      
      // Featured home image
      const featuredImagePath = document.getElementById('featured_home_image').value;
      if (featuredImagePath) {
        const preview = document.getElementById('featured-home-image-preview');
        const container = document.getElementById('featured-home-image-preview-container');
        if (preview && container) {
          // Try different path approaches
          const paths = [
            '../' + featuredImagePath,
            '/' + featuredImagePath,
            featuredImagePath
          ];
          
          let currentPathIndex = 0;
          
          function tryNextPath() {
            if (currentPathIndex < paths.length) {
              const testPath = paths[currentPathIndex];
              
              preview.src = testPath;
              preview.onload = function() {
                container.style.display = 'block';
              };
              preview.onerror = function() {
                currentPathIndex++;
                tryNextPath();
              };
            } else {
              container.style.display = 'none';
            }
          }
          
          tryNextPath();
        }
      }
      
      // Specifications image
      const specImagePath = document.getElementById('specifications_image').value;
      if (specImagePath) {
        const preview = document.getElementById('spec-image-preview');
        const container = document.getElementById('spec-image-preview-container');
        if (preview && container) {
          // Try different path approaches
          const paths = [
            '../' + specImagePath,
            '/' + specImagePath,
            specImagePath
          ];
          
          let currentPathIndex = 0;
          
          function tryNextPath() {
            if (currentPathIndex < paths.length) {
              const testPath = paths[currentPathIndex];
              
              preview.src = testPath;
              preview.onload = function() {
                container.style.display = 'block';
              };
              preview.onerror = function() {
                currentPathIndex++;
                tryNextPath();
              };
            } else {
              container.style.display = 'none';
            }
          }
          
          tryNextPath();
        }
      }
    }
    
    // Attach event listeners
    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('title_black').addEventListener('input', function() {
        updateTitlePreview();
        validateField('title_black', this.value);
      });
      document.getElementById('title_green').addEventListener('input', function() {
        updateTitlePreview();
        validateField('title_green', this.value);
      });
      
      // SEO field character counting
      document.getElementById('meta_title').addEventListener('input', function() {
        updateMetaTitleCount();
        validateField('meta_title', this.value);
      });
      document.getElementById('meta_description').addEventListener('input', function() {
        updateMetaDescriptionCount();
        validateField('meta_description', this.value);
      });
      
      // Add validation to other required fields
      document.getElementById('subtitle').addEventListener('input', function() {
        validateField('subtitle', this.value);
      });
      document.getElementById('description').addEventListener('input', function() {
        validateField('description', this.value);
      });
      document.getElementById('slug').addEventListener('input', function() {
        formatSlug(this);
      });
      document.getElementById('display_order').addEventListener('input', function() {
        validateField('display_order', this.value);
      });
      
      // Initialize character counts
      updateMetaTitleCount();
      updateMetaDescriptionCount();
      updateTagsPreview();
      
      // Show existing images
      showExistingImages();
      
      // Auto-update JSON when feature fields change
      for (let i = 0; i < 6; i++) {
        const titleField = document.getElementById(`feature_title_${i}`);
        const descField = document.getElementById(`feature_description_${i}`);
        
        if (titleField) titleField.addEventListener('input', updateFeaturesJSON);
        if (descField) descField.addEventListener('input', updateFeaturesJSON);
      }
      
      // Auto-update JSON when specification fields change
      for (let i = 0; i < 3; i++) {
        const titleField = document.getElementById(`spec_title_${i}`);
        const descField = document.getElementById(`spec_description_${i}`);
        
        if (titleField) titleField.addEventListener('input', updateSpecificationsJSON);
        if (descField) descField.addEventListener('input', updateSpecificationsJSON);
      }
      
      // Add preview div if it doesn't exist
      const titleContainer = document.querySelector('#title_black').closest('.mb-3');
      if (titleContainer && !document.getElementById('title-preview')) {
        const previewDiv = document.createElement('div');
        previewDiv.id = 'title-preview';
        previewDiv.className = 'mt-2 text-muted';
        titleContainer.appendChild(previewDiv);
        updateTitlePreview();
      }
    });
  </script>
  
  <!-- Scripts -->
  <script src="../dashboard ui/dist/assets/js/vendors.min.js"></script>
  <script src="../dashboard ui/dist/assets/js/common-init.min.js"></script>
  
  <!-- Menu Backdrop -->
  <div class="edash-menu-backdrop" id="edash-menu-hide"></div>
</body>
</html>