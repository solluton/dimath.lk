<?php
// Global footer component for admin pages
// This file should be included in all admin pages for consistency

// Include URL helper for clean URL generation
require_once __DIR__ . '/../../config/url_helper.php';

// Determine the correct path prefix based on current directory
$is_admin_page = strpos($_SERVER['PHP_SELF'], '/admin/') !== false;
$path_prefix = $is_admin_page ? '../' : '';
?>

      <!-- Footer -->
      <footer class="edash-footer-container d-flex align-items-center justify-content-between p-4 ht-64 bg-body-tertiary" id="edash-footer-container">
        <div class="hstack gap-1">
          <span class="text-muted">© 2025 Dimath Sports All rights reserved</span>
        </div>
        <div class="d-flex align-items-center gap-3">
          <a href="<?php echo url('privacy-policy'); ?>" class="text-muted text-decoration-none" style="transition: color 0.3s ease;" onmouseover="this.style.color='#28a745'" onmouseout="this.style.color='#6c757d'">Privacy Policy</a>
          <a href="<?php echo url('terms-of-service'); ?>" class="text-muted text-decoration-none" style="transition: color 0.3s ease;" onmouseover="this.style.color='#28a745'" onmouseout="this.style.color='#6c757d'">Terms of Service</a>
          <a href="https://solluton.com" target="_blank" class="text-muted text-decoration-none" style="transition: color 0.3s ease;" onmouseover="this.style.color='#28a745'" onmouseout="this.style.color='#6c757d'">A website by Solluton</a>
        </div>
      </footer>
