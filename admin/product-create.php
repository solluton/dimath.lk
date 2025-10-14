<?php
// Check if this is an AJAX request first
$isAjax = isset($_POST['ajax']) && $_POST['ajax'] === '1';

// Include required files
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/csrf.php';

// For AJAX requests, handle authentication differently
if ($isAjax) {
    // Check authentication
    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        // Clear any output buffer to ensure clean JSON
        if (ob_get_level()) {
            ob_clean();
        }
        
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => 'Authentication required. Please log in.'
        ]);
        exit();
    }
} else {
    // For non-AJAX requests, use normal authentication
requireLogin();
}

$user = getCurrentUser();

// Check if we're in edit mode
$isEditMode = isset($_GET['id']) && !empty($_GET['id']);
$product_id = $isEditMode ? (int)$_GET['id'] : null;

// Also check for edit mode from form submission
if (!$isEditMode && isset($_POST['edit_mode']) && isset($_POST['product_id'])) {
    $isEditMode = true;
    $product_id = (int)$_POST['product_id'];
}
$product = null;

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
    'title' => '',
    'subtitle' => '',
    'slug' => '',
    'description' => '',
    'details' => '',
    'tagline' => '',
    'key_features' => '',
    'features_section_title' => '',
    'features_section_subtitle' => '',
    'main_image' => '',
    'image_1' => '',
    'image_2' => '',
    'image_3' => '',
    'image_4' => '',
    'image_5' => '',
    'image_6' => '',
    'featured_home_image' => '',
    'meta_title' => '',
    'meta_description' => '',
    'status' => 'active',
    'display_order' => 0,
    'enable_featured_home' => false,
    'enable_featured_slider' => false,
    'category_id' => null
];

