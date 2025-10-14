<?php
require_once __DIR__ . '/../config/env.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/csrf.php';

// Require login
requireLogin();

$user = getCurrentUser();
$message = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate CSRF token
    requireCSRFValidation();
    
    try {
        $pdo = getDBConnection();
        
        // Get form data
        $contact_email = trim($_POST['contact_email'] ?? '');
        $email_enabled = isset($_POST['email_enabled']) ? '1' : '0';
        
        // Validate required fields
        if (empty($contact_email) || !filter_var($contact_email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid contact email address.';
        } else {
            // Update settings (only contact_email and email_enabled)
            $settings = [
                'contact_email' => $contact_email,
                'email_enabled' => $email_enabled
            ];
            
            $stmt = $pdo->prepare("UPDATE admin_settings SET setting_value = ? WHERE setting_key = ?");
            
            foreach ($settings as $key => $value) {
                $stmt->execute([$value, $key]);
            }
            
            $message = 'Settings updated successfully!';
        }
    } catch(PDOException $e) {
        $error = 'Error updating settings.';
    }
}

// Get current settings
try {
    $pdo = getDBConnection();
    $stmt = $pdo->query("SELECT setting_key, setting_value FROM admin_settings");
    $settings = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
} catch(PDOException $e) {
    $settings = [];
    $error = 'Error loading settings.';
}
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="NeoMed Pharma - Admin Settings" />
  <meta name="keyword" content="neomed, pharma, settings, admin" />
  <meta name="author" content="NeoMed Pharma" />
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
  
  <!-- Favicon -->
  <link href="../images/favicon.png" rel="shortcut icon" type="image/x-icon">
  <link href="../images/webclip.png" rel="apple-touch-icon">
  
  <!-- Title -->
  <title>Settings | Dimath Sports - Admin Dashboard</title>
  
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
                <h2 class="h4 fw-semibold text-dark">General Settings</h2>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                      <a href="dashboard.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Settings
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
        
        <!-- Settings Form -->
        <div class="card mx-4">
          <div class="card-header">
            <h5 class="card-title mb-0">General Settings</h5>
          </div>
          <div class="card-body">
            <form method="POST" action="" onsubmit="return confirmSettingsUpdate()">
              <?= getCSRFTokenField() ?>
              <div class="row">
                <!-- Contact Email -->
                <div class="col-md-6 mb-3">
                  <label for="contact_email" class="form-label">Contact Email Address <span class="text-danger">*</span></label>
                  <input type="email" class="form-control" id="contact_email" name="contact_email" 
                         value="<?php echo htmlspecialchars($settings['contact_email'] ?? ''); ?>" required>
                  <div class="form-text">Email address to receive contact form submissions</div>
                </div>
                
                <!-- Email Enabled -->
                <div class="col-md-6 mb-3">
                  <label class="form-label">Email Notifications</label>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="email_enabled" name="email_enabled" 
                           <?php echo ($settings['email_enabled'] ?? '1') == '1' ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="email_enabled">
                      Enable email notifications
                    </label>
                  </div>
                  <div class="form-text">Send emails when contact forms are submitted</div>
                </div>
              </div>
              
              <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                  <i class="fi fi-rr-check me-2"></i>Save Settings
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
      
      <?php include 'includes/footer-content-global.php'; ?>
    </main>
  </div>
  
  <!-- Scripts -->
  <script src="../dashboard ui/dist/assets/js/vendors.min.js"></script>
  <script src="../dashboard ui/dist/assets/js/common-init.min.js"></script>
  
  <!-- SweetAlert2 Confirmation -->
  <script>
    function confirmSettingsUpdate() {
      Swal.fire({
        title: 'Update Settings?',
        text: 'Are you sure you want to update the system settings? This will affect how the website functions.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#f70',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, update settings!',
        cancelButtonText: 'Cancel',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          // Submit the form
          event.target.submit();
        } else {
          // Prevent form submission
          return false;
        }
      });
      return false; // Prevent default form submission
    }
  </script>
  
  <!-- Menu Backdrop -->
  <div class="edash-menu-backdrop" id="edash-menu-hide"></div>
</body>
</html>
