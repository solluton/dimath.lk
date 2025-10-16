<?php
require_once __DIR__ . '/../config/database.php';

// Require login
requireLogin();

$user = getCurrentUser();
$message = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    
    // Validate inputs
    if (empty($name)) {
        $error = 'Name is required.';
    } elseif (empty($email)) {
        $error = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        try {
            $pdo = getDBConnection();
            
            // Check if email is already taken by another user
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
            $stmt->execute([$email, $user['id']]);
            if ($stmt->fetch()) {
                $error = 'This email is already taken by another user.';
            } else {
                // Handle profile picture upload
                $profile_picture = $user['profile_picture'] ?? null;
                
                if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = '../uploads/profile-pictures/';
                    
                    // Create directory if it doesn't exist
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    
                    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                    $maxSize = 5 * 1024 * 1024; // 5MB
                    
                    $file = $_FILES['profile_picture'];
                    $fileType = $file['type'];
                    $fileSize = $file['size'];
                    
                    // Validate file type
                    if (!in_array($fileType, $allowedTypes)) {
                        $error = 'Invalid file type. Please upload JPEG, PNG, GIF, or WebP images only.';
                    } elseif ($fileSize > $maxSize) {
                        $error = 'File size too large. Please upload images smaller than 5MB.';
                    } else {
                        // Generate unique filename
                        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                        $filename = 'profile_' . $user['id'] . '_' . time() . '.' . $extension;
                        $uploadPath = $uploadDir . $filename;
                        
                        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                            // Delete old profile picture if it exists
                            if (!empty($user['profile_picture']) && file_exists('../' . $user['profile_picture'])) {
                                unlink('../' . $user['profile_picture']);
                            }
                            $profile_picture = 'uploads/profile-pictures/' . $filename;
                        } else {
                            $error = 'Failed to upload profile picture. Please try again.';
                        }
                    }
                }
                
                if (empty($error)) {
                    // Update user profile
                    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, profile_picture = ? WHERE id = ?");
                    $result = $stmt->execute([$name, $email, $profile_picture, $user['id']]);
                    
                    if ($result) {
                        $message = 'Profile updated successfully!';
                        // Refresh user data
                        $user = getCurrentUser();
                        // Set success flag for JavaScript
                        echo '<script>var profileUpdateSuccess = true;</script>';
                    } else {
                        $error = 'Failed to update profile. Please try again.';
                    }
                }
            }
        } catch(PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
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
  <meta name="description" content="NeoMed Pharma - Profile Management" />
  <meta name="keyword" content="neomed, pharma, profile, admin" />
  <meta name="author" content="NeoMed Pharma" />
  <title>Profile | Dimath Sports - Admin Dashboard</title>
  
  <!-- Favicon -->
  <link href="../images/favicon.png" rel="shortcut icon" type="image/x-icon">
  <link href="../images/webclip.png" rel="apple-touch-icon">
  
  <!-- Dashboard UI CSS -->
  <link rel="stylesheet" href="../dashboard ui/dist/assets/vendors/metismenu/metisMenu.min.css">
  <link rel="stylesheet" href="../dashboard ui/dist/assets/vendors/@flaticon/flaticon-uicons/css/all/all.css">
  <link rel="stylesheet" type="text/css" href="../dashboard ui/dist/assets/css/theme.min.css">
  
  <!-- NeoMed Custom Dashboard Colors -->
  <link rel="stylesheet" href="../css/dashboard-custom.css">
  
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
                <h2 class="h4 fw-semibold text-dark">Profile Management</h2>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                      <a href="dashboard.php">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                      Profile
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
          
          <!-- Profile Form -->
          <div class="row">
            <div class="col-lg-8">
              <div class="card">
                <div class="card-header">
                  <h5 class="card-title mb-0">Profile Information</h5>
                </div>
                <div class="card-body">
                  <form method="POST" action="" enctype="multipart/form-data" id="profileForm">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label for="name" class="form-label">Full Name</label>
                          <input type="text" class="form-control" id="name" name="name" 
                                 value="<?php echo htmlspecialchars($user['name']); ?>" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label for="email" class="form-label">Email Address</label>
                          <input type="email" class="form-control" id="email" name="email" 
                                 value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                      </div>
                    </div>
                    
                    <div class="mb-3">
                      <label for="profile_picture" class="form-label">Profile Picture</label>
                      <input type="file" class="form-control" id="profile_picture" name="profile_picture" 
                             accept="image/jpeg,image/jpg,image/png,image/gif,image/webp" onchange="previewProfileImage(this)">
                      <div class="form-text">
                        Upload a new profile picture. Supported formats: JPEG, PNG, GIF, WebP. Max size: 5MB.
                      </div>
                      <div id="profile-preview" class="mt-2" style="display: none;">
                        <img id="preview-profile-img" src="" alt="Preview" style="max-width: 150px; max-height: 150px; border: 1px solid #ddd; border-radius: 8px;">
                      </div>
                    </div>
                    
                    <div class="d-flex gap-2">
                      <button type="button" class="btn btn-primary" onclick="confirmProfileUpdate()">
                        <i class="fi fi-rr-disk me-2"></i>Update Profile
                      </button>
                      <a href="dashboard.php" class="btn btn-outline-primary">
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
                  <h5 class="card-title mb-0">Current Profile</h5>
                </div>
                <div class="card-body text-center">
                  <div class="mb-3">
                    <?php if (!empty($user['profile_picture'])): ?>
                      <img src="<?php echo asset($user['profile_picture']); ?>" 
                           alt="Profile Picture" class="img-fluid rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                    <?php else: ?>
                     <img src="<?php echo asset('images/dimath-logo.avif'); ?>" alt="Dimath Profile Picture" 
                           class="img-fluid rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                    <?php endif; ?>
                  </div>
                  <h6 class="mb-1"><?php echo htmlspecialchars($user['name']); ?></h6>
                  <p class="text-muted mb-0"><?php echo htmlspecialchars($user['email']); ?></p>
                  <small class="text-muted">Role: <?php echo ucfirst($user['role']); ?></small>
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
  <script src="../dashboard ui/dist/assets/js/vendors.min.js"></script>
  <script src="../dashboard ui/dist/assets/js/common-init.min.js"></script>
  
  <script>
    // Profile image preview
    function previewProfileImage(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('preview-profile-img').src = e.target.result;
          document.getElementById('profile-preview').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
      }
    }
    
    // Profile update confirmation
    function confirmProfileUpdate() {
      Swal.fire({
        title: 'Update Profile?',
        text: 'Are you sure you want to update your profile information?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, update profile!',
        cancelButtonText: 'Cancel',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          // Submit the form
          document.getElementById('profileForm').submit();
        }
      });
    }
    
    // Show success message after profile update
    document.addEventListener('DOMContentLoaded', function() {
      if (typeof profileUpdateSuccess !== 'undefined' && profileUpdateSuccess) {
        Swal.fire({
          title: 'Profile Updated!',
          text: 'Your profile has been updated successfully.',
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

