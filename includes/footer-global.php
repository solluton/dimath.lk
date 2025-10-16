<?php
require_once 'config/url_helper.php';
require_once 'config/company_helper.php';

// Get current page for active state
$current_page = basename($_SERVER['PHP_SELF'], '.php');

// Handle special cases for active state detection
if ($current_page == 'index') {
    $current_page = 'home';
} elseif ($current_page == 'about-us') {
    $current_page = 'about';
} elseif ($current_page == 'our-companies') {
    $current_page = 'companies';
} elseif ($current_page == 'contact-us') {
    $current_page = 'contact';
}
?>
<footer class="footer17_component color-scheme-1">
  <div class="padding-global">
    <div class="container-large">
      <div class="padding-vertical padding-xxlarge">
        <div class="padding-bottom padding-xxlarge">
              <div class="w-layout-grid footer17_top-wrapper">
                <div id="w-node-_512c1f74-e384-e22d-ccc4-d80b9abb56d6-9abb56d0" class="footer17_left-wrapper">
                  <div id="w-node-_512c1f74-e384-e22d-ccc4-d80b9abb56d9-9abb56d0" class="w-layout-grid footer17_link-list">
                    <a href="<?php echo url(''); ?>" class="footer17_link <?= ($current_page == 'home') ? 'w--current' : '' ?>">Home</a>
                    <a href="<?php echo url('about-us'); ?>" class="footer17_link <?= ($current_page == 'about') ? 'w--current' : '' ?>">About Us</a>
                    <a href="<?php echo url('our-companies'); ?>" class="footer17_link <?= ($current_page == 'companies') ? 'w--current' : '' ?>">Our Companies</a>
                    <a href="<?php echo url('contact-us'); ?>" class="footer17_link <?= ($current_page == 'contact') ? 'w--current' : '' ?>">Contact Us</a>
                  </div>
                </div>
              </div>
        </div>
        <div class="padding-bottom padding-large">
          <div class="footer17_image-wrapper">
            <a href="<?php echo url(''); ?>" class="footer-logo-link w-inline-block <?= ($current_page == 'home') ? 'w--current' : '' ?>">
              <img loading="lazy" src="<?php echo asset('images/dimath-logo_1.avif'); ?>" alt="Dimath Group" class="footer17_image">
            </a>
          </div>
        </div>
        <div class="divider-horizontal"></div>
        <div class="padding-top padding-medium">
          <div class="footer17_bottom-wrapper">
            <div class="footer17_credit-text">© 2025 Dimath Group. All rights reserved.</div>
            <div class="w-layout-grid footer17_legal-list">
              <a href="<?php echo url('privacy-policy'); ?>" class="footer17_legal-link">Privacy Policy</a>
              <a href="<?php echo url('terms-of-service'); ?>" class="footer17_legal-link">Terms of Service</a>
              <a href="<?php echo url('cookies-policy'); ?>" class="footer17_legal-link">Cookies Policy</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>