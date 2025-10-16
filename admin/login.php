<?php
require_once '../config/database.php';
require_once '../config/csrf.php';
require_once '../config/url_helper.php';

// Redirect if already logged in
redirectIfLoggedIn();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate CSRF token
    requireCSRFValidation();
    
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);
    
    if (empty($email) || empty($password)) {
        $error = 'Please fill in all fields.';
    } else {
        try {
            $pdo = getDBConnection();
            $stmt = $pdo->prepare("SELECT id, name, email, username, password, role FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && password_verify($password, $user['password'])) {
                // Login successful
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                
                // Set remember me cookie
                if ($remember) {
                    $token = bin2hex(random_bytes(32));
                    setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/'); // 30 days
                    
                    // Store token in database (you might want to create a remember_tokens table)
                    $stmt = $pdo->prepare("UPDATE users SET remember_token = ? WHERE id = ?");
                    $stmt->execute([$token, $user['id']]);
                }
                
                header('Location: dashboard.php');
                exit();
            } else {
                $error = 'Invalid email or password.';
            }
        } catch(PDOException $e) {
            $error = 'Login failed. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Dimath Group - Admin Login" />
  <meta name="keyword" content="dimath, group, login, admin" />
  <meta name="author" content="Dimath Group" />
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
  
  <!-- Favicon -->
  <link href="<?= asset('images/favicon.png') ?>" rel="shortcut icon" type="image/x-icon">
  <link href="<?= asset('images/webclip.png') ?>" rel="apple-touch-icon">
  
  <!-- Title -->
  <title>Login | Dimath Group - Admin Dashboard</title>
  
  <!-- Dashboard UI CSS -->
  <link rel="stylesheet" href="<?= asset('dashboard ui/dist/assets/vendors/metismenu/metisMenu.min.css') ?>">
  <link rel="stylesheet" href="<?= asset('dashboard ui/dist/assets/vendors/@flaticon/flaticon-uicons/css/all/all.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?= asset('dashboard ui/dist/assets/css/theme.min.css') ?>">
  
  <!-- Dimath Group Custom Dashboard Colors -->
  <link rel="stylesheet" type="text/css" href="<?= asset('css/dashboard-custom.css') ?>">
  
  <!-- Color Modes JS - DISABLED to force light mode -->
  <!-- <script src="dashboard ui/dist/assets/js/color-modes.min.js"></script> -->
  
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
    <main class="min-vh-100 overflow-y-auto d-flex flex-column justify-content-center px-4 m-0" id="edash-main">
      <div class="card max-wd-400 max-wd-sm-450 mx-auto my-5 bg-body-tertiary">
        <div class="card-body p-sm-8 p-4">
          <!-- Logo -->
          <div class="text-center mb-4">
            <img src="<?= asset('images/dimath-logo.avif') ?>" alt="Dimath Group" style="max-width: 150px;">
          </div>
          
          <h4 class="mb-2 fw-semibold text-center">Login to your account</h4>
          <p class="fs-14 fw-medium text-muted mb-6 text-center">
            Welcome back to Dimath Group admin dashboard. Access your account to manage operations and communications.
          </p>
          
          <!-- Error/Success Messages -->
          <?php if ($error): ?>
            <div class="alert alert-danger" role="alert">
              <i class="fi fi-rr-exclamation"></i> <?php echo htmlspecialchars($error); ?>
            </div>
          <?php endif; ?>
          
          <?php if ($success): ?>
            <div class="alert alert-success" role="alert">
              <i class="fi fi-rr-check"></i> <?php echo htmlspecialchars($success); ?>
            </div>
          <?php endif; ?>
          
          <!-- Login Form -->
          <form method="POST" action="">
            <?= getCSRFTokenField() ?>
            <div class="mb-4">
              <input type="email" class="form-control" placeholder="Email" value="<?php echo htmlspecialchars($email ?? ''); ?>" name="email" required />
            </div>
            <div class="mb-3">
              <input type="password" class="form-control" placeholder="Password" name="password" required />
            </div>
            <div class="d-flex align-items-center justify-content-center">
              <div class="form-check">
                <input class="form-check-input cursor-pointer" type="checkbox" id="rememberMe" name="remember" />
                <label class="form-check-label text-muted" for="rememberMe">Remember</label>
              </div>
            </div>
            <div class="d-grid mt-5">
              <button type="submit" class="btn btn-lg btn-primary w-100">
                Login
              </button>
            </div>
          </form>
          
          
          <!-- Back to Website -->
          <div class="mt-3 text-center">
            <a href="<?php echo url(''); ?>" class="text-muted">
              Back to Website
            </a>
          </div>
        </div>
      </div>
    </main>
  </div>
  
  <!-- Scripts -->
  <script src="<?= asset('dashboard ui/dist/assets/js/vendors.min.js') ?>"></script>
  <script src="<?= asset('dashboard ui/dist/assets/js/common-init.min.js') ?>"></script>
  
  <!-- Custom Script -->
  <script>
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
      const alerts = document.querySelectorAll('.alert');
      alerts.forEach(function(alert) {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(function() {
          alert.remove();
        }, 500);
      });
    }, 5000);
  </script>
</body>
</html>
