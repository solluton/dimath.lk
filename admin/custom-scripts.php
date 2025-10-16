<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/timezone_helper.php';

// Require login
requireLogin();

$user = getCurrentUser();
$message = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        
        try {
            $pdo = getDBConnection();
            $stmt = $pdo->prepare("DELETE FROM custom_scripts WHERE id = ?");
            $stmt->execute([$id]);
            $message = 'Custom script deleted successfully!';
        } catch(PDOException $e) {
            $error = 'Error deleting script: ' . $e->getMessage();
        }
    } elseif ($action === 'toggle') {
        $id = (int)($_POST['id'] ?? 0);
        
        try {
            $pdo = getDBConnection();
            $stmt = $pdo->prepare("UPDATE custom_scripts SET is_active = NOT is_active WHERE id = ?");
            $stmt->execute([$id]);
            $message = 'Script status updated successfully!';
        } catch(PDOException $e) {
            $error = 'Error updating script status: ' . $e->getMessage();
        }
    }
}

// Fetch all custom scripts
try {
    $pdo = getDBConnection();
    $stmt = $pdo->query("SELECT * FROM custom_scripts ORDER BY created_at DESC");
    $scripts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $scripts = [];
    $error = 'Error loading scripts: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Dimath Sports - Custom Scripts Management" />
  <meta name="keyword" content="dimath, cinnamon, custom, scripts, admin" />
  <meta name="author" content="Dimath Sports" />
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
  
  <!-- Favicon -->
  <link href="../images/favicon.png" rel="shortcut icon" type="image/x-icon">
  <link href="../images/webclip.png" rel="apple-touch-icon">
  
  <!-- Title -->
  <title>Custom Scripts | Dimath Sports - Admin Dashboard</title>
  
  <!-- Dashboard UI CSS -->
  <link rel="stylesheet" href="../dashboard ui/dist/assets/vendors/metismenu/metisMenu.min.css">
  <link rel="stylesheet" href="../dashboard ui/dist/assets/vendors/@flaticon/flaticon-uicons/css/all/all.css">
  <link rel="stylesheet" type="text/css" href="../dashboard ui/dist/assets/css/theme.min.css">
  
  <!-- Dimath Cinnamon Custom Dashboard Colors -->
  <link rel="stylesheet" type="text/css" href="../css/dashboard-custom.css">
  
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <style>
    .script-preview {
      background: #f8f9fa;
      border: 1px solid #e9ecef;
      border-radius: 8px;
      padding: 15px;
      margin-top: 10px;
      font-family: 'Courier New', monospace;
      font-size: 12px;
      max-height: 200px;
      overflow-y: auto;
    }
    
    .script-status {
      display: inline-block;
      padding: 4px 8px;
      border-radius: 4px;
      font-size: 12px;
      font-weight: 600;
    }
    
    .status-active {
      background: #d4edda;
      color: #155724;
    }
    
    .status-inactive {
      background: #f8d7da;
      color: #721c24;
    }
  </style>
  
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
      <!-- Header -->
      <header class="edash-header sticky-top d-flex align-items-end ht-80" id="edash-header-sticky">
        <div class="edash-header-container w-100 ht-80 px-4 bg-body-tertiary d-flex align-items-center justify-content-between position-relative" id="edash-header-container">
          <!-- Header Left -->
          <div class="edash-header-left d-flex align-items-center gap-2">
            <!-- Menu Toggle -->
            <div class="edash-minimenu-toggle d-none d-xl-flex">
              <div id="edash-menu-mini">
                <a href="javascript:void(0);" class="edash-drop-item d-flex align-items-center justify-content-center rounded-pill ht-40">
                  <i class="fi fi-sr-menu-burger"></i>
                </a>
              </div>
              <div id="edash-menu-expand" style="display: none">
                <a href="javascript:void(0);" class="edash-drop-item d-flex align-items-center justify-content-center rounded-pill ht-40">
                  <i class="fi fi-sr-menu-burger"></i>
                </a>
              </div>
            </div>
            <!-- Mobile Menu Toggle -->
            <div class="edash-minimenu-toggle d-xl-none">
              <a href="javascript:void(0);" class="edash-drop-item d-flex align-items-center justify-content-center rounded-pill ht-40" data-bs-toggle="offcanvas" data-bs-target="#edash-menu">
                <i class="fi fi-sr-menu-burger"></i>
              </a>
            </div>
          </div>
          
          <!-- Header Right -->
          <div class="edash-header-right d-flex align-items-center gap-1 gap-sm-2">
            <!-- Visit Website Button -->
            <a href="../" target="_blank" class="btn btn-outline-primary btn-sm" title="Visit Website">
              <i class="fi fi-rr-globe me-1"></i>
              <span class="d-none d-sm-inline">Visit Website</span>
            </a>
            
            <!-- Profile -->
            <div class="dropdown">
              <button class="btn btn-link dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="edash-profile-info d-none d-sm-block me-2">
                  <div class="edash-profile-name">Dimath Sports</div>
                </div>
                <div class="edash-profile-avatar">
                  <?php if (!empty($user['profile_picture'])): ?>
                    <img src="../<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile" class="img-fluid rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                  <?php else: ?>
                    <img src="../images/Dimath-Logo.png" alt="Profile" class="img-fluid rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                  <?php endif; ?>
                </div>
              </button>
              <ul class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end">
                <li><a href="profile.php" class="dropdown-item"><i class="fi fi-rr-user me-2"></i>Profile</a></li>
                <li><a href="../admin-password-reset.php" class="dropdown-item"><i class="fi fi-rr-key me-2"></i>Password Reset</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a href="../logout.php" class="dropdown-item"><i class="fi fi-rr-sign-out me-2"></i>Logout</a></li>
              </ul>
            </div>
          </div>
        </div>
      </header>
      
      <!-- Page Content -->
      <div class="edash-page-container" id="edash-page-container">
        <!-- Breadcrumb -->
        <div class="edash-breadcrumb d-flex align-items-center justify-content-between mb-4 px-4">
          <div class="edash-breadcrumb-left">
            <h4 class="mb-0">Custom Scripts</h4>
            <p class="text-muted mb-0">View and manage custom JavaScript codes for head and body sections</p>
          </div>
          <div class="edash-breadcrumb-right">
            <div class="alert alert-info mb-0 py-2 px-3">
              <i class="fi fi-rr-info me-2"></i>
              <strong>Need to add a script?</strong> Contact us at <a href="mailto:support@solluton.com" class="alert-link">support@solluton.com</a>
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
        
        <!-- Custom Scripts Table -->
        <div class="card mx-4">
          <div class="card-header">
            <h5 class="card-title mb-0">All Custom Scripts</h5>
          </div>
          <div class="card-body">
            <?php if ($scripts): ?>
              <div class="table-responsive">
                <table id="customScriptsTable" class="table table-hover">
                  <thead>
                     <tr>
                       <th>Script Name</th>
                       <th>Description</th>
                       <th>Head Script</th>
                       <th>Body Script</th>
                       <th>Status</th>
                       <th>Created</th>
                       <th>Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($scripts as $script): ?>
                      <tr>
                        <td>
                          <div class="fw-semibold"><?php echo htmlspecialchars($script['name']); ?></div>
                        </td>
                        <td>
                          <small class="text-muted">
                            <?php echo htmlspecialchars($script['description'] ?: 'No description'); ?>
                          </small>
                        </td>
                        <td>
                          <?php if ($script['script_head']): ?>
                            <span class="badge bg-info">Yes</span>
                          <?php else: ?>
                            <span class="badge bg-secondary">No</span>
                          <?php endif; ?>
                        </td>
                        <td>
                          <?php if ($script['script_body']): ?>
                            <span class="badge bg-info">Yes</span>
                          <?php else: ?>
                            <span class="badge bg-secondary">No</span>
                          <?php endif; ?>
                        </td>
                        <td>
                          <span class="script-status <?= $script['is_active'] ? 'status-active' : 'status-inactive' ?>">
                            <?= $script['is_active'] ? 'Active' : 'Inactive' ?>
                          </span>
                        </td>
                        <td><?php echo formatSriLankaDate($script['created_at'], 'M j, Y'); ?></td>
                        <td>
                          <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-outline-warning" 
                                    onclick="toggleScript(<?= $script['id'] ?>, <?= $script['is_active'] ? 'true' : 'false' ?>, '<?= htmlspecialchars($script['name']) ?>')" 
                                    title="Toggle Status">
                              <?= $script['is_active'] ? 'ON' : 'OFF' ?>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                    onclick="deleteScript(<?= $script['id'] ?>, '<?= htmlspecialchars($script['name']) ?>')" 
                                    title="Delete Script">
                              <i class="fi fi-rr-trash"></i>
                            </button>
                          </div>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php else: ?>
              <div class="text-center py-5">
                <i class="fi fi-rr-code fs-1 text-muted mb-3"></i>
                <h5 class="text-muted">No custom scripts found</h5>
                <p class="text-muted">Custom scripts will appear here once they are added by the administrator.</p>
                <div class="alert alert-info d-inline-block">
                  <i class="fi fi-rr-info me-2"></i>
                  <strong>Need to add a script?</strong> Contact us at <a href="mailto:solluton.com" class="alert-link">support@solluton.com</a>
                </div>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <!--! ================================================================ !-->
      <!--! End:: Page Content !-->
      <!--! ================================================================ !-->
      <?php include 'includes/footer-content-global.php'; ?>
    </main>
  </div>
  
  <!-- Scripts -->
  <script src="../dashboard ui/dist/assets/js/vendors.min.js"></script>
  <script src="../dashboard ui/dist/assets/js/common-init.min.js"></script>
  
  <!-- DataTables -->
  <?php include 'includes/datatables.php'; ?>
  
  <script>
    // SweetAlert configuration
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
    });
    
    function toggleScript(scriptId, isActive, scriptName) {
      const action = isActive === 'true' ? 'deactivate' : 'activate';
      const actionText = isActive === 'true' ? 'deactivate' : 'activate';
      
      Swal.fire({
        title: `${actionText.charAt(0).toUpperCase() + actionText.slice(1)} Script?`,
        text: `Are you sure you want to ${actionText} "${scriptName}"?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: `Yes, ${actionText}!`,
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          // Submit form via AJAX
          const formData = new FormData();
          formData.append('action', 'toggle');
          formData.append('id', scriptId);
          
          fetch(window.location.href, {
            method: 'POST',
            body: formData
          })
          .then(response => response.text())
          .then(() => {
            Toast.fire({
              icon: 'success',
              title: `Script ${actionText}d successfully!`
            });
            // Reload page to show updated status
            setTimeout(() => {
              window.location.reload();
            }, 1000);
          })
          .catch(error => {
            Toast.fire({
              icon: 'error',
              title: 'Error updating script status'
            });
          });
        }
      });
    }
    
    function deleteScript(scriptId, scriptName) {
      Swal.fire({
        title: 'Delete Script?',
        text: `Are you sure you want to delete "${scriptName}"? This action cannot be undone!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          // Submit form via AJAX
          const formData = new FormData();
          formData.append('action', 'delete');
          formData.append('id', scriptId);
          
          fetch(window.location.href, {
            method: 'POST',
            body: formData
          })
          .then(response => response.text())
          .then(() => {
            Toast.fire({
              icon: 'success',
              title: 'Script deleted successfully!'
            });
            // Reload page to remove deleted script
            setTimeout(() => {
              window.location.reload();
            }, 1000);
          })
          .catch(error => {
            Toast.fire({
              icon: 'error',
              title: 'Error deleting script'
            });
          });
        }
      });
    }
  </script>
</body>
</html>