<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/timezone_helper.php';

// Require login
requireLogin();

$user = getCurrentUser();
$message = '';
$error = '';

// Get page type from URL
$page_type = $_GET['page_type'] ?? '';
if (empty($page_type)) {
    header('Location: legal-pages.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    
    if (empty($title)) {
        $error = 'Page title is required.';
    } elseif (empty($content)) {
        $error = 'Page content is required.';
    } else {
        try {
            $pdo = getDBConnection();
            $stmt = $pdo->prepare("UPDATE legal_pages SET title = ?, content = ?, updated_at = NOW() WHERE page_type = ?");
            
            if ($stmt->execute([$title, $content, $page_type])) {
                // Redirect to legal pages list after successful update
                header('Location: legal-pages.php?success=1');
                exit();
            } else {
                $error = 'Failed to update legal page.';
            }
        } catch(PDOException $e) {
            $error = 'Error updating legal page.';
        }
    }
}

// Fetch current page data
try {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("SELECT * FROM legal_pages WHERE page_type = ?");
    $stmt->execute([$page_type]);
    $page_data = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$page_data) {
        header('Location: legal-pages.php');
        exit();
    }
} catch (PDOException $e) {
    $error = 'Error loading legal page.';
    $page_data = null;
}
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="robots" content="noindex, nofollow, noarchive, nosnippet" />
  <meta name="description" content="Dimath Group - Edit Legal Page" />
  <meta name="keyword" content="dimath group, legal, edit, admin" />
  <meta name="author" content="Dimath Group" />
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
  
  <!-- Favicon -->
  <link href="../images/favicon.png" rel="shortcut icon" type="image/x-icon">
  <link href="../images/webclip.png" rel="apple-touch-icon">
  
  <!-- Title -->
  <title>Edit <?php echo htmlspecialchars($page_data['title'] ?? 'Legal Page'); ?> | Dimath Sports - Admin Dashboard</title>
  
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
  
  <!-- Summernote CSS -->
  <link rel="stylesheet" href="../dashboard ui/dist/assets/vendors/summernote/summernote-lite.min.css" />
  
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
                <h2 class="h4 fw-semibold text-dark">Edit <?php echo htmlspecialchars($page_data['title'] ?? 'Legal Page'); ?></h2>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                      <a href="dashboard.php">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                      <a href="legal-pages.php">Legal Pages</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Edit <?php echo htmlspecialchars($page_data['title'] ?? 'Legal Page'); ?>
                    </li>
                  </ol>
                </nav>
              </div>
              <div>
                <a href="legal-pages.php" class="btn btn-outline-primary">
                  <i class="fi fi-rr-arrow-left me-2"></i>Back to Legal Pages
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
        
        <!-- Edit Page Form -->
        <?php if ($page_data): ?>
        <div class="card mx-4">
          <div class="card-header">
            <h5 class="card-title mb-0">Edit <?php echo htmlspecialchars($page_data['title']); ?></h5>
          </div>
          <div class="card-body">
            <form method="POST" action="" id="legalPageForm" onsubmit="return confirmUpdate(event)">
              <div class="row">
                <div class="col-12">
                  <div class="mb-4">
                    <label for="title" class="form-label">Page Title *</label>
                    <input type="text" class="form-control" id="title" name="title" 
                           value="<?php echo htmlspecialchars($page_data['title']); ?>" required />
                  </div>
                  
                  <div class="mb-4">
                    <label for="content" class="form-label">Page Content *</label>
                    <textarea class="form-control" id="summernoteBasic" name="content" rows="15" required><?php echo htmlspecialchars($page_data['content']); ?></textarea>
                  </div>
                  
                  <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                      <i class="fi fi-rr-check me-2"></i>Update Page
                    </button>
                    <a href="legal-pages.php" class="btn btn-outline-primary">
                      <i class="fi fi-rr-cross me-2"></i>Cancel
                    </a>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
        <?php endif; ?>
      </div>
      
      <?php include 'includes/footer-content-global.php'; ?>
    </main>
  </div>

  <!-- Scripts -->
  <script src="../dashboard ui/dist/assets/js/vendors.min.js"></script>
  <script src="../dashboard ui/dist/assets/js/common-init.min.js"></script>
  
  <!-- SweetAlert2 Confirmation -->
  <script>
    function confirmUpdate(event) {
      event.preventDefault(); // Prevent default form submission
      
      Swal.fire({
        title: 'Update Legal Page?',
        text: 'Are you sure you want to update this legal page? This will change the content visible to website visitors.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, update it!',
        cancelButtonText: 'Cancel',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          // Submit the form
          document.getElementById('legalPageForm').submit();
        }
      });
    }
  </script>
  
  <!-- Summernote JS -->
  <script src="../dashboard ui/dist/assets/vendors/summernote/summernote-lite.min.js"></script>
  
  <!-- Summernote Initialize JS -->
  <script src="../dashboard ui/dist/assets/js/components/editors/summernote-init.min.js"></script>
  
  <!-- Menu Backdrop -->
  <div class="edash-menu-backdrop" id="edash-menu-hide"></div>
</body>
</html>
