<?php
// Global footer component for admin pages
// This file should be included in all admin pages for consistency
?>

      <!-- Footer -->
      <footer class="edash-footer-container d-flex align-items-center justify-content-between p-4 ht-64 bg-body-tertiary" id="edash-footer-container">
        <div class="hstack gap-1">
          <span class="text-muted">
            <script>
              document.write(new Date().getFullYear());
            </script>
            &copy;
          </span>
          <span class="vr mx-2 bg-body-secondary"></span>
          <a href="#" class="text-muted">Dimath Sports</a>
        </div>
        <div class="d-flex align-items-center gap-3">
          <a href="<?php echo url('about-us'); ?>" target="_blank" class="d-none d-sm-block text-muted">About</a>
          <a href="<?php echo url('contact'); ?>" target="_blank" class="d-none d-sm-block text-muted">Contact</a>
          <a href="<?php echo url('privacy-policies'); ?>" target="_blank" class="text-muted">Privacy</a>
          <a href="<?php echo url('terms-conditions'); ?>" target="_blank" class="text-muted">Terms</a>
        </div>
      </footer>
