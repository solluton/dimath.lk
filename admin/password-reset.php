<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/csrf.php';
require_once __DIR__ . '/../config/password_security.php';
require_once __DIR__ . '/../config/url_helper.php';

// Require login
requireLogin();

$user = getCurrentUser();
$message = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate CSRF token
    requireCSRFValidation();
    
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validate inputs
    if (empty($current_password)) {
        $error = 'Current password is required.';
    } elseif (empty($new_password)) {
        $error = 'New password is required.';
    } elseif (empty($confirm_password)) {
        $error = 'Please confirm your new password.';
    } elseif ($new_password !== $confirm_password) {
        $error = 'New passwords do not match.';
    } else {
        try {
            $pdo = getDBConnection();
            
            // Verify current password
            $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
            $stmt->execute([$user['id']]);
            $current_user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$current_user || !password_verify($current_password, $current_user['password'])) {
                $error = 'Current password is incorrect.';
            } else {
                // Validate new password strength
                $password_validation = validatePasswordStrength($new_password);
                if (!$password_validation['valid']) {
                    $error = 'Password requirements not met: ' . implode(', ', $password_validation['errors']);
                } else {
                    // Hash new password
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    
                    // Update password
                    $stmt = $pdo->prepare("UPDATE users SET password = ?, updated_at = NOW() WHERE id = ?");
                    $result = $stmt->execute([$hashed_password, $user['id']]);
                    
                    if ($result) {
                        $message = 'Password updated successfully!';
                        // Set success flag for JavaScript
                        echo '<script>var passwordUpdateSuccess = true;</script>';
                    } else {
                        $error = 'Failed to update password. Please try again.';
                    }
                }
            }
        } catch(PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}