// If in edit mode, populate form data with existing product data
if ($isEditMode && $product) {
    $formData = [
        'title' => $product['title'] ?? '',
        'subtitle' => $product['subtitle'] ?? '',
        'slug' => $product['slug'] ?? '',
        'description' => $product['description'] ?? '',
        'details' => $product['details'] ?? '',
        'tagline' => $product['tagline'] ?? '',
        'key_features' => $product['key_features'] ?? '',
        'features_section_title' => $product['features_section_title'] ?? '',
        'features_section_subtitle' => $product['features_section_subtitle'] ?? '',
        'main_image' => $product['main_image'] ?? '',
        'image_1' => $product['image_1'] ?? '',
        'image_2' => $product['image_2'] ?? '',
        'image_3' => $product['image_3'] ?? '',
        'image_4' => $product['image_4'] ?? '',
        'image_5' => $product['image_5'] ?? '',
        'image_6' => $product['image_6'] ?? '',
        'featured_home_image' => $product['featured_home_image'] ?? '',
        'meta_title' => $product['meta_title'] ?? '',
        'meta_description' => $product['meta_description'] ?? '',
        'status' => $product['status'] ?? 'active',
        'display_order' => $product['display_order'] ?? 0,
        'enable_featured_home' => (bool)($product['enable_featured_home'] ?? false),
        'enable_featured_slider' => (bool)($product['enable_featured_slider'] ?? false),
        'category_id' => $product['category_id'] ?? null
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
        $title = trim($_POST['title'] ?? '');
        $subtitle = trim($_POST['subtitle'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $details = trim($_POST['details'] ?? '');
        $tagline = trim($_POST['tagline'] ?? '');
        $key_features = trim($_POST['key_features'] ?? '');
        $features_section_title = trim($_POST['features_section_title'] ?? '');
        $features_section_subtitle = trim($_POST['features_section_subtitle'] ?? '');
        $main_image = trim($_POST['main_image'] ?? '');
        $image_1 = trim($_POST['image_1'] ?? '');
        $image_2 = trim($_POST['image_2'] ?? '');
        $image_3 = trim($_POST['image_3'] ?? '');
        $image_4 = trim($_POST['image_4'] ?? '');
        $image_5 = trim($_POST['image_5'] ?? '');
        $image_6 = trim($_POST['image_6'] ?? '');
        $featured_home_image = trim($_POST['featured_home_image'] ?? '');
        $meta_title = trim($_POST['meta_title'] ?? '');
        $meta_description = trim($_POST['meta_description'] ?? '');
        $status = $_POST['status'] ?? 'active';
        $display_order = (int)($_POST['display_order'] ?? 0);
        $enable_featured_slider = (bool)($_POST['enable_featured_slider'] ?? false);
        $enable_featured_home = $enable_featured_slider ? 1 : 0;
        $category_id = isset($_POST['category_id']) && ctype_digit($_POST['category_id']) ? (int)$_POST['category_id'] : null;
        
        // Validation
        $errors = [];
        
        // Required field validation
        if (empty($title)) {
            $errors[] = 'Product Title is required';
        }
        
        if (empty($slug)) {
            $errors[] = 'URL Slug is required';
        }
        
        if (empty($description)) {
            $errors[] = 'Product Description is required';
        }
        
        // Field length validation
        if (strlen($title) > 255) {
            $errors[] = 'Product Title must be 255 characters or less';
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
        
        // Image validation with edit-mode relaxations
        // Main image: required unless editing an item that already has a main image and it wasn't cleared
        if (empty($main_image)) {
            if (!($isEditMode && !empty($product['main_image']))) {
                $errors[] = 'Main Image is required';
            }
        }

        // Gallery: enforce 2/4/6 only if creating new OR gallery was changed during edit
        $postedGallery = array_values(array_filter([$image_1, $image_2, $image_3, $image_4, $image_5, $image_6], function($v){ return !empty($v); }));
        $enforceGalleryRule = true;
        if ($isEditMode) {
            $originalGallery = array_values(array_filter([
                $product['image_1'] ?? '',
                $product['image_2'] ?? '',
                $product['image_3'] ?? '',
                $product['image_4'] ?? '',
                $product['image_5'] ?? '',
                $product['image_6'] ?? ''
            ], function($v){ return !empty($v); }));
            // If posted equals original (no change), don't force re-add
            if ($postedGallery === $originalGallery) {
                $enforceGalleryRule = false;
            }
        }
        if ($enforceGalleryRule) {
            $galleryCount = count($postedGallery);
            if (!in_array($galleryCount, [2,4,6], true)) {
                $errors[] = 'Please provide exactly 2, 4, or 6 gallery images (currently ' . $galleryCount . ').';
            }
        }
        
        // If there are validation errors, don't proceed
        if (!empty($errors)) {
            // Handle AJAX validation error response
            if ($isAjax) {
                // Clear any output buffer to ensure clean JSON
                if (ob_get_level()) {
                    ob_clean();
                }
                
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'errors' => $errors,
                    'message' => 'Please fix the validation errors below.'
                ]);
                exit();
        } else {
                $error = implode('<br>', $errors);
            }
            } else {
        $pdo = getDBConnection();
        
            // Check if slug is unique (excluding current product in edit mode)
            $slug_check_sql = "SELECT id FROM products WHERE slug = ?";
            $slug_check_params = [$slug];
            
            if ($isEditMode) {
                $slug_check_sql .= " AND id != ?";
                $slug_check_params[] = $product_id;
            }
            
            $stmt = $pdo->prepare($slug_check_sql);
            $stmt->execute($slug_check_params);
            
            if ($stmt->fetch()) {
                $error = 'URL Slug already exists. Please choose a different slug.';
                
                // Handle AJAX error response
                if ($isAjax) {
                    // Clear any output buffer to ensure clean JSON
                    if (ob_get_level()) {
                        ob_clean();
                    }
                    
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => false,
                        'message' => $error
                    ]);
                    exit();
                }
            } else {
        // Insert or Update product based on mode
        if ($isEditMode) {
            // Update existing product
            $stmt = $pdo->prepare("
                UPDATE products SET 
                            title = ?, subtitle = ?, slug = ?, description = ?, details = ?, tagline = ?, key_features = ?, 
                            features_section_title = ?, features_section_subtitle = ?, main_image = ?, 
                            image_1 = ?, image_2 = ?, image_3 = ?, image_4 = ?, image_5 = ?, image_6 = ?,
                            featured_home_image = ?, meta_title = ?, meta_description = ?, category_id = ?, 
                            status = ?, display_order = ?, enable_featured_home = ?, enable_featured_slider = ?, 
                    updated_at = NOW()
                WHERE id = ?
            ");
            
            $stmt->execute([
                        $title, $subtitle, $slug, $description, $details, $tagline, $key_features,
                        $features_section_title, $features_section_subtitle, $main_image,
                        $image_1, $image_2, $image_3, $image_4, $image_5, $image_6,
                        $featured_home_image, $meta_title, $meta_description, $category_id,
                        $status, $display_order, $enable_featured_home, $enable_featured_slider, $product_id
            ]);
            
            $message = 'Product updated successfully!';
            
            // Create slug redirect if slug was changed
            if ($isEditMode && $product && $product['slug'] !== $slug) {
                try {
                    // Check if redirect already exists
                    $redirect_check = $pdo->prepare("SELECT id FROM slug_redirects WHERE old_slug = ? AND redirect_type = 'product'");
                    $redirect_check->execute([$product['slug']]);
                    
                    if (!$redirect_check->fetch()) {
                        // Create new redirect
                        $redirect_stmt = $pdo->prepare("
                            INSERT INTO slug_redirects (old_slug, new_slug, redirect_type, product_id, created_at) 
                            VALUES (?, ?, 'product', ?, NOW())
                        ");
                        $redirect_stmt->execute([$product['slug'], $slug, $product_id]);
                        
                        $message .= ' Slug redirect created from old URL.';
                    }
                } catch (Exception $e) {
                    error_log("Error creating slug redirect: " . $e->getMessage());
                    // Don't fail the update if redirect creation fails
                }
            }
        } else {
            // Insert new product
            $stmt = $pdo->prepare("
                INSERT INTO products (
                    title, subtitle, slug, description, details, tagline, key_features,
                    features_section_title, features_section_subtitle, main_image,
                    image_1, image_2, image_3, image_4, image_5, image_6,
                    featured_home_image, meta_title, meta_description, category_id,
                    status, display_order, enable_featured_home, enable_featured_slider,
                    created_at, updated_at
                )
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
            ");
            
            $stmt->execute([
                $title, $subtitle, $slug, $description, $details, $tagline, $key_features,
                $features_section_title, $features_section_subtitle, $main_image,
                $image_1, $image_2, $image_3, $image_4, $image_5, $image_6,
                $featured_home_image, $meta_title, $meta_description, $category_id,
                $status, $display_order, $enable_featured_home, $enable_featured_slider
            ]);
            
            $message = 'Product created successfully!';
        }
        
        // Handle AJAX response
        if ($isAjax) {
            // Clear any output buffer to ensure clean JSON
            if (ob_get_level()) {
                ob_clean();
            }
            
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => $message
            ]);
            exit();
        }
                
                // Redirect after successful operation (non-AJAX)
            header('Location: products.php');
            exit();
        }
        }
    } catch (Exception $e) {
        $error = 'Error saving product: ' . $e->getMessage();
        
        // Handle AJAX error response
        if ($isAjax) {
            // Clear any output buffer to ensure clean JSON
            if (ob_get_level()) {
                ob_clean();
            }
            
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => $error
            ]);
            exit();
        }
    }
}

