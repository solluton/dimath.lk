<?php
require_once '../config/database.php';
require_once '../config/url_helper.php';
require_once '../config/timezone_helper.php';

// Require login
requireLogin();

$user = getCurrentUser();
$message = '';
$error = '';

// Get statistics
try {
    $pdo = getDBConnection();
    
    
    // Get contact leads count
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM contact_leads WHERE deleted_at IS NULL");
    $leadsCount = $stmt->fetch()['count'];
    
    // Get new leads count (status = 'new')
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM contact_leads WHERE status = 'new' AND deleted_at IS NULL");
    $newLeadsCount = $stmt->fetch()['count'];
    
} catch(PDOException $e) {
    $leadsCount = $newLeadsCount = 0;
    $error = 'Error loading statistics.';
}
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Dimath Group - Admin Dashboard" />
  <meta name="keyword" content="dimath, group, admin, dashboard" />
  <meta name="author" content="Dimath Group" />
  <title>Dashboard | Dimath Group - Admin Panel</title>
  
  <!-- Favicon -->
  <link href="<?= asset('images/favicon.png') ?>" rel="shortcut icon" type="image/x-icon">
  <link href="<?= asset('images/webclip.png') ?>" rel="apple-touch-icon">
  
  <!-- Dashboard UI CSS -->
  <link rel="stylesheet" href="<?= asset('dashboard ui/dist/assets/vendors/metismenu/metisMenu.min.css') ?>">
  <link rel="stylesheet" href="<?= asset('dashboard ui/dist/assets/vendors/@flaticon/flaticon-uicons/css/all/all.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= asset('dashboard ui/dist/assets/css/theme.min.css') ?>">
  
  <!-- Dimath Group Custom Dashboard Colors -->
  <link rel="stylesheet" type="text/css" href="<?= asset('css/dashboard-custom.css') ?>">
  
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <!-- Color Modes JS - DISABLED to force light mode -->
  <!-- <script src="dashboard ui/dist/assets/js/color-modes.min.js"></script> -->
  
  <!-- Force Light Mode Script -->
  <script>
    // Force light mode and prevent dark mode
    document.documentElement.setAttribute('data-bs-theme', 'light');
    localStorage.setItem('theme', 'light');
  </script>
</head>

<body>
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
                <h2 class="h4 fw-semibold text-dark">Dimath Group Dashboard</h2>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                      <a href="dashboard.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Dashboard
                    </li>
                  </ol>
                </nav>
              </div>
              <div class="d-flex align-items-center gap-2">
                <span class="text-muted">Welcome back to Dimath Group, <?php echo htmlspecialchars((isset($user) && is_array($user) && !empty($user['name'])) ? $user['name'] : ((isset($user) && is_array($user) && !empty($user['email'])) ? $user['email'] : 'Admin')); ?>!</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Error/Success Messages -->
        <div class="px-4">
          <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Error!</strong> <?php echo htmlspecialchars($error); ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>

          <?php if ($message): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Success!</strong> <?php echo htmlspecialchars($message); ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>
        </div>

        <!-- Content Section -->
        <div class="edash-content-section row g-3 g-md-4 px-4">
          <!-- Statistics Cards -->
          <div class="col-xxl-3 col-lg-6 col-md-6">
            <div class="card mb-3 mb-md-4">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="flex-shrink-0">
                    <div class="avatar avatar-lg bg-info text-white rounded">
                      <i class="fi fi-rr-envelope fs-20"></i>
                    </div>
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <h6 class="text-muted mb-1">Customer Inquiries</h6>
                    <h4 class="mb-0"><?php echo $leadsCount; ?></h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-xxl-3 col-lg-6 col-md-6">
            <div class="card mb-3 mb-md-4">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="flex-shrink-0">
                    <div class="avatar avatar-lg bg-warning text-white rounded">
                      <i class="fi fi-rr-bell fs-20"></i>
                    </div>
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <h6 class="text-muted mb-1">New Inquiries</h6>
                    <h4 class="mb-0"><?php echo $newLeadsCount; ?></h4>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Quick Actions -->
          <div class="col-12">
            <div class="card mb-3 mb-md-4">
              <div class="card-header">
                <h5 class="card-title mb-0">Quick Actions</h5>
              </div>
              <div class="card-body">
                <div class="row g-3">
                  <div class="col-md-6">
                    <a href="./contact-leads.php" class="btn btn-primary w-100">
                      <i class="fi fi-rr-envelope me-2"></i>View Contact Leads
                    </a>
                  </div>
                  <div class="col-md-6">
                    <a href="./settings.php" class="btn btn-outline-primary w-100">
                      <i class="fi fi-rr-settings me-2"></i>Manage Settings
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <?php include 'includes/footer-content-global.php'; ?>
    </main>
  </div>

  <!-- Menu Backdrop -->
  <div class="edash-menu-backdrop" id="edash-menu-hide"></div>

  <!-- Scripts -->
  <script src="<?= asset('dashboard ui/dist/assets/js/vendors.min.js') ?>"></script>
  <script src="<?= asset('dashboard ui/dist/assets/js/common-init.min.js') ?>"></script>
  
  <!-- Custom Script -->
  <script>
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
      const alerts = document.querySelectorAll('.alert');
      alerts.forEach(function(alert) {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
      });
    }, 5000);
  </script>
</body>
</html>
