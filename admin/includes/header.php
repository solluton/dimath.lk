<?php
// This header include assumes the file is called from admin directory
// Make sure $user variable is available from the calling page
?>

<header class="edash-header navbar-light bg-body-tertiary border-bottom w-100 z-3">
  <div class="edash-header-container">
    <div class="edash-header-start">
      <div class="edash-header-logo-wrapper"></div>
    </div>
    <div class="edash-header-end">
      <div class="edash-header-right d-flex align-items-center gap-2">
        <!-- Visit Website Button -->
        <a href="../" target="_blank" class="btn btn-outline-primary btn-sm" title="Visit Website">
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
                <img src="../<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile" class="img-fluid rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
              <?php else: ?>
                <img src="<?php echo asset('images/dimath-logo.avif'); ?>" alt="Dimath Profile" class="img-fluid rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
              <?php endif; ?>
            </div>
          </button>
          <ul class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end">
            <li><a href="/admin/profile" class="dropdown-item"><i class="fi fi-rr-user me-2"></i>Profile</a></li>
            <li><a href="/admin-password-reset" class="dropdown-item"><i class="fi fi-rr-key me-2"></i>Password Reset</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a href="/logout" class="dropdown-item"><i class="fi fi-rr-sign-out me-2"></i>Logout</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</header>
