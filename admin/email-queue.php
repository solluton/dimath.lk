<?php
require_once __DIR__ . '/../config/email_queue.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/timezone_helper.php';

// Require login
requireLogin();

$user = getCurrentUser();
$message = '';
$error = '';

// Function to get the correct PHP executable path
function getPhpExecutablePath() {
    // Check if we're on Windows and WAMP is available
    if (PHP_OS_FAMILY === 'Windows') {
        // Try WAMP paths (common versions)
        $wampPaths = [
            'C:\wamp64\bin\php\php8.2.26\php.exe',
            'C:\wamp64\bin\php\php8.1.25\php.exe',
            'C:\wamp64\bin\php\php8.0.30\php.exe',
            'C:\xampp\php\php.exe',
            'C:\wamp\bin\php\php8.2.26\php.exe'
        ];
        
        foreach ($wampPaths as $path) {
            if (file_exists($path)) {
                return '"' . $path . '"'; // Quote the path for Windows
            }
        }
    }
    
    // For Linux/production servers, just use 'php' (should be in PATH)
    return 'php';
}

// Handle actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'process_queue') {
        // Trigger manual queue processing
        $output = [];
        $return_var = 0;
        $phpPath = getPhpExecutablePath();
        $command = $phpPath . ' ' . __DIR__ . '/../process_email_queue.php --limit=5 --verbose 2>&1';
        exec($command, $output, $return_var);
        $manual_process_result = implode("\n", $output);
        $message = 'Queue processing initiated. Check the results below.';
    } elseif ($action === 'retry_failed') {
        // Retry failed emails by setting them back to pending
        try {
            $pdo = getDBConnection();
            $stmt = $pdo->prepare("UPDATE email_queue SET status = 'pending', attempts = 0, error_message = NULL WHERE status = 'failed'");
            $stmt->execute();
            $retry_count = $stmt->rowCount();
            $message = "Reset $retry_count failed emails to pending status.";
        } catch (Exception $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}

// Get queue statistics
$stats = getEmailQueueStats();
$pending_emails = getPendingEmails(20);

// Get recent emails (last 50)
try {
    $pdo = getDBConnection();
    $stmt = $pdo->query("
        SELECT * FROM email_queue 
        ORDER BY created_at DESC 
        LIMIT 50
    ");
    $recent_emails = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $recent_emails = [];
    $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="robots" content="noindex, nofollow, noarchive, nosnippet" />
  <meta name="description" content="Dimath Group - Email Queue Management" />
  <meta name="keyword" content="dimath, group, email, queue, admin" />
  <meta name="author" content="Dimath Group" />
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
  
  <!-- Favicon -->
  <link href="../images/favicon.png" rel="shortcut icon" type="image/x-icon">
  <link href="../images/webclip.png" rel="apple-touch-icon">
  
  <!-- Title -->
  <title>Email Queue Management | Dimath Sports - Admin Dashboard</title>
  
  <!-- Dashboard UI CSS -->
  <link rel="stylesheet" href="../dashboard ui/dist/assets/vendors/metismenu/metisMenu.min.css">
  <link rel="stylesheet" href="../dashboard ui/dist/assets/vendors/@flaticon/flaticon-uicons/css/all/all.css">
  <link rel="stylesheet" type="text/css" href="../dashboard ui/dist/assets/css/theme.min.css">
  
  <!-- Dimath Cinnamon Custom Dashboard Colors -->
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
  
  <!-- Custom Styles for Email Queue -->
  <style>
    .queue-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    .stat-card {
        background: white !important;
        color: #0d0b00 !important;
        border-radius: 12px !important;
        padding: 1.5rem !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
        border: 1px solid #dadad8 !important;
        text-align: center !important;
        transition: all 0.3s ease !important;
    }
    .stat-card:hover {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15) !important;
        transform: translateY(-2px) !important;
    }
    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }
    .stat-label {
        color: #86857f !important;
        font-size: 0.9rem;
        font-weight: 500;
    }
    .status-badge {
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: bold;
    }
    .status-pending { background: #fff3cd; color: #856404; }
    .status-processing { background: #d1ecf1; color: #0c5460; }
    .status-sent { background: #d4edda; color: #155724; }
    .status-failed { background: #f8d7da; color: #721c24; }
    .manual-output {
        background: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 1rem;
        margin: 1rem 0;
        font-family: monospace;
        white-space: pre-wrap;
        max-height: 300px;
        overflow-y: auto;
    }
  </style>
  
  <!-- HTML5 shim and Respond.js for IE8 support -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body class="email-queue-page">
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
                <h2 class="h4 fw-semibold text-dark">Email Queue Management</h2>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                      <a href="dashboard.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Email Queue
                    </li>
                  </ol>
                </nav>
              </div>
              <div class="text-muted small">
                <i class="fi fi-rr-clock me-1"></i>
                Last updated: <?= getSriLankaTime('Y-m-d H:i:s') ?>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Messages -->
        <?php if ($message): ?>
          <div class="alert alert-success alert-dismissible fade show mx-4" role="alert">
            <i class="fi fi-rr-check me-2"></i><?php echo htmlspecialchars($message); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>
        
        <?php if ($error): ?>
          <div class="alert alert-danger alert-dismissible fade show mx-4" role="alert">
            <i class="fi fi-rr-exclamation me-2"></i><?php echo htmlspecialchars($error); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>

        <?php if (isset($manual_process_result)): ?>
        <div class="alert alert-info mx-4" role="alert">
          <h6><i class="fi fi-rr-info me-2"></i>Manual Processing Result:</h6>
          <div class="manual-output"><?= htmlspecialchars($manual_process_result) ?></div>
        </div>
        <?php endif; ?>

        <!-- Queue Statistics -->
        <div class="mx-4 mb-4">
          <div class="queue-stats">
            <div class="stat-card">
              <div class="stat-number text-warning"><?= $stats['pending'] ?? 0 ?></div>
              <div class="stat-label">Pending</div>
            </div>
            <div class="stat-card">
              <div class="stat-number text-info"><?= $stats['processing'] ?? 0 ?></div>
              <div class="stat-label">Processing</div>
            </div>
            <div class="stat-card">
              <div class="stat-number text-success"><?= $stats['sent'] ?? 0 ?></div>
              <div class="stat-label">Sent</div>
            </div>
            <div class="stat-card">
              <div class="stat-number text-danger"><?= $stats['failed'] ?? 0 ?></div>
              <div class="stat-label">Failed</div>
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="mx-4 mb-4">
          <div class="d-flex gap-2 flex-wrap">
            <form method="post" style="display: inline;">
              <input type="hidden" name="action" value="process_queue">
              <button type="submit" class="btn btn-primary">
                <i class="fi fi-rr-play me-1"></i>
                Process Queue Now
              </button>
            </form>
            
            <?php if (($stats['failed'] ?? 0) > 0): ?>
            <form method="post" style="display: inline;">
              <input type="hidden" name="action" value="retry_failed">
              <button type="submit" class="btn btn-warning" onclick="return confirmRetryFailed()">
                <i class="fi fi-rr-refresh me-1"></i>
                Retry Failed (<?= $stats['failed'] ?>)
              </button>
            </form>
            <?php endif; ?>
            
          </div>
        </div>

        <!-- Pending Emails -->
        <?php if (!empty($pending_emails)): ?>
        <div class="card mx-4 mb-4">
          <div class="card-header">
            <h5 class="card-title mb-0"><i class="fi fi-rr-clock me-2"></i>Pending Emails (Next <?= count($pending_emails) ?>)</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="pendingEmailsTable" class="table table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>To</th>
                    <th>Subject</th>
                    <th>Priority</th>
                    <th>Attempts</th>
                    <th>Scheduled</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($pending_emails as $email): ?>
                  <tr>
                    <td><?= $email['id'] ?></td>
                    <td><?= htmlspecialchars($email['to_email']) ?></td>
                    <td><?= htmlspecialchars(substr($email['subject'], 0, 50)) ?><?= strlen($email['subject']) > 50 ? '...' : '' ?></td>
                    <td><?= $email['priority'] ?></td>
                    <td><?= $email['attempts'] ?>/<?= $email['max_attempts'] ?></td>
                    <td><?= formatSriLankaDate($email['scheduled_at'], 'M j, H:i') ?></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <?php endif; ?>

        <!-- Recent Emails -->
        <div class="card mx-4">
          <div class="card-header">
            <h5 class="card-title mb-0"><i class="fi fi-rr-list me-2"></i>Recent Emails (Last 50)</h5>
          </div>
          <div class="card-body">
            <?php if (!empty($recent_emails)): ?>
              <div class="table-responsive">
                <table id="recentEmailsTable" class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Status</th>
                      <th>To</th>
                      <th>Subject</th>
                      <th>Attempts</th>
                      <th>Created</th>
                      <th>Processed</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($recent_emails as $email): ?>
                    <tr>
                      <td><?= $email['id'] ?></td>
                      <td>
                        <span class="status-badge status-<?= $email['status'] ?>">
                          <?= ucfirst($email['status']) ?>
                        </span>
                      </td>
                      <td><?= htmlspecialchars($email['to_email']) ?></td>
                      <td title="<?= htmlspecialchars($email['subject']) ?>">
                        <?= htmlspecialchars(substr($email['subject'], 0, 40)) ?><?= strlen($email['subject']) > 40 ? '...' : '' ?>
                      </td>
                      <td><?= $email['attempts'] ?>/<?= $email['max_attempts'] ?></td>
                      <td><?= formatSriLankaDate($email['created_at'], 'M j, H:i') ?></td>
                      <td><?= $email['processed_at'] ? formatSriLankaDate($email['processed_at'], 'M j, H:i') : '-' ?></td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php else: ?>
              <div class="text-center py-4">
                <i class="fi fi-rr-inbox fs-1 text-muted mb-3 d-block"></i>
                <p class="text-muted mb-0">No emails found in the queue.</p>
              </div>
            <?php endif; ?>
          </div>
        </div>

      </div>
      
      <?php include 'includes/footer-content-global.php'; ?>
    </main>
  </div>

  <!-- Dashboard UI JS -->
  <script src="../dashboard ui/dist/assets/js/vendors.min.js"></script>
  <script src="../dashboard ui/dist/assets/js/common-init.min.js"></script>
  
  <!-- DataTables -->
  <?php include 'includes/datatables.php'; ?>
  
  <script>
    // Auto-refresh every 30 seconds
    setTimeout(function() {
        location.reload();
    }, 30000);
    
    // SweetAlert2 confirm function for retry failed emails
    function confirmRetryFailed() {
      Swal.fire({
        title: 'Retry Failed Emails?',
        text: 'Are you sure you want to retry all failed emails?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, retry them!',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          // Submit the form
          event.target.closest('form').submit();
        }
      });
      return false; // Prevent default form submission
    }
  </script>
</body>
</html>