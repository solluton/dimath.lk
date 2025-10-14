<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/timezone_helper.php';

// Require login
requireLogin();

$user = getCurrentUser();
$message = '';
$error = '';

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("DELETE FROM slug_redirects WHERE id = ?");
        if ($stmt->execute([$_GET['id']])) {
            $message = 'Redirect deleted successfully!';
        } else {
            $error = 'Failed to delete redirect.';
        }
    } catch(PDOException $e) {
        $error = 'Error deleting redirect.';
    }
}

// Handle success message from other pages
if (isset($_GET['success'])) {
    if ($_GET['success'] == '1') {
        $message = 'Redirect created successfully!';
    }
}

// Get all slug redirects with product information
try {
    $pdo = getDBConnection();
    $stmt = $pdo->query("
        SELECT sr.*, 
               p.title as product_title, p.slug as current_product_slug
        FROM slug_redirects sr 
        LEFT JOIN products p ON sr.product_id = p.id AND sr.redirect_type = 'product'
        ORDER BY sr.created_at DESC
    ");
    $redirects = $stmt->fetchAll();
} catch(PDOException $e) {
    $redirects = [];
    $error = 'Error loading redirects.';
}
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="NeoMed Pharma - URL Redirects Management" />
  <meta name="keyword" content="neomed, pharma, redirects, admin" />
  <meta name="author" content="NeoMed Pharma" />
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
  
  <!-- Favicon -->
  <link href="../images/favicon.png" rel="shortcut icon" type="image/x-icon">
  <link href="../images/webclip.png" rel="apple-touch-icon">
  
  <!-- Title -->
  <title>URL Redirects | Dimath Sports - Admin Dashboard</title>
  
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
                <h2 class="h4 fw-semibold text-dark">URL Redirects</h2>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                      <a href="dashboard.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                      URL Redirects
                    </li>
                  </ol>
                </nav>
              </div>
              <div class="d-flex gap-2">
                <a href="products.php" class="btn btn-outline-primary">
                  <i class="fi fi-rr-arrow-left me-2"></i>Back to Products
                </a>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Messages -->
        <div class="px-4">
          <?php if ($message): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <i class="fi fi-rr-check me-2"></i><?php echo htmlspecialchars($message); ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>
          
          <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <i class="fi fi-rr-exclamation me-2"></i><?php echo htmlspecialchars($error); ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>
        </div>
        
        <!-- Redirects Table -->
        <div class="card mx-4">
          <div class="card-header">
            <h5 class="card-title mb-0">All URL Redirects</h5>
          </div>
          <div class="card-body">
            <?php if ($redirects): ?>
              <div class="table-responsive">
                <table id="urlRedirectsTable" class="table table-hover">
                  <thead>
                     <tr>
                       <th>Type</th>
                       <th>Old Slug</th>
                       <th>New Slug</th>
                       <th>Title</th>
                       <th>Current URL</th>
                       <th>Created</th>
                       <th>Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($redirects as $redirect): ?>
                      <tr>
                        <td>
                          <span class="badge bg-success">
                            Product
                          </span>
                        </td>
                        <td>
                          <code>/<?= $redirect['redirect_type'] ?>/<?php echo htmlspecialchars($redirect['old_slug']); ?></code>
                        </td>
                        <td>
                          <code>/<?= $redirect['redirect_type'] ?>/<?php echo htmlspecialchars($redirect['new_slug']); ?></code>
                        </td>
                        <td>
                          <?php if ($redirect['product_title']): ?>
                            <a href="product-update.php?id=<?php echo $redirect['product_id']; ?>" class="text-decoration-none">
                              <?php echo htmlspecialchars($redirect['product_title']); ?>
                            </a>
                          <?php else: ?>
                            <span class="text-muted">Product deleted</span>
                          <?php endif; ?>
                        </td>
                        <td>
                          <?php if ($redirect['current_product_slug']): ?>
                            <a href="../product/<?php echo htmlspecialchars($redirect['current_product_slug']); ?>" target="_blank" class="text-decoration-none">
                              <i class="fi fi-rr-external-link me-1"></i>View Product
                            </a>
                          <?php else: ?>
                            <span class="text-muted">-</span>
                          <?php endif; ?>
                        </td>
                        <td><?php echo formatSriLankaDate($redirect['created_at'], 'M j, Y H:i'); ?></td>
                        <td>
                          <div class="d-flex gap-2">
                            <a href="../<?= $redirect['redirect_type'] ?>/<?php echo htmlspecialchars($redirect['old_slug']); ?>" target="_blank" class="btn btn-sm btn-outline-info" title="Test Redirect">
                              <i class="fi fi-rr-arrow-right-arrow-left"></i>
                            </a>
                            <a href="?action=delete&id=<?php echo $redirect['id']; ?>" 
                               class="btn btn-sm btn-outline-danger delete-redirect-btn" 
                               title="Delete Redirect"
                               data-old-slug="<?php echo htmlspecialchars($redirect['old_slug']); ?>"
                               data-new-slug="<?php echo htmlspecialchars($redirect['new_slug']); ?>"
                               data-type="<?php echo htmlspecialchars($redirect['redirect_type']); ?>">
                              <i class="fi fi-rr-trash"></i>
                            </a>
                          </div>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php else: ?>
              <div class="text-center py-5">
                <i class="fi fi-rr-arrow-right-arrow-left" style="font-size: 3rem; color: #ccc;"></i>
                <h5 class="mt-3 text-muted">No redirects found</h5>
                <p class="text-muted">Slug redirects will appear here when product URLs are changed.</p>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
      
      <?php include 'includes/footer-content-global.php'; ?>
    </main>
  </div>
  
  <!-- Scripts -->
  <script src="../dashboard ui/dist/assets/js/vendors.min.js"></script>
  <script src="../dashboard ui/dist/assets/js/common-init.min.js"></script>
  
  <!-- DataTables -->
  <?php include 'includes/datatables.php'; ?>
  
  <!-- SweetAlert2 Confirmations -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Delete redirect confirmation
      const deleteButtons = document.querySelectorAll('.delete-redirect-btn');
      deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
          e.preventDefault();
          const oldSlug = this.getAttribute('data-old-slug');
          const newSlug = this.getAttribute('data-new-slug');
          const deleteUrl = this.getAttribute('href');
          
          const redirectType = this.getAttribute('data-type');
          const typeLabel = redirectType.charAt(0).toUpperCase() + redirectType.slice(1);
          
          Swal.fire({
            title: 'Delete Redirect?',
            text: `Are you sure you want to delete the ${typeLabel.toLowerCase()} redirect from "/${redirectType}/${oldSlug}" to "/${redirectType}/${newSlug}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f70',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete redirect!',
            cancelButtonText: 'Cancel'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = deleteUrl;
            }
          });
        });
      });
    });
  </script>
  
  <!-- Menu Backdrop -->
  <div class="edash-menu-backdrop" id="edash-menu-hide"></div>
</body>
</html>