// Generate CSRF token
$csrf_token = generateCSRFToken();
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="robots" content="noindex, nofollow, noarchive, nosnippet" />
  <meta name="description" content="Dimath Group - Password Reset" />
  <meta name="keyword" content="dimath, group, password, reset, admin" />
  <meta name="author" content="Dimath Group" />
  <title>Password Reset | Dimath Group - Admin Dashboard</title>
  
  <!-- Favicon -->
  <link href="<?php echo asset('images/favicon.png'); ?>" rel="shortcut icon" type="image/x-icon">
  <link href="<?php echo asset('images/webclip.png'); ?>" rel="apple-touch-icon">
  
  <!-- Dashboard UI CSS -->
  <link rel="stylesheet" href="<?php echo asset('dashboard ui/dist/assets/vendors/metismenu/metisMenu.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo asset('dashboard ui/dist/assets/vendors/@flaticon/flaticon-uicons/css/all/all.css'); ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo asset('dashboard ui/dist/assets/css/theme.min.css'); ?>">
  
  <!-- Dimath Custom Dashboard Colors -->
  <link rel="stylesheet" href="<?php echo asset('css/dashboard-custom.css'); ?>">
  
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
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
                <h2 class="h4 fw-semibold text-dark">Password Reset</h2>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                      <a href="<?php echo url('admin/dashboard.php'); ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Password Reset
                    </li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </div>
        
        <div class="edash-content-section px-4">
          
          <!-- Messages -->
          <?php if ($message): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <i class="fi fi-rr-check-circle me-2"></i>
              <?php echo htmlspecialchars($message); ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>
          
          <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <i class="fi fi-rr-exclamation-triangle me-2"></i>
              <?php echo htmlspecialchars($error); ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          <?php endif; ?>
          
          <!-- Password Reset Form -->
          <div class="row">
            <div class="col-lg-8">
              <div class="card">
                <div class="card-header">
                  <h5 class="card-title mb-0">Change Password</h5>
                </div>
                <div class="card-body">
                  <form method="POST" action="" id="passwordForm">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                    
                    <div class="mb-3">
                      <label for="current_password" class="form-label">Current Password</label>
                      <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    
                    <div class="mb-3">
                      <label for="new_password" class="form-label">New Password</label>
                      <input type="password" class="form-control" id="new_password" name="new_password" required>
                      <div class="form-text">
                        Password must be at least 8 characters long and contain uppercase, lowercase, number, and special character.
                      </div>
                    </div>
                    
                    <div class="mb-3">
                      <label for="confirm_password" class="form-label">Confirm New Password</label>
                      <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    
                    <div class="d-flex gap-2">
                      <button type="button" class="btn btn-primary" onclick="confirmPasswordUpdate()">
                        <i class="fi fi-rr-key me-2"></i>Update Password
                      </button>
                      <a href="<?php echo url('admin/dashboard.php'); ?>" class="btn btn-outline-primary">
                        <i class="fi fi-rr-arrow-left me-2"></i>Back to Dashboard
                      </a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            
            <div class="col-lg-4">
              <div class="card">
                <div class="card-header">
                  <h5 class="card-title mb-0">Password Requirements</h5>
                </div>
                <div class="card-body">
                  <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                      <i class="fi fi-rr-check text-success me-2"></i>
                      At least 8 characters long
                    </li>
                    <li class="mb-2">
                      <i class="fi fi-rr-check text-success me-2"></i>
                      One uppercase letter (A-Z)
                    </li>
                    <li class="mb-2">
                      <i class="fi fi-rr-check text-success me-2"></i>
                      One lowercase letter (a-z)
                    </li>
                    <li class="mb-2">
                      <i class="fi fi-rr-check text-success me-2"></i>
                      One number (0-9)
                    </li>
                    <li class="mb-2">
                      <i class="fi fi-rr-check text-success me-2"></i>
                      One special character (!@#$%^&*)
                    </li>
                    <li class="mb-2">
                      <i class="fi fi-rr-check text-success me-2"></i>
                      No repeated characters (aaa, 111)
                    </li>
                    <li class="mb-0">
                      <i class="fi fi-rr-check text-success me-2"></i>
                      No sequential characters (abc, 123)
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <?php include 'includes/footer-content-global.php'; ?>
    </main>
  </div>
  
  <!-- Scripts -->
  <script src="<?php echo asset('dashboard ui/dist/assets/js/vendors.min.js'); ?>"></script>
  <script src="<?php echo asset('dashboard ui/dist/assets/js/common-init.min.js'); ?>"></script>
  
  <script>
    // Password update confirmation
    function confirmPasswordUpdate() {
      const currentPassword = document.getElementById('current_password').value;
      const newPassword = document.getElementById('new_password').value;
      const confirmPassword = document.getElementById('confirm_password').value;
      
      if (!currentPassword || !newPassword || !confirmPassword) {
        Swal.fire({
          title: 'Missing Information',
          text: 'Please fill in all password fields.',
          icon: 'warning',
          confirmButtonColor: '#28a745',
          confirmButtonText: 'OK'
        });
        return;
      }
      
      if (newPassword !== confirmPassword) {
        Swal.fire({
          title: 'Password Mismatch',
          text: 'New passwords do not match.',
          icon: 'error',
          confirmButtonColor: '#28a745',
          confirmButtonText: 'OK'
        });
        return;
      }
      
      Swal.fire({
        title: 'Update Password?',
        text: 'Are you sure you want to update your password?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#f70',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, update password!',
        cancelButtonText: 'Cancel',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          // Submit the form
          document.getElementById('passwordForm').submit();
        }
      });
    }
    
    // Show success message after password update
    document.addEventListener('DOMContentLoaded', function() {
      if (typeof passwordUpdateSuccess !== 'undefined' && passwordUpdateSuccess) {
        Swal.fire({
          title: 'Password Updated!',
          text: 'Your password has been updated successfully.',
          icon: 'success',
          confirmButtonColor: '#28a745',
          confirmButtonText: 'OK'
        });
      }
    });
  </script>
  
  <!-- Menu Backdrop -->
  <div class="edash-menu-backdrop" id="edash-menu-hide"></div>
</body>

</html>
