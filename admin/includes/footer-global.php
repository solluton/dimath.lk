<?php
// Global footer component for admin pages
// This file should be included in all admin pages for consistency
?>

      <?php include 'includes/footer-content.php'; ?>
    </main>
    <!-- End:: Main Content -->
    
    <!-- Menu Backdrop -->
    <div class="edash-menu-backdrop" id="edash-menu-hide"></div>
  </div>
  <!-- End:: Main Wrapper -->
  
  <!-- Scripts -->
  <script src="<?= $path_prefix ?? '../' ?>dashboard ui/dist/assets/js/vendors.min.js"></script>
  <script src="<?= $path_prefix ?? '../' ?>dashboard ui/dist/assets/js/common-init.min.js"></script>
  
  <!-- Custom Script -->
  <script>
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
      const alerts = document.querySelectorAll('.alert');
      alerts.forEach(function(alert) {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
      });
    }, 5000);
  </script>
</body>
</html>
