<?php
require_once 'config/url_helper.php';
?>
<div data-animation="default" class="navbar1_component color-scheme-1 w-nav" data-easing2="ease" fs-scrolldisable-element="smart-nav" data-easing="ease" data-collapse="medium" role="banner" data-duration="400">
  <div class="navbar1_container">
    <a href="<?php echo url(''); ?>" class="navbar1_logo-link w-nav-brand">
      <img loading="lazy" src="<?php echo asset('images/dimath-logo.avif'); ?>" alt="Dimath Sports" class="navbar1_logo">
    </a>
    <nav role="navigation" class="navbar1_menu is-page-height-tablet w-nav-menu">
      <div class="navbar1_menu-links">
        <a href="<?php echo url(''); ?>" class="navbar1_link w-nav-link">Home</a>
        <a href="<?php echo url('about'); ?>" class="navbar1_link w-nav-link">About Us</a>
        <a href="<?php echo url('our-products'); ?>" class="navbar1_link w-nav-link">Products</a>
        <a href="<?php echo url('our-process'); ?>" class="navbar1_link w-nav-link">Our Process</a>
      </div>
      <div class="navbar1_menu-buttons">
        <a href="<?php echo url('contact'); ?>" class="button is-nav-button w-button">CONTACT US</a>
      </div>
    </nav>
    <div class="navbar1_menu-button w-nav-button">
      <div class="menu-icon1">
        <div class="menu-icon1_line-top"></div>
        <div class="menu-icon1_line-middle">
          <div class="menu-icon1_line-middle-inner"></div>
        </div>
        <div class="menu-icon1_line-bottom"></div>
      </div>
    </div>
  </div>
</div>