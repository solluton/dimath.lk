<?php
// Global header component for admin pages
// This file should be included in all admin pages for consistency
// Make sure $user variable is available from the calling page

// Include URL helper if not already included
if (!function_exists('url')) {
    require_once __DIR__ . '/../../config/url_helper.php';
}

// Determine the correct path prefix based on current directory
$is_admin_page = strpos($_SERVER['PHP_SELF'], '/admin/') !== false;
$path_prefix = $is_admin_page ? '../' : '';
?>

<style>
/* Ensure dropdown menu has white background */
.dropdown-menu {
  background-color: white !important;
  border: 1px solid #dee2e6;
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.dropdown-item {
  color: #212529;
}

.dropdown-item:hover {
  background-color: #f8f9fa;
  color: #212529;
}

.dropdown-item:focus {
  background-color: #f8f9fa;
  color: #212529;
}

/* SweetAlert2 Green Button Text - Make White */
.swal2-styled.swal2-confirm {
  color: white !important;
}

/* Ensure all green buttons have white text */
.swal2-confirm[style*="background-color: #28a745"],
.swal2-confirm[style*="background-color: rgb(40, 167, 69)"],
button[style*="background-color: #28a745"],
button[style*="background-color: rgb(40, 167, 69)"] {
  color: white !important;
}

/* Override any inline styles for green buttons */
.swal2-confirm {
  color: white !important;
}

/* Fix alert message overflow issues */
.alert {
  margin-bottom: 1rem;
  word-wrap: break-word;
  overflow-wrap: break-word;
  max-width: 100%;
}

/* Ensure alerts stay within container */
.edash-page-container .alert {
  margin-left: 0;
  margin-right: 0;
}

/* Responsive alert text */
@media (max-width: 768px) {
  .alert {
    font-size: 0.875rem;
    padding: 0.75rem;
  }
}
</style>

<!-- Header -->
<header class="edash-header sticky-top d-flex align-items-end ht-80" id="edash-header-sticky">
  <div class="edash-header-container w-100 ht-80 px-4 bg-body-tertiary d-flex align-items-center justify-content-between position-relative" id="edash-header-container">
    <!-- Header Left -->
    <div class="edash-header-left d-flex align-items-center gap-2">
      <!-- Desktop Menu Toggle -->
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
      <div class="edash-menu-toggle d-xl-none">
        <a href="javascript:void(0);" class="edash-drop-item d-flex align-items-center justify-content-center rounded-pill ht-40" id="edash-menu-show">
          <i class="fi fi-sr-menu-burger"></i>
        </a>
      </div>
    </div>
    
    <!-- Header Right -->
    <div class="edash-header-right d-flex align-items-center gap-1 gap-sm-2">
      <!-- Visit Website Button -->
      <a href="<?php echo url(''); ?>" target="_blank" class="btn btn-outline-primary btn-sm" title="Visit Website">
        <i class="fi fi-rr-globe me-1"></i>
        <span class="d-none d-sm-inline">Visit Website</span>
      </a>
      
      <!-- Profile Dropdown -->
      <div class="dropdown">
        <button class="btn btn-link dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <div class="edash-profile-info d-none d-sm-block me-2">
            <div class="edash-profile-name">Dimath Sports</div>
          </div>
          <div class="edash-profile-avatar">
            <?php if (!empty($user['profile_picture'])): ?>
              <img src="<?php echo asset($user['profile_picture']); ?>" alt="Profile" class="img-fluid rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
            <?php else: ?>
              <img src="<?php echo asset('images/dimath-logo.avif'); ?>" alt="Dimath Profile" class="img-fluid rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
            <?php endif; ?>
          </div>
        </button>
        <ul class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end">
          <li><a href="<?php echo url('admin/profile.php'); ?>" class="dropdown-item"><i class="fi fi-rr-user me-2"></i>Profile</a></li>
          <li><a href="<?php echo url('admin-password-reset'); ?>" class="dropdown-item"><i class="fi fi-rr-key me-2"></i>Password Reset</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a href="<?php echo url('logout.php'); ?>" class="dropdown-item"><i class="fi fi-rr-sign-out me-2"></i>Logout</a></li>
        </ul>
      </div>
    </div>
  </div>
</header>
