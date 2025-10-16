<?php
require_once 'config/url_helper.php';
require_once 'config/company_helper.php';

// Get current page for active state
$current_page = basename($_SERVER['PHP_SELF'], '.php');
$current_path = $_SERVER['REQUEST_URI'];

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

<style>
/* Body top padding for fixed navbar */
body {
  padding-top: 5rem;
}

/* Mobile padding adjustment */
@media screen and (max-width: 767px) {
  body {
    padding-top: 4.6rem;
  }
}

/* Navbar scroll shadow effect */
.navbar1_component {
  transition: box-shadow 0.3s ease;
}

.navbar1_component.scrolled {
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* Navbar Active State Styling */
.navbar1_link.w--current {
  color: #28a745 !important;
}

.navbar1_logo-link.w--current {
  opacity: 1;
}

/* Lenis Smooth Scrolling */
html.lenis {
  height: auto;
}
.lenis.lenis-smooth {
  scroll-behavior: auto;
}
.lenis.lenis-smooth [data-lenis-prevent] {
  overscroll-behavior: contain;
}
.lenis.lenis-stopped {
  overflow: hidden;
}
</style>

<!-- Lenis Smooth Scrolling Library -->
<script src="https://cdn.jsdelivr.net/gh/studio-freight/lenis@1.0.23/bundled/lenis.min.js"></script>

<script>
// Initialize Lenis smooth scrolling
document.addEventListener('DOMContentLoaded', function() {
  // Initialize Lenis
  const lenis = new Lenis({
    duration: 1.2,
    easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
    direction: 'vertical',
    gestureDirection: 'vertical',
    smooth: true,
    mouseMultiplier: 1,
    smoothTouch: false,
    touchMultiplier: 2,
    infinite: false,
  });

  // Add scroll shadow effect to navbar
  const navbar = document.querySelector('.navbar1_component');
  
  if (navbar) {
    lenis.on('scroll', (e) => {
      if (e.scroll > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });
  }

  // Animation frame loop
  function raf(time) {
    lenis.raf(time);
    requestAnimationFrame(raf);
  }
  requestAnimationFrame(raf);
});
</script>
<div data-collapse="medium" data-animation="default" data-duration="400" fs-scrolldisable-element="smart-nav" data-easing="ease" data-easing2="ease" role="banner" class="navbar1_component color-scheme-3 w-nav">
  <div class="navbar1_container">
    <a href="<?php echo url(''); ?>" class="navbar1_logo-link w-nav-brand <?= ($current_page == 'home') ? 'w--current' : '' ?>">
      <img loading="lazy" src="<?php echo asset('images/Dimath-Logo_2.avif'); ?>" alt="Dimath Group" class="navbar1_logo">
    </a>
    <nav role="navigation" class="navbar1_menu is-page-height-tablet w-nav-menu">
      <div class="navbar1_menu-links">
        <a href="<?php echo url(''); ?>" class="navbar1_link is-mobile-nav-link w-nav-link <?= ($current_page == 'home') ? 'w--current' : '' ?>">Home</a>
        <a href="<?php echo url('about-us'); ?>" class="navbar1_link is-mobile-nav-link w-nav-link <?= ($current_page == 'about') ? 'w--current' : '' ?>">About Us</a>
        <a href="<?php echo url('our-companies'); ?>" class="navbar1_link is-mobile-nav-link w-nav-link <?= ($current_page == 'companies') ? 'w--current' : '' ?>">Our Companies</a>
        <a href="<?php echo url('contact-us'); ?>" class="navbar1_link is-mobile-nav-link w-nav-link <?= ($current_page == 'contact') ? 'w--current' : '' ?>">Contact us</a>
      </div>
      <div class="navbar1_menu-buttons">
        <a href="<?php echo getCompanyPhoneHref(); ?>" class="button is-small is-mobile-nav w-button">Call Now</a>
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