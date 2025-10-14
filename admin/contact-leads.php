<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/timezone_helper.php';

// Require login
requireLogin();

$user = getCurrentUser();
$message = '';
$error = '';

// Handle status update
if (isset($_POST['action']) && $_POST['action'] == 'update_status' && isset($_POST['lead_id']) && isset($_POST['status'])) {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("UPDATE contact_leads SET status = ? WHERE id = ?");
        if ($stmt->execute([$_POST['status'], $_POST['lead_id']])) {
            $message = 'Lead status updated successfully!';
        } else {
            $error = 'Failed to update lead status.';
        }
    } catch(PDOException $e) {
        $error = 'Error updating lead status.';
    }
}

// Handle soft delete action
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("UPDATE contact_leads SET deleted_at = NOW() WHERE id = ?");
        if ($stmt->execute([$_GET['id']])) {
            $message = 'Contact lead moved to trash successfully!';
        } else {
            $error = 'Failed to delete contact lead.';
        }
    } catch(PDOException $e) {
        $error = 'Error deleting contact lead.';
    }
}

// Handle restore action
if (isset($_GET['action']) && $_GET['action'] == 'restore' && isset($_GET['id'])) {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("UPDATE contact_leads SET deleted_at = NULL WHERE id = ?");
        if ($stmt->execute([$_GET['id']])) {
            $message = 'Contact lead restored successfully!';
        } else {
            $error = 'Failed to restore contact lead.';
        }
    } catch(PDOException $e) {
        $error = 'Error restoring contact lead.';
    }
}

// Handle permanent delete action
if (isset($_GET['action']) && $_GET['action'] == 'permanent_delete' && isset($_GET['id'])) {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("DELETE FROM contact_leads WHERE id = ?");
        if ($stmt->execute([$_GET['id']])) {
            $message = 'Contact lead permanently deleted!';
        } else {
            $error = 'Failed to permanently delete contact lead.';
        }
    } catch(PDOException $e) {
        $error = 'Error permanently deleting contact lead.';
    }
}

