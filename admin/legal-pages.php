<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/timezone_helper.php';

// Require login
requireLogin();

$user = getCurrentUser();
$message = '';
$error = '';

// Handle success message from update
if (isset($_GET['success'])) {
    if ($_GET['success'] == '1') {
        $message = 'Legal page updated successfully!';
    }
}

// Fetch legal pages
try {
    $pdo = getDBConnection();
    $stmt = $pdo->query("SELECT * FROM legal_pages ORDER BY page_type");
    $legal_pages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $legal_pages = [];
    $error = 'Error loading legal pages.';
}
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="robots" content="noindex, nofollow, noarchive, nosnippet" />
  <meta name="description" content="Dimath Group - Legal Pages Management" />
  <meta name="keyword" content="dimath group, legal, pages, admin" />
  <meta name="author" content="Dimath Group" />
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
  
  <!-- Favicon -->
  <link href="../images/favicon.png" rel="shortcut icon" type="image/x-icon">
  <link href="../images/webclip.png" rel="apple-touch-icon">
  
  <!-- Title -->
  <title>Legal Pages | Dimath Sports - Admin Dashboard</title>
  
  <!-- Dashboard UI CSS -->
  <link rel="stylesheet" href="../dashboard ui/dist/assets/vendors/metismenu/metisMenu.min.css">
  <link rel="stylesheet" href="../dashboard ui/dist/assets/vendors/@flaticon/flaticon-uicons/css/all/all.css">
  <link rel="stylesheet" type="text/css" href="../dashboard ui/dist/assets/css/theme.min.css">
  
  <!-- Dimath Group Custom Dashboard Colors -->
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
                <h2 class="h4 fw-semibold text-dark">Legal Pages</h2>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                      <a href="dashboard.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Legal Pages
                    </li>
                  </ol>
                </nav>
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
        
        <!-- Legal Pages Table -->
        <div class="card mx-4">
          <div class="card-header">
            <h5 class="card-title mb-0">All Legal Pages</h5>
          </div>
          <div class="card-body">
            <?php if ($legal_pages): ?>
              <div class="table-responsive">
                <table id="legalPagesTable" class="table table-hover">
                  <thead>
                     <tr>
                       <th>Page Title</th>
                       <th>Type</th>
                       <th>Last Updated</th>
                       <th>Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($legal_pages as $page): ?>
                      <tr>
                        <td>
                          <div class="fw-semibold"><?php echo htmlspecialchars($page['title']); ?></div>
                          <small class="text-muted">
                            <?php 
                            $preview = strip_tags($page['content']);
                            echo htmlspecialchars(strlen($preview) > 60 ? substr($preview, 0, 60) . '...' : $preview); 
                            ?>
                          </small>
                        </td>
                        <td>
                          <span class="badge bg-info"><?php echo ucfirst(str_replace('-', ' ', $page['page_type'])); ?></span>
                        </td>
                        <td><?php echo formatSriLankaDate($page['updated_at'], 'M j, Y g:i A'); ?></td>
                        <td>
                          <div class="d-flex gap-2">
                            <a href="legal-pages-edit.php?page_type=<?php echo urlencode($page['page_type']); ?>" class="btn btn-sm btn-outline-primary" title="Edit Page">
                              <i class="fi fi-rr-edit"></i>
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
                <i class="fi fi-rr-shield-check fs-1 text-muted mb-3"></i>
                <h5 class="text-muted">No legal pages found</h5>
                <p class="text-muted">Legal pages will appear here once they are created.</p>
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
  
  <!-- Menu Backdrop -->
  <div class="edash-menu-backdrop" id="edash-menu-hide"></div>
</body>
</html>