// Generate CSRF token
$csrf_token = generateCSRFToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dimath Sports - Product Management">
    <meta name="keyword" content="dimath, sports, products, admin">
    <meta name="author" content="Dimath Sports">
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  
  <!-- Favicon -->
  <link href="../images/favicon.png" rel="shortcut icon" type="image/x-icon">
  <link href="../images/webclip.png" rel="apple-touch-icon">
  
  <!-- Title -->
    <title><?php echo $isEditMode ? 'Edit Product' : 'Add New Product'; ?> | Dimath Sports - Admin Dashboard</title>
  
  <!-- Dashboard UI CSS -->
  <link rel="stylesheet" href="../dashboard ui/dist/assets/vendors/metismenu/metisMenu.min.css">
  <link rel="stylesheet" href="../dashboard ui/dist/assets/vendors/@flaticon/flaticon-uicons/css/all/all.css">
  <link rel="stylesheet" type="text/css" href="../dashboard ui/dist/assets/css/theme.min.css">
  
    <!-- Dimath Custom Dashboard Colors -->
  <link rel="stylesheet" type="text/css" href="../css/dashboard-custom.css">
  
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <!-- Spinner Animation CSS -->
  <style>
    .spin {
      animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  </style>
  
  <!-- Force Light Mode Script -->
  <script>
    document.documentElement.setAttribute('data-bs-theme', 'light');
    localStorage.setItem('theme', 'light');
  </script>
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
                                <h2 class="h4 fw-semibold text-dark"><?php echo $isEditMode ? 'Edit Product' : 'Add New Product'; ?></h2>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                      <a href="dashboard.php">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                      <a href="products.php">Products</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                                            <?php echo $isEditMode ? 'Edit Product' : 'Add New Product'; ?>
                    </li>
                  </ol>
                </nav>
              </div>
              <div class="d-flex align-items-center gap-2">
                                <a href="products.php" class="btn btn-outline-primary">
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
                        <i class="fi fi-rr-exclamation me-2"></i><?php echo $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>

        <!-- Product Form -->
                <div class="row px-4">
                    <div class="col-12">
                <div class="card">
                  <div class="card-header">
                                <h6 class="card-title mb-0">Product Information</h6>
                  </div>
                  <div class="card-body">
                                <form method="POST" id="product-form">
                                    <?php if ($isEditMode): ?>
                                        <input type="hidden" name="edit_mode" value="1">
                                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                    <?php endif; ?>
                                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                    
                                    <!-- Basic Information -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h6 class="fw-semibold text-dark mb-3">Basic Information</h6>
                            </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="title" class="form-label">Product Title <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="title" name="title" 
                                                   value="<?php echo htmlspecialchars($formData['title']); ?>" 
                                                   placeholder="Enter product title (e.g., Alba Cinnamon - Premium Ceylon Cinnamon)" required>
                            </div>
                      <div class="col-md-6 mb-3">
                                            <label for="slug" class="form-label">URL Slug <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="slug" name="slug" 
                                                   value="<?php echo htmlspecialchars($formData['slug']); ?>" 
                                                   placeholder="product-url-slug (auto-generated from title)" required>
                                            <div class="form-text">
                                                Only lowercase letters, numbers, and hyphens allowed
                                                <?php if ($isEditMode): ?>
                                                    <br><small class="text-warning"><i class="fi fi-rr-info me-1"></i>Changing the slug will create a redirect from the old URL</small>
                                                <?php endif; ?>
                      </div>
                      </div>
                      <?php
                        // Fetch categories for dropdown
                        try {
                          $pdoTmp = getDBConnection();
                          $catStmt = $pdoTmp->query("SELECT id, name FROM product_categories WHERE status='active' ORDER BY display_order ASC, name ASC");
                          $allCategories = $catStmt->fetchAll(PDO::FETCH_ASSOC);
                        } catch (Exception $e) { $allCategories = []; }
                      ?>
                      <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-select" id="category_id" name="category_id">
                          <option value="">-- None --</option>
                          <?php foreach ($allCategories as $c): ?>
                            <option value="<?php echo (int)$c['id']; ?>" <?php echo (!empty($product['category_id']) && (int)$product['category_id']===(int)$c['id'])?'selected':''; ?>><?php echo htmlspecialchars($c['name']); ?></option>
                          <?php endforeach; ?>
                        </select>
                        <div class="form-text">Select from managed categories.</div>
                      </div>
                      <div class="col-12 mb-3">
                                            <label for="description" class="form-label">Summary Description <span class="text-danger">*</span></label>
                                            <textarea class="form-control" id="description" name="description" rows="3" 
                                                      placeholder="Short summary shown near the top of the product." required><?php echo htmlspecialchars($formData['description']); ?></textarea>
                                            <div class="form-text">Brief description of the product</div>
                      </div>
                      <div class="col-12 mb-3">
                                            <label for="details" class="form-label">Details</label>
                                            <textarea class="form-control" id="details" name="details" rows="6" placeholder="Full details for the expandable section."><?php echo htmlspecialchars($formData['details']); ?></textarea>
                      </div>
                      <div class="col-md-6 mb-3">
                        <div class="form-check mt-4">
                          <input class="form-check-input" type="checkbox" id="enable_featured_slider" name="enable_featured_slider" value="1" <?php echo !empty($formData['enable_featured_slider']) ? 'checked' : ''; ?>>
                          <label class="form-check-label" for="enable_featured_slider">Featured on Home Slider</label>
                        </div>
                      </div>
                                    <!-- Images -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h6 class="fw-semibold text-dark mb-3">Product Images</h6>
                      </div>
                      
                      <!-- Main Image -->
                                        <div class="col-md-6 mb-4">
                                            <label for="main_image" class="form-label">Main Image</label>
                                            <div class="image-upload-container">
                                                <input type="file" class="form-control mb-2" id="main_image_file" accept="image/*" onchange="previewImage(this, 'main_image_preview', 'main_image')">
                                                <input type="hidden" id="main_image" name="main_image" value="<?php echo htmlspecialchars($formData['main_image']); ?>">
                                                <div class="image-preview mt-2" id="main_image_preview">
                                                    <?php if (!empty($formData['main_image'])): ?>
                                                        <img src="../<?php echo htmlspecialchars($formData['main_image']); ?>" 
                                                             class="img-thumbnail" style="max-width: 200px; max-height: 150px;" 
                                                             alt="Main Image Preview">
                                                    <?php else: ?>
                                                        <div class="text-muted text-center p-3 border rounded">
                                                            <i class="fi fi-rr-picture me-2"></i>No image selected
                        </div>
                        <?php endif; ?>
                    </div>
                  </div>
                </div>


                                        <!-- Gallery Images -->
                                        <div class="col-md-6 mb-4">
                                            <label for="image_1" class="form-label">Gallery Image 1</label>
                                            <div class="image-upload-container">
                                                <input type="file" class="form-control mb-2" id="image_1_file" accept="image/*" onchange="previewImage(this, 'image_1_preview', 'image_1')">
                                                <input type="hidden" id="image_1" name="image_1" value="<?php echo htmlspecialchars($formData['image_1']); ?>">
                                                <div class="image-preview mt-2" id="image_1_preview">
                                                    <?php if (!empty($formData['image_1'])): ?>
                                                        <img src="../<?php echo htmlspecialchars($formData['image_1']); ?>" 
                                                             class="img-thumbnail" style="max-width: 200px; max-height: 150px;" 
                                                             alt="Gallery Image 1 Preview">
                                                    <?php else: ?>
                                                        <div class="text-muted text-center p-3 border rounded">
                                                            <i class="fi fi-rr-picture me-2"></i>No image selected
                      </div>
                                                    <?php endif; ?>
                      </div>
                          </div>
                        </div>
                        
                                        <div class="col-md-6 mb-4">
                                            <label for="image_2" class="form-label">Gallery Image 2</label>
                                            <div class="image-upload-container">
                                                <input type="file" class="form-control mb-2" id="image_2_file" accept="image/*" onchange="previewImage(this, 'image_2_preview', 'image_2')">
                                                <input type="hidden" id="image_2" name="image_2" value="<?php echo htmlspecialchars($formData['image_2']); ?>">
                                                <div class="image-preview mt-2" id="image_2_preview">
                                                    <?php if (!empty($formData['image_2'])): ?>
                                                        <img src="../<?php echo htmlspecialchars($formData['image_2']); ?>" 
                                                             class="img-thumbnail" style="max-width: 200px; max-height: 150px;" 
                                                             alt="Gallery Image 2 Preview">
                                                    <?php else: ?>
                                                        <div class="text-muted text-center p-3 border rounded">
                                                            <i class="fi fi-rr-picture me-2"></i>No image selected
                        </div>
                                                    <?php endif; ?>
                              </div>
                                </div>
                                </div>
                        
                                        <div class="col-md-6 mb-4">
                                            <label for="image_3" class="form-label">Gallery Image 3</label>
                                            <div class="image-upload-container">
                                                <input type="file" class="form-control mb-2" id="image_3_file" accept="image/*" onchange="previewImage(this, 'image_3_preview', 'image_3')">
                                                <input type="hidden" id="image_3" name="image_3" value="<?php echo htmlspecialchars($formData['image_3']); ?>">
                                                <div class="image-preview mt-2" id="image_3_preview">
                                                    <?php if (!empty($formData['image_3'])): ?>
                                                        <img src="../<?php echo htmlspecialchars($formData['image_3']); ?>" 
                                                             class="img-thumbnail" style="max-width: 200px; max-height: 150px;" 
                                                             alt="Gallery Image 3 Preview">
                                                    <?php else: ?>
                                                        <div class="text-muted text-center p-3 border rounded">
                                                            <i class="fi fi-rr-picture me-2"></i>No image selected
                              </div>
                                                    <?php endif; ?>
                            </div>
                          </div>
                        </div>
                        
                                        <div class="col-md-6 mb-4">
                                            <label for="image_4" class="form-label">Gallery Image 4</label>
                                            <div class="image-upload-container">
                                                <input type="file" class="form-control mb-2" id="image_4_file" accept="image/*" onchange="previewImage(this, 'image_4_preview', 'image_4')">
                                                <input type="hidden" id="image_4" name="image_4" value="<?php echo htmlspecialchars($formData['image_4']); ?>">
                                                <div class="image-preview mt-2" id="image_4_preview">
                                                    <?php if (!empty($formData['image_4'])): ?>
                                                        <img src="../<?php echo htmlspecialchars($formData['image_4']); ?>" 
                                                             class="img-thumbnail" style="max-width: 200px; max-height: 150px;" 
                                                             alt="Gallery Image 4 Preview">
                                                    <?php else: ?>
                                                        <div class="text-muted text-center p-3 border rounded">
                                                            <i class="fi fi-rr-picture me-2"></i>No image selected
                        </div>
                        <?php endif; ?>
                    </div>
                  </div>
                </div>

                                        <div class="col-md-6 mb-4">
                                            <label for="image_5" class="form-label">Gallery Image 5 (optional)</label>
                                            <div class="image-upload-container">
                                                <input type="file" class="form-control mb-2" id="image_5_file" accept="image/*" onchange="previewImage(this, 'image_5_preview', 'image_5')">
                                                <input type="hidden" id="image_5" name="image_5" value="<?php echo htmlspecialchars($formData['image_5']); ?>">
                                                <div class="image-preview mt-2" id="image_5_preview">
                                                    <?php if (!empty($formData['image_5'])): ?>
                                                        <img src="../<?php echo htmlspecialchars($formData['image_5']); ?>" 
                                                             class="img-thumbnail" style="max-width: 200px; max-height: 150px;" 
                                                             alt="Gallery Image 5 Preview">
                                                    <?php else: ?>
                                                        <div class="text-muted text-center p-3 border rounded">
                                                            <i class="fi fi-rr-picture me-2"></i>No image selected
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <label for="image_6" class="form-label">Gallery Image 6 (optional)</label>
                                            <div class="image-upload-container">
                                                <input type="file" class="form-control mb-2" id="image_6_file" accept="image/*" onchange="previewImage(this, 'image_6_preview', 'image_6')">
                                                <input type="hidden" id="image_6" name="image_6" value="<?php echo htmlspecialchars($formData['image_6']); ?>">
                                                <div class="image-preview mt-2" id="image_6_preview">
                                                    <?php if (!empty($formData['image_6'])): ?>
                                                        <img src="../<?php echo htmlspecialchars($formData['image_6']); ?>" 
                                                             class="img-thumbnail" style="max-width: 200px; max-height: 150px;" 
                                                             alt="Gallery Image 6 Preview">
                                                    <?php else: ?>
                                                        <div class="text-muted text-center p-3 border rounded">
                                                            <i class="fi fi-rr-picture me-2"></i>No image selected
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>

                                    <!-- SEO Settings -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h6 class="fw-semibold text-dark mb-3">SEO Settings</h6>
                  </div>
                      <div class="col-12 mb-3">
                                            <label for="meta_title" class="form-label">Meta Title <small class="text-muted">(SEO)</small></label>
                                            <input type="text" class="form-control" id="meta_title" name="meta_title" 
                                                   value="<?php echo htmlspecialchars($formData['meta_title']); ?>" 
                                                   maxlength="255" placeholder="Auto-generated from product title">
                                            <div class="form-text">
                            <small class="text-muted">
                                                    <i class="fi fi-rr-info me-1"></i>
                                                    Recommended: 50-60 characters. Auto-generates from product title with company name.
                                                    <br>
                                                    <strong>SEO Format:</strong> "Product Name | Dimath Sports"
                            </small>
                          </div>
                          </div>
                      <div class="col-12 mb-3">
                                            <label for="meta_description" class="form-label">Meta Description <small class="text-muted">(SEO)</small></label>
                                            <textarea class="form-control" id="meta_description" name="meta_description" 
                                                      rows="3" maxlength="500" placeholder="Auto-generated from product description"><?php echo htmlspecialchars($formData['meta_description']); ?></textarea>
                                            <div class="form-text">
                          <small class="text-muted">
                            <i class="fi fi-rr-info me-1"></i>
                                                    Recommended: 150-160 characters. Auto-generates from product description.
                                                    <br>
                                                    <strong>SEO Format:</strong> "Product description - Premium Ceylon cinnamon from Dimath Sports"
                          </small>
                      </div>
                    </div>
                  </div>
                </div>

                                    <!-- Status Settings -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h6 class="fw-semibold text-dark mb-3">Status Settings</h6>
              </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select" id="status" name="status" title="Select product status - Active products are visible on the website">
                                                <option value="active" <?php echo $formData['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                                                <option value="inactive" <?php echo $formData['status'] === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                            </select>
                  </div>
                    
                                    <!-- Form Actions -->
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="d-flex gap-2">
                      <button type="submit" class="btn btn-primary">
                                                    <i class="fi fi-rr-checkbox me-2"></i>
                                                    <?php echo $isEditMode ? 'Update Product' : 'Create Product'; ?>
                      </button>
                                                <a href="products.php" class="btn btn-outline-primary">
                                                    <i class="fi fi-rr-cross me-2"></i>Cancel
                      </a>
                    </div>
                  </div>
                </div>
                                </form>
              </div>
            </div>
                    </div>
        </div>
      </div>
      
      <?php include 'includes/footer-content-global.php'; ?>
    </main>
  </div>

  <!-- Required JavaScript -->
    <script src="../dashboard ui/dist/assets/js/vendors.min.js"></script>
    <script src="../dashboard ui/dist/assets/js/common-init.min.js"></script>
  
    <!-- Auto-generate slug from title (only for new products) -->
  <script>
        <?php if (!$isEditMode): ?>
        // Only auto-generate slug for new products
        document.getElementById('title').addEventListener('input', function() {
            const title = this.value;
            const slug = title.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
            
            document.getElementById('slug').value = slug;
        });
        <?php endif; ?>
    </script>
    
    <!-- Image Preview and Upload Functions -->
    <script>
        // Preview image from file input
        function previewImage(fileInput, previewId, hiddenInputId) {
            const file = fileInput.files[0];
            const preview = document.getElementById(previewId);
            const hiddenInput = document.getElementById(hiddenInputId);
            
      if (file) {
                // Create a temporary URL for the selected file
      const reader = new FileReader();
      reader.onload = function(e) {
                    preview.innerHTML = '<img src="' + e.target.result + '" class="img-thumbnail" style="max-width: 200px; max-height: 150px;" alt="Image Preview">';
      };
      reader.readAsDataURL(file);
                
                // Upload the file and update the hidden input
                uploadImage(file, hiddenInput, fileInput);
            } else {
                preview.innerHTML = '<div class="text-muted text-center p-3 border rounded"><i class="fi fi-rr-picture me-2"></i>No image selected</div>';
            }
        }
        
        // Upload image file
        function uploadImage(file, hiddenInput, fileInput) {
      const formData = new FormData();
            formData.append('image', file);
            formData.append('type', 'main');
            
            // Show loading state
            const originalValue = hiddenInput.value;
            hiddenInput.value = 'Uploading...';
      
      fetch('upload-image.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
                    hiddenInput.value = data.file_path;
                    // Show success SweetAlert
          Swal.fire({
                        title: 'Upload Successful!',
                        text: 'Image uploaded successfully.',
              icon: 'success',
              timer: 2000,
                        showConfirmButton: false,
                        confirmButtonColor: '#f70'
          });
        } else {
                    hiddenInput.value = originalValue;
                    
                    // Reset the specific file input that failed
                    if (fileInput) {
                        fileInput.value = '';
                    }
                    
                    // Find and reset the preview for this specific field
                    let previewId = hiddenInput.id.replace('_hidden', '_preview').replace('hidden_', '');
                    // Handle different ID patterns
                    if (previewId === hiddenInput.id) {
                        previewId = hiddenInput.id.replace('main_image', 'main_image_preview')
                                                 .replace('image_1', 'image_1_preview')
                                                 .replace('image_2', 'image_2_preview')
                                                 .replace('image_3', 'image_3_preview')
                                                 .replace('image_4', 'image_4_preview')
                                                 .replace('image_5', 'image_5_preview')
                                                 .replace('image_6', 'image_6_preview');
                    }
                    const preview = document.getElementById(previewId);
                    if (preview) {
                        preview.innerHTML = '<div class="text-muted text-center p-3 border rounded"><i class="fi fi-rr-picture me-2"></i>No image selected</div>';
                    }
                    
                    // Show SweetAlert for upload failure
        Swal.fire({
                        title: 'Upload Failed!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#dc3545'
                    });
                }
            })
            .catch(error => {
                hiddenInput.value = originalValue;
                
                // Reset the specific file input that failed
                if (fileInput) {
                    fileInput.value = '';
                }
                
                // Find and reset the preview for this specific field
                let previewId = hiddenInput.id.replace('_hidden', '_preview').replace('hidden_', '');
                // Handle different ID patterns
                if (previewId === hiddenInput.id) {
                    previewId = hiddenInput.id.replace('main_image', 'main_image_preview')
                                             .replace('image_1', 'image_1_preview')
                                             .replace('image_2', 'image_2_preview')
                                             .replace('image_3', 'image_3_preview')
                                             .replace('image_4', 'image_4_preview')
                                             .replace('image_5', 'image_5_preview')
                                             .replace('image_6', 'image_6_preview');
                }
                const preview = document.getElementById(previewId);
                if (preview) {
                    preview.innerHTML = '<div class="text-muted text-center p-3 border rounded"><i class="fi fi-rr-picture me-2"></i>No image selected</div>';
                }
                
                // Show SweetAlert for upload error
        Swal.fire({
                    title: 'Upload Error!',
                    text: 'Network error occurred. Please check your connection and try again.',
            icon: 'error',
            confirmButtonText: 'OK',
                    confirmButtonColor: '#dc3545'
                });
            });
        }
    </script>
    
    <!-- Form AJAX Handler -->
    <script>
        const IS_EDIT_MODE = <?php echo $isEditMode ? 'true' : 'false'; ?>;
        const ORIGINAL_MAIN_IMAGE = '<?php echo isset($product['main_image']) ? addslashes($product['main_image']) : ''; ?>';
        const ORIGINAL_GALLERY = [
          '<?php echo isset($product['image_1']) ? addslashes($product['image_1']) : ''; ?>',
          '<?php echo isset($product['image_2']) ? addslashes($product['image_2']) : ''; ?>',
          '<?php echo isset($product['image_3']) ? addslashes($product['image_3']) : ''; ?>',
          '<?php echo isset($product['image_4']) ? addslashes($product['image_4']) : ''; ?>',
          '<?php echo isset($product['image_5']) ? addslashes($product['image_5']) : ''; ?>',
          '<?php echo isset($product['image_6']) ? addslashes($product['image_6']) : ''; ?>',
        ].filter(v => v && v.length > 0);
        $(document).ready(function() {
            // Show error message if present (only for non-AJAX errors)
            <?php if (!empty($error)): ?>
          Swal.fire({
                    title: 'Error!',
                    text: '<?php echo addslashes($error); ?>',
            icon: 'error',
            confirmButtonText: 'OK',
                    confirmButtonColor: '#dc3545'
                });
            <?php endif; ?>
            
            // Form validation and submission
            $('#product-form').on('submit', function(e) {
                console.log('Form submission started');
                e.preventDefault(); // Always prevent default submission
                
                // Validate form
                if (!validateForm()) {
                    console.log('Form validation failed');
                    // Scroll to first error
                    const firstError = $('.is-invalid').first();
                    if (firstError.length) {
                        $('html, body').animate({
                            scrollTop: firstError.offset().top - 100
                        }, 500);
                    }
                    return false;
                }
                
                console.log('Form validation passed, starting AJAX submission');
                
                // Show loading state
                const submitBtn = $('#product-form button[type="submit"]');
                const originalText = submitBtn.html();
                submitBtn.prop('disabled', true).html('<i class="fi fi-rr-spinner spin me-2"></i>Processing...');
                
                // Add AJAX flag to form data
                const formData = new FormData(this);
                formData.append('ajax', '1');
                
                console.log('FormData prepared, sending AJAX request');
                
                // Submit via AJAX
                $.ajax({
                    url: window.location.href,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log('AJAX Success Response:', response);
                        
                        try {
                            const data = typeof response === 'string' ? JSON.parse(response) : response;
                            console.log('Parsed Data:', data);
                            
                            if (data.success) {
                                console.log('Showing success SweetAlert');
      // Show success message
        Swal.fire({
                                    title: '<?php echo $isEditMode ? "Product Updated!" : "Product Created!"; ?>',
                                    text: data.message,
          icon: 'success',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#f70'
                                }).then((result) => {
                                    console.log('SweetAlert result:', result);
                                    if (result.isConfirmed) {
                                        window.location.href = 'products.php';
                                    }
        });
      } else {
                                console.log('Showing error SweetAlert');
                                // Show error message
        Swal.fire({
                                    title: 'Error!',
                                    text: data.message || 'An error occurred',
                                    icon: 'error',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#dc3545'
                                });
                            }
                        } catch (e) {
                            console.error('JSON Parse Error:', e);
                            console.error('Response:', response);
                            
        Swal.fire({
                                title: 'Error!',
                                text: 'Invalid response from server. Please try again.',
                                icon: 'error',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#dc3545'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
        
        Swal.fire({
                            title: 'Error!',
                            text: 'Network error occurred. Please try again.',
                icon: 'error',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#dc3545'
                        });
                    },
                    complete: function() {
                        // Restore button state
                        submitBtn.prop('disabled', false).html(originalText);
                    }
                });
            });
            
            // Auto-generate SEO-friendly meta title from product title
            $('#title').on('input', function() {
                const title = $(this).val().trim();
                if (title.length > 0) {
                    // Generate SEO-friendly meta title
                    const metaTitle = generateSEOMetaTitle(title);
                    $('#meta_title').val(metaTitle);
                    
                    // Update character count
                    updateMetaTitleCount();
                }
            });
            
            // Update meta title character count on input
            $('#meta_title').on('input', function() {
                updateMetaTitleCount();
            });
            
            // Auto-generate meta description from product description
            $('#description').on('input', function() {
                const description = $(this).val().trim();
                if (description.length > 0) {
                    // Generate SEO-friendly meta description
                    const metaDescription = generateSEOMetaDescription(description);
                    $('#meta_description').val(metaDescription);
                    
                    // Update character count
                    updateMetaDescriptionCount();
                }
            });
            
            // Update meta description character count on input
            $('#meta_description').on('input', function() {
                updateMetaDescriptionCount();
            });
            
            // Generate SEO-friendly meta title
            function generateSEOMetaTitle(productTitle) {
                const companyName = 'Dimath Sports';
                const separator = ' | ';
                const maxLength = 60; // Google's recommended length
                
                // Clean product title
                let cleanTitle = productTitle.trim();
                
                // Remove extra spaces and special characters
                cleanTitle = cleanTitle.replace(/\s+/g, ' ');
                
                // Create base title
                let metaTitle = cleanTitle + separator + companyName;
                
                // If too long, truncate product title
                if (metaTitle.length > maxLength) {
                    const availableLength = maxLength - separator.length - companyName.length;
                    const truncatedTitle = cleanTitle.substring(0, availableLength - 3) + '...';
                    metaTitle = truncatedTitle + separator + companyName;
                }
                
                return metaTitle;
            }
            
            // Update meta title character count
            function updateMetaTitleCount() {
                const metaTitle = $('#meta_title').val();
                const currentLength = metaTitle.length;
                const maxLength = 60;
                const remaining = maxLength - currentLength;
                
                // Update or create character count display
                let countElement = $('#meta_title').siblings('.meta-title-count');
                if (countElement.length === 0) {
                    countElement = $('<small class="meta-title-count text-muted"></small>');
                    $('#meta_title').after(countElement);
                }
                
                // Set color based on length
                if (currentLength > maxLength) {
                    countElement.text(`${currentLength}/${maxLength} characters (too long)`).removeClass('text-muted text-warning').addClass('text-danger');
                } else if (currentLength > maxLength - 10) {
                    countElement.text(`${currentLength}/${maxLength} characters (${remaining} remaining)`).removeClass('text-muted text-danger').addClass('text-warning');
            } else {
                    countElement.text(`${currentLength}/${maxLength} characters (${remaining} remaining)`).removeClass('text-warning text-danger').addClass('text-muted');
                }
            }
            
            // Generate SEO-friendly meta description
            function generateSEOMetaDescription(productDescription) {
                const maxLength = 160; // Google's recommended length
                const companyName = 'Dimath Sports';
                
                // Clean description
                let cleanDescription = productDescription.trim();
                
                // Remove HTML tags and extra whitespace
                cleanDescription = cleanDescription.replace(/<[^>]*>/g, '').replace(/\s+/g, ' ');
                
                // Add company name if not already present
                if (!cleanDescription.toLowerCase().includes(companyName.toLowerCase())) {
                    cleanDescription += ' - Premium Ceylon cinnamon from ' + companyName;
                }
                
                // Truncate if too long
                if (cleanDescription.length > maxLength) {
                    cleanDescription = cleanDescription.substring(0, maxLength - 3) + '...';
                }
                
                return cleanDescription;
            }
            
            // Update meta description character count
            function updateMetaDescriptionCount() {
                const metaDescription = $('#meta_description').val();
                const currentLength = metaDescription.length;
                const maxLength = 160;
                const remaining = maxLength - currentLength;
                
                // Update or create character count display
                let countElement = $('#meta_description').siblings('.meta-description-count');
                if (countElement.length === 0) {
                    countElement = $('<small class="meta-description-count text-muted"></small>');
                    $('#meta_description').after(countElement);
                }
                
                // Set color based on length
                if (currentLength > maxLength) {
                    countElement.text(`${currentLength}/${maxLength} characters (too long)`).removeClass('text-muted text-warning').addClass('text-danger');
                } else if (currentLength > maxLength - 20) {
                    countElement.text(`${currentLength}/${maxLength} characters (${remaining} remaining)`).removeClass('text-muted text-danger').addClass('text-warning');
        } else {
                    countElement.text(`${currentLength}/${maxLength} characters (${remaining} remaining)`).removeClass('text-warning text-danger').addClass('text-muted');
                }
            }
            
            // Initialize meta title count on page load
            updateMetaTitleCount();
            updateMetaDescriptionCount();
            
            // Real-time validation
            $('#title').on('blur', function() {
                validateField($(this), 'Product title is required');
                
                <?php if (!$isEditMode): ?>
                // Auto-generate slug from title if slug is empty (only for new products)
                const slugField = $('#slug');
                if (slugField.val().trim() === '') {
                    const title = $(this).val().trim();
                    const slug = title.toLowerCase()
                        .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
                        .replace(/\s+/g, '-') // Replace spaces with hyphens
                        .replace(/-+/g, '-') // Replace multiple hyphens with single
                        .replace(/^-|-$/g, ''); // Remove leading/trailing hyphens
                    
                    slugField.val(slug);
                    slugField.trigger('blur'); // Trigger slug validation
                }
                <?php endif; ?>
            });
            
            $('#slug').on('blur', function() {
                const value = $(this).val().trim();
                const isValid = value.length > 0 && /^[a-z0-9-]+$/.test(value);
                
                $(this).removeClass('is-valid is-invalid');
                
                if (isValid) {
                    $(this).addClass('is-valid');
      } else {
                    $(this).addClass('is-invalid');
                }
                
                // Update validation feedback
                let feedback = $(this).siblings('.invalid-feedback');
                if (feedback.length === 0) {
                    feedback = $('<div class="invalid-feedback"></div>');
                    $(this).after(feedback);
                }
                
                if (value.length === 0) {
                    feedback.text('URL slug is required');
                } else if (!/^[a-z0-9-]+$/.test(value)) {
                    feedback.text('URL slug can only contain lowercase letters, numbers, and hyphens');
              } else {
                    feedback.text('');
                }
            });
            
            $('#description').on('blur', function() {
                validateField($(this), 'Product description is required');
            });
            
            $('#main_image').on('change', function() {
                validateField($(this), 'Main image is required');
            });
            
            $('#image_1').on('change', function() {
                validateField($(this), 'Gallery image 1 is required');
            });
            
            $('#image_2').on('change', function() {
                validateField($(this), 'Gallery image 2 is required');
            });
            
            $('#image_3').on('change', function() {
                validateField($(this), 'Gallery image 3 is required');
            });
            
            $('#image_4').on('change', function() {
                validateField($(this), 'Gallery image 4 is required');
            });
            $('#image_5').on('change', function() {
                // optional
            });
            $('#image_6').on('change', function() {
                // optional
            });
            
            // Field validation function
            function validateField(field, errorMessage) {
                const value = field.val().trim();
                const isValid = value.length > 0;
                
                field.removeClass('is-valid is-invalid');
                
                if (isValid) {
                    field.addClass('is-valid');
                    hideFieldError(field);
      } else {
                    field.addClass('is-invalid');
                    showFieldError(field, errorMessage);
                }
                
                return isValid;
            }
            
            // Form validation before submission
            function validateForm() {
                let isValid = true;
                
                // Required fields
                const requiredFields = [
                    { field: '#title', message: 'Product title is required' },
                    { field: '#slug', message: 'URL slug is required' },
                    { field: '#description', message: 'Product description is required' }
                ];

                // Main image required unless editing with existing value
                const mainVal = $('#main_image').val().trim();
                if (!(IS_EDIT_MODE && ORIGINAL_MAIN_IMAGE && !mainVal.length)) {
                    requiredFields.push({ field: '#main_image', message: 'Main image is required' });
                }
                
                requiredFields.forEach(function(item) {
                    const field = $(item.field);
                    const value = field.val().trim();
                    
                    field.removeClass('is-valid is-invalid');
                    
                    if (value.length === 0) {
                        field.addClass('is-invalid');
                        showFieldError(field, item.message);
                        isValid = false;
            } else {
                        field.addClass('is-valid');
                        hideFieldError(field);
                    }
                });
                
                // Enforce gallery count 2/4/6 only if not editing unchanged gallery
                const currentGallery = ['#image_1','#image_2','#image_3','#image_4','#image_5','#image_6']
                    .map(s => $(s).val().trim())
                    .filter(v => v.length>0);
                let enforceGallery = true;
                if (IS_EDIT_MODE) {
                    const same = (arr1, arr2) => arr1.length === arr2.length && arr1.every((v,i)=>v===arr2[i]);
                    if (same(currentGallery, ORIGINAL_GALLERY)) {
                        enforceGallery = false;
                    }
                }
                if (enforceGallery) {
                    if ([2,4,6].indexOf(currentGallery.length) === -1) {
                        isValid = false;
                        Swal.fire({ title: 'Gallery Images', text: 'Please provide exactly 2, 4, or 6 gallery images.', icon: 'warning' });
                    }
                }
                return isValid;
            }
            
            // Show error message below field
            function showFieldError(field, message) {
                hideFieldError(field); // Remove existing error first
                
                const errorDiv = $('<div class="invalid-feedback d-block text-danger mt-1"></div>');
                errorDiv.text(message);
                field.after(errorDiv);
            }
            
            // Hide error message below field
            function hideFieldError(field) {
                field.siblings('.invalid-feedback').remove();
            }
            
            // Validate form before AJAX submission
            $('#product-form').on('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                    // Scroll to first error
                    const firstError = $('.is-invalid').first();
                    if (firstError.length) {
                        $('html, body').animate({
                            scrollTop: firstError.offset().top - 100
                        }, 500);
                    }
                    return false;
                }
            });
    });
  </script>
  
  <!-- Menu Backdrop -->
  <div class="edash-menu-backdrop" id="edash-menu-hide"></div>
</body>
</html>