// Get contact leads (active or trash based on view parameter)
$view = $_GET['view'] ?? 'active';
try {
    $pdo = getDBConnection();
    if ($view === 'trash') {
        $stmt = $pdo->query("SELECT * FROM contact_leads WHERE deleted_at IS NOT NULL ORDER BY deleted_at DESC");
    } else {
        $stmt = $pdo->query("SELECT * FROM contact_leads WHERE deleted_at IS NULL ORDER BY created_at DESC");
    }
    $leads = $stmt->fetchAll();
} catch(PDOException $e) {
    $leads = [];
    $error = 'Error loading contact leads.';
}
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Dimath Sports - Contact Leads Management" />
  <meta name="keyword" content="dimath, cinnamon, contact, leads, admin" />
  <meta name="author" content="Dimath Sports" />
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
  
  <!-- Favicon -->
  <link href="../images/favicon.png" rel="shortcut icon" type="image/x-icon">
  <link href="../images/webclip.png" rel="apple-touch-icon">
  
  <!-- Title -->
  <title>Contact Leads | Dimath Sports - Admin Dashboard</title>
  
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
                <h2 class="h4 fw-semibold text-dark"><?php echo $view === 'trash' ? 'Trash' : 'Contact Leads'; ?></h2>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                      <a href="dashboard.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                      <?php echo $view === 'trash' ? 'Trash' : 'Contact Leads'; ?>
                    </li>
                  </ol>
                </nav>
              </div>
              <div class="d-flex align-items-center gap-2">
                <?php if ($view === 'trash'): ?>
                  <a href="contact-leads.php" class="btn btn-outline-primary">
                    <i class="fi fi-rr-arrow-left me-2"></i>Back to Leads
                  </a>
                <?php else: ?>
                  <a href="?view=trash" class="btn btn-outline-secondary">
                    <i class="fi fi-rr-trash me-2"></i>View Trash
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Messages -->
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
        
        <!-- Contact Leads Table -->
        <div class="card mx-4">
          <div class="card-header">
            <h5 class="card-title mb-0">All Contact Leads</h5>
          </div>
          <div class="card-body">
            <?php if ($leads): ?>
              <div class="table-responsive">
                <table id="contactLeadsTable" class="table table-hover">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Message Preview</th>
                      <th>Status</th>
                      <th>Terms Accepted</th>
                      <th>Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($leads as $lead): ?>
                      <tr>
                        <td><?php echo htmlspecialchars($lead['name']); ?></td>
                        <td><a href="mailto:<?php echo htmlspecialchars($lead['email']); ?>"><?php echo htmlspecialchars($lead['email']); ?></a></td>
                        <td><?php echo htmlspecialchars(substr($lead['message'], 0, 50)) . (strlen($lead['message']) > 50 ? '...' : ''); ?></td>
                        <td>
                          <span class="badge bg-<?php 
                            echo $lead['status'] == 'new' ? 'danger' : 
                                ($lead['status'] == 'read' ? 'warning' : 
                                ($lead['status'] == 'replied' ? 'info' : 'success')); 
                          ?>">
                            <?php echo ucfirst($lead['status']); ?>
                          </span>
                        </td>
                        <td>
                          <span class="badge bg-<?php echo $lead['terms_accepted'] ? 'success' : 'danger'; ?>">
                            <?php echo $lead['terms_accepted'] ? 'Yes' : 'No'; ?>
                          </span>
                        </td>
                        <td><?php echo formatSriLankaDate($lead['created_at'], 'M j, Y'); ?></td>
                        <td>
                          <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#leadModal<?php echo $lead['id']; ?>">
                            <i class="fi fi-rr-eye"></i>
                          </button>
                        </td>
                      </tr>
                      
                      <!-- Lead Detail Modal -->
                      <div class="modal fade" id="leadModal<?php echo $lead['id']; ?>" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Contact Lead Details</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                              <div class="row">
                                <div class="col-md-6">
                                  <h6>Contact Information</h6>
                                  <p><strong>Name:</strong> <?php echo htmlspecialchars($lead['name']); ?></p>
                                  <p><strong>Email:</strong> <a href="mailto:<?php echo htmlspecialchars($lead['email']); ?>"><?php echo htmlspecialchars($lead['email']); ?></a></p>
                                  <p><strong>IP Address:</strong> <?php echo htmlspecialchars($lead['ip_address'] ?: 'N/A'); ?></p>
                                  <p><strong>Terms Accepted:</strong> 
                                    <span class="badge bg-<?php echo $lead['terms_accepted'] ? 'success' : 'danger'; ?>">
                                      <?php echo $lead['terms_accepted'] ? 'Yes' : 'No'; ?>
                                    </span>
                                  </p>
                                </div>
                                <div class="col-md-6">
                                  <h6>Lead Information</h6>
                                  <p><strong>Status:</strong> 
                                    <span class="badge bg-<?php 
                                      echo $lead['status'] == 'new' ? 'danger' : 
                                          ($lead['status'] == 'read' ? 'warning' : 
                                          ($lead['status'] == 'replied' ? 'info' : 'success')); 
                                    ?>">
                                      <?php echo ucfirst($lead['status']); ?>
                                    </span>
                                  </p>
                                  <p><strong>Created:</strong> <?php echo formatSriLankaDate($lead['created_at'], 'M j, Y g:i A'); ?></p>
                                  <p><strong>Updated:</strong> <?php echo formatSriLankaDate($lead['updated_at'], 'M j, Y g:i A'); ?></p>
                                  <?php if ($lead['deleted_at']): ?>
                                    <p><strong>Deleted:</strong> <?php echo formatSriLankaDate($lead['deleted_at'], 'M j, Y g:i A'); ?></p>
                                  <?php endif; ?>
                                </div>
                              </div>
                              <hr>
                              <h6>Message</h6>
                              <div class="border p-3 rounded">
                                <?php echo nl2br(htmlspecialchars($lead['message'])); ?>
                              </div>
                            </div>
                            <div class="modal-footer d-flex justify-content-between">
                              <div class="d-flex gap-2">
                                <!-- Status Update Buttons -->
                                <div class="dropdown">
                                  <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fi fi-rr-settings me-1"></i>Update Status
                                  </button>
                                  <ul class="dropdown-menu">
                                    <li>
                                      <form method="POST" class="d-inline">
                                        <input type="hidden" name="action" value="update_status">
                                        <input type="hidden" name="lead_id" value="<?php echo $lead['id']; ?>">
                                        <input type="hidden" name="status" value="read">
                                        <button type="submit" class="dropdown-item">Mark as Read</button>
                                      </form>
                                    </li>
                                    <li>
                                      <form method="POST" class="d-inline">
                                        <input type="hidden" name="action" value="update_status">
                                        <input type="hidden" name="lead_id" value="<?php echo $lead['id']; ?>">
                                        <input type="hidden" name="status" value="replied">
                                        <button type="submit" class="dropdown-item">Mark as Replied</button>
                                      </form>
                                    </li>
                                    <li>
                                      <form method="POST" class="d-inline">
                                        <input type="hidden" name="action" value="update_status">
                                        <input type="hidden" name="lead_id" value="<?php echo $lead['id']; ?>">
                                        <input type="hidden" name="status" value="closed">
                                        <button type="submit" class="dropdown-item">Mark as Closed</button>
                                      </form>
                                    </li>
                                  </ul>
                                </div>
                                
                                <!-- Delete/Restore Actions -->
                                <?php if ($view === 'trash'): ?>
                                  <a href="?action=restore&id=<?php echo $lead['id']; ?>" 
                                     class="btn btn-outline-success">
                                    <i class="fi fi-rr-refresh me-1"></i>Restore
                                  </a>
                                  <a href="?action=permanent_delete&id=<?php echo $lead['id']; ?>" 
                                     class="btn btn-outline-danger permanent-delete-lead-btn"
                                     data-lead-name="<?php echo htmlspecialchars($lead['name']); ?>"
                                     data-lead-email="<?php echo htmlspecialchars($lead['email']); ?>">
                                    <i class="fi fi-rr-trash me-1"></i>Delete Permanently
                                  </a>
                                <?php else: ?>
                                  <a href="?action=delete&id=<?php echo $lead['id']; ?>" 
                                     class="btn btn-outline-danger delete-lead-btn"
                                     data-lead-name="<?php echo htmlspecialchars($lead['name']); ?>"
                                     data-lead-email="<?php echo htmlspecialchars($lead['email']); ?>">
                                    <i class="fi fi-rr-trash me-1"></i>Move to Trash
                                  </a>
                                <?php endif; ?>
                              </div>
                              
                              <div class="d-flex gap-2">
                                <a href="mailto:<?php echo htmlspecialchars($lead['email']); ?>" class="btn btn-primary">
                                  <i class="fi fi-rr-envelope me-1"></i>Reply
                                </a>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php else: ?>
              <div class="text-center py-5">
                <i class="fi fi-rr-envelope fs-1 text-muted mb-3"></i>
                <h5 class="text-muted">No contact leads found</h5>
                <p class="text-muted">Contact form submissions will appear here.</p>
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
      // Soft delete confirmation
      const deleteButtons = document.querySelectorAll('.delete-lead-btn');
      deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
          e.preventDefault();
          const leadName = this.getAttribute('data-lead-name');
          const leadEmail = this.getAttribute('data-lead-email');
          const deleteUrl = this.getAttribute('href');
          
          Swal.fire({
            title: 'Move to Trash?',
            text: `Are you sure you want to move the lead from "${leadName}" (${leadEmail}) to trash?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f70',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, move to trash!',
            cancelButtonText: 'Cancel'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = deleteUrl;
            }
          });
        });
      });
      
      // Permanent delete confirmation
      const permanentDeleteButtons = document.querySelectorAll('.permanent-delete-lead-btn');
      permanentDeleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
          e.preventDefault();
          const leadName = this.getAttribute('data-lead-name');
          const leadEmail = this.getAttribute('data-lead-email');
          const deleteUrl = this.getAttribute('href');
          
          Swal.fire({
            title: 'Permanently Delete?',
            text: `Are you sure you want to permanently delete the lead from "${leadName}" (${leadEmail})? This action cannot be undone!`,
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#f70',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete permanently!',
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
