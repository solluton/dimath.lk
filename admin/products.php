<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/redirect_manager.php';
require_once __DIR__ . '/../config/timezone_helper.php';

// Require login
requireLogin();

$user = getCurrentUser();
$message = '';
$error = '';

// Handle delete action
if (isset($_POST['action']) && $_POST['action'] === 'delete') {
    $product_id = (int)$_POST['product_id'];
    try {
        $pdo = getDBConnection();
        
        // Delete product features first (due to foreign key constraint)
        $stmt = $pdo->prepare("DELETE FROM product_features WHERE product_id = ?");
        $stmt->execute([$product_id]);
        
        // Delete associated redirects
        handleProductDeletion($product_id);
        
        // Now delete the product
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$product_id]);
        
        $message = 'Product deleted successfully!';
    } catch (PDOException $e) {
        $error = 'Error deleting product: ' . $e->getMessage();
    }
}

// Get all products
try {
    $pdo = getDBConnection();
    $stmt = $pdo->query("SELECT * FROM products ORDER BY display_order ASC, created_at DESC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = 'Error fetching products: ' . $e->getMessage();
    $products = [];
}
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Dimath Sports - Products Management" />
  <meta name="keyword" content="dimath, cinnamon, products, admin" />
  <meta name="author" content="Dimath Sports" />
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
  
  <!-- Favicon -->
  <link href="../images/favicon.png" rel="shortcut icon" type="image/x-icon">
  <link href="../images/webclip.png" rel="apple-touch-icon">
  
  <!-- Title -->
  <title>Products | Dimath Sports - Admin Dashboard</title>
  
  <!-- Dashboard UI CSS -->
  <link rel="stylesheet" href="../dashboard ui/dist/assets/vendors/metismenu/metisMenu.min.css">
  <link rel="stylesheet" href="../dashboard ui/dist/assets/vendors/@flaticon/flaticon-uicons/css/all/all.css">
  <link rel="stylesheet" type="text/css" href="../dashboard ui/dist/assets/css/theme.min.css">
  
  <!-- Dimath Custom Dashboard Colors -->
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
                <h2 class="h4 fw-semibold text-dark">Products Management</h2>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                      <a href="dashboard.php">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                      <a href="products.php">Products</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                      All Products
                    </li>
                  </ol>
                </nav>
              </div>
              <div class="d-flex align-items-center gap-2">
                <a href="product-create.php" class="btn btn-primary">
                  <i class="fi fi-rr-add me-2"></i>Add New Product
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
            <i class="fi fi-rr-exclamation me-2"></i><?php echo htmlspecialchars($error); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>

        <div class="row px-4">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h6 class="card-title mb-0">All Products</h6>
              </div>
              <div class="card-body p-0">
                <?php if (empty($products)): ?>
                  <div class="text-center py-5">
                    <div class="mb-4">
                      <i class="fi fi-rr-cinnamon display-1 text-muted"></i>
                    </div>
                    <h5 class="fw-semibold mb-2">No Products Found</h5>
                    <p class="text-muted mb-4">Start by adding your first cinnamon product to showcase your offerings.</p>
                    <a href="product-create.php" class="btn btn-primary">
                      <i class="fi fi-rr-add me-2"></i>Add First Product
                    </a>
                  </div>
                <?php else: ?>
                  <div class="table-responsive">
                    <table class="table table-hover mb-0">
                      <thead>
                        <tr>
                          <th class="text-center" style="width: 80px;">
                            <i class="fi fi-rr-cinnamon"></i>
                          </th>
                          <th>Product Title</th>
                          <th class="text-center">Images</th>
                          <th class="text-center">Status</th>
                          <th class="text-center">Created</th>
                          <th class="text-center" style="width: 150px;">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($products as $product): ?>
                          <tr>
                            <td class="text-center">
                              <?php if (!empty($product['main_image'])): ?>
                                <img src="../<?php echo htmlspecialchars($product['main_image']); ?>" 
                                     class="rounded-circle" 
                                     style="width: 40px; height: 40px; object-fit: cover;" 
                                     alt="Product Image">
                              <?php else: ?>
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 40px; height: 40px;">
                                  <i class="fi fi-rr-cinnamon text-muted"></i>
                                </div>
                              <?php endif; ?>
                            </td>
                            <td>
                              <div class="fw-semibold"><?php echo htmlspecialchars($product['title']); ?></div>
                              <div class="text-muted small"><?php echo htmlspecialchars($product['slug']); ?></div>
                            </td>
                            <td class="text-center">
                              <?php
                              $imageCount = 0;
                              if (!empty($product['main_image'])) $imageCount++;
                              if (!empty($product['image_1'])) $imageCount++;
                              if (!empty($product['image_2'])) $imageCount++;
                              if (!empty($product['image_3'])) $imageCount++;
                              if (!empty($product['image_4'])) $imageCount++;
                              if (!empty($product['image_5'])) $imageCount++;
                              echo $imageCount;
                              ?>
                            </td>
                            <td class="text-center">
                              <?php if ($product['status'] === 'active'): ?>
                                <span class="badge bg-success">Active</span>
                              <?php else: ?>
                                <span class="badge bg-secondary">Inactive</span>
                              <?php endif; ?>
                            </td>
                            <td class="text-center">
                              <small class="text-muted"><?= formatSriLankaDate($product['created_at'], 'M d, Y') ?></small>
                            </td>
                            <td class="text-center">
                              <div class="d-flex gap-2 justify-content-center">
                                <a href="../product/<?= htmlspecialchars($product['slug']) ?>" 
                                   class="btn btn-outline-primary btn-sm" 
                                   target="_blank"
                                   title="View Product">
                                  <i class="fi fi-rr-eye"></i>
                                </a>
                                <a href="product-create.php?id=<?= $product['id'] ?>" 
                                   class="btn btn-outline-primary btn-sm" 
                                   title="Edit Product">
                                  <i class="fi fi-rr-edit"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-outline-danger btn-sm" 
                                        onclick="confirmDelete(<?= $product['id'] ?>, '<?= htmlspecialchars($product['title'], ENT_QUOTES) ?>')" 
                                        title="Delete Product">
                                  <i class="fi fi-rr-trash"></i>
                                </button>
                              </div>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <?php include 'includes/footer-content-global.php'; ?>
    </main>
  </div>

  <!-- Hidden Delete Form -->
  <form id="deleteForm" method="POST" style="display: none;">
    <input type="hidden" name="action" value="delete">
    <input type="hidden" name="product_id" id="deleteProductId" value="">
  </form>

  <!-- Required JavaScript -->
  
  <script>
    function confirmDelete(productId, productTitle) {
      Swal.fire({
        title: 'Delete Product',
        html: `Are you sure you want to delete <strong>"${productTitle}"</strong>?<br><br>This action cannot be undone and will also delete all associated features.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f70',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          // Set the product ID and submit the form
          document.getElementById('deleteProductId').value = productId;
          document.getElementById('deleteForm').submit();
        }
      });
    }
  </script>
  
  <!-- Scripts -->
  <script src="../dashboard ui/dist/assets/js/vendors.min.js"></script>
  <script src="../dashboard ui/dist/assets/js/common-init.min.js"></script>
  
  <!-- Menu Backdrop -->
  <div class="edash-menu-backdrop" id="edash-menu-hide"></div>
</body>
</html>
