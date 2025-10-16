<?php
require_once 'config/legal_pages_helper.php';
require_once 'config/company_helper.php';

// Get legal page content
$page_content = getLegalPageContent('terms-conditions');
$page_title = $page_content['title'];
$page_html = $page_content['content'];
?>
<!DOCTYPE html><!--  This site was created in Webflow. https://webflow.com  --><!--  Last Published: Fri Oct 10 2025 03:37:42 GMT+0000 (Coordinated Universal Time)  -->
<html data-wf-page="68e2ae8ae7077842f6959053" data-wf-site="68ad40859eb01bffddd9c8af">
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($page_title) ?></title>
  <meta content="By accessing and using Dimath Group, you agree to comply with our Terms of Service. These terms outline the rules, responsibilities, and conditions for using our website, products, and services. Please read them carefully to understand your rights and obligations while interacting with our platform." name="description">
  <meta content="terms of service, terms and conditions, user agreement, legal terms, service terms, website terms, user obligations, legal conditions, terms of use, service agreement, legal disclaimer, user rights, terms compliance, legal framework" name="keywords">
  <meta content="<?= htmlspecialchars($page_title) ?>" property="og:title">
  <meta content="By accessing and using Dimath Group, you agree to comply with our Terms of Service. These terms outline the rules, responsibilities, and conditions for using our website, products, and services. Please read them carefully to understand your rights and obligations while interacting with our platform." property="og:description">
  <meta content="https://cdn.prod.website-files.com/68ad40859eb01bffddd9c8af/68c004ffcbd066f1af9fe9ef_Dimath%20group.png" property="og:image">
  <meta content="<?= htmlspecialchars($page_title) ?>" property="twitter:title">
  <meta content="By accessing and using Dimath Group, you agree to comply with our Terms of Service. These terms outline the rules, responsibilities, and conditions for using our website, products, and services. Please read them carefully to understand your rights and obligations while interacting with our platform." property="twitter:description">
  <meta property="og:type" content="website">
  <meta content="summary_large_image" name="twitter:card">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <meta name="robots" content="noindex, nofollow, noarchive, nosnippet" />
  <meta content="Webflow" name="generator">
  <link href="css/normalize.css" rel="stylesheet" type="text/css">
  <link href="css/webflow.css" rel="stylesheet" type="text/css">
  <link href="css/dimath-lk.webflow.css" rel="stylesheet" type="text/css">
  <script type="text/javascript">!function(o,c){var n=c.documentElement,t=" w-mod-";n.className+=t+"js",("ontouchstart"in o||o.DocumentTouch&&c instanceof DocumentTouch)&&(n.className+=t+"touch")}(window,document);</script>
  <link href="images/favicon.png" rel="shortcut icon" type="image/x-icon">
  <link href="images/webclip.png" rel="apple-touch-icon"><!--  Keep this css code to improve the font quality -->
  <style>
  * {
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  -o-font-smoothing: antialiased;
}
</style>
</head>
<body>
  <?php include 'includes/navbar-global.php'; ?>
  <div class="page-wrapper">
    <div class="global-styles">
      <div class="style-overrides w-embed">
        <style>
/* Ensure all elements inherit the color from its parent */
a,
.w-input,
.w-select,
.w-tab-link,
.w-nav-link,
.w-nav-brand,
.w-dropdown-btn,
.w-dropdown-toggle,
.w-slider-arrow-left,
.w-slider-arrow-right,
.w-dropdown-link {
  color: inherit;
  text-decoration: inherit;
  font-size: inherit;
}
/* Focus state style for keyboard navigation for the focusable elements */
*[tabindex]:focus-visible,
  input[type="file"]:focus-visible {
   outline: 0.125rem solid #4d65ff;
   outline-offset: 0.125rem;
}
/* Get rid of top margin on first element in any rich text element */
.w-richtext > :not(div):first-child, .w-richtext > div:first-child > :first-child {
  margin-top: 0 !important;
}
/* Get rid of bottom margin on last element in any rich text element */
.w-richtext>:last-child, .w-richtext ol li:last-child, .w-richtext ul li:last-child {
	margin-bottom: 0 !important;
}
/* Prevent all click and hover interaction with an element */
.pointer-events-off {
	pointer-events: none;
}
/* Enables all click and hover interaction with an element */
.pointer-events-on {
  pointer-events: auto;
}
/* Create a class of .div-square which maintains a 1:1 dimension of a div */
.div-square::after {
	content: "";
	display: block;
	padding-bottom: 100%;
}
/* Make sure containers never lose their center alignment */
.container-medium,.container-small, .container-large {
	margin-right: auto !important;
  margin-left: auto !important;
}
/* Apply "..." after 3 lines of text */
.text-style-3lines {
	display: -webkit-box;
	overflow: hidden;
	-webkit-line-clamp: 3;
	-webkit-box-orient: vertical;
}
/* Apply "..." after 2 lines of text */
.text-style-2lines {
	display: -webkit-box;
	overflow: hidden;
	-webkit-line-clamp: 2;
	-webkit-box-orient: vertical;
}
/* Adds inline flex display */
.display-inlineflex {
  display: inline-flex;
}
/* These classes are never overwritten */
.hide {
  display: none !important;
}
/* Remove default Webflow chevron from form select */
select{
  -webkit-appearance:none;
}
@media screen and (max-width: 991px) {
    .hide, .hide-tablet {
        display: none !important;
    }
}
  @media screen and (max-width: 767px) {
    .hide-mobile-landscape{
      display: none !important;
    }
}
  @media screen and (max-width: 479px) {
    .hide-mobile{
      display: none !important;
    }
}
.margin-0 {
  margin: 0rem !important;
}
.padding-0 {
  padding: 0rem !important;
}
.spacing-clean {
padding: 0rem !important;
margin: 0rem !important;
}
.margin-top {
  margin-right: 0rem !important;
  margin-bottom: 0rem !important;
  margin-left: 0rem !important;
}
.padding-top {
  padding-right: 0rem !important;
  padding-bottom: 0rem !important;
  padding-left: 0rem !important;
}
.margin-right {
  margin-top: 0rem !important;
  margin-bottom: 0rem !important;
  margin-left: 0rem !important;
}
.padding-right {
  padding-top: 0rem !important;
  padding-bottom: 0rem !important;
  padding-left: 0rem !important;
}
.margin-bottom {
  margin-top: 0rem !important;
  margin-right: 0rem !important;
  margin-left: 0rem !important;
}
.padding-bottom {
  padding-top: 0rem !important;
  padding-right: 0rem !important;
  padding-left: 0rem !important;
}
.margin-left {
  margin-top: 0rem !important;
  margin-right: 0rem !important;
  margin-bottom: 0rem !important;
}
.padding-left {
  padding-top: 0rem !important;
  padding-right: 0rem !important;
  padding-bottom: 0rem !important;
}
.margin-horizontal {
  margin-top: 0rem !important;
  margin-bottom: 0rem !important;
}
.padding-horizontal {
  padding-top: 0rem !important;
  padding-bottom: 0rem !important;
}
.margin-vertical {
  margin-right: 0rem !important;
  margin-left: 0rem !important;
}
.padding-vertical {
  padding-right: 0rem !important;
  padding-left: 0rem !important;
}
/* Apply "..." at 100% width */
.truncate-width { 
		width: 100%; 
    white-space: nowrap; 
    overflow: hidden; 
    text-overflow: ellipsis; 
}
/* Removes native scrollbar */
.no-scrollbar {
    -ms-overflow-style: none;
    overflow: -moz-scrollbars-none; 
}
.no-scrollbar::-webkit-scrollbar {
    display: none;
}
</style>
      </div>
      <div class="fonts w-embed">
        <style>@import url('https://fonts.googleapis.com/css?family=Poppins:500')</style>
        <style>@import url('https://fonts.googleapis.com/css?family=Inter:400,500')</style>
      </div>
      <div class="color-schemes w-embed">
        <style>
.color-scheme-1 {}
  .color-scheme-2 {
    --color-scheme-1--text: var(--color-scheme-2--text);
    --color-scheme-1--background: var(--color-scheme-2--background);
    --color-scheme-1--foreground: var(--color-scheme-2--foreground);
    --color-scheme-1--border: var(--color-scheme-2--border);
    --color-scheme-1--accent: var(--color-scheme-2--accent);
  }
  .color-scheme-3 {
    --color-scheme-1--text: var(--color-scheme-3--text);
    --color-scheme-1--background: var(--color-scheme-3--background);
    --color-scheme-1--foreground: var(--color-scheme-3--foreground);
    --color-scheme-1--border: var(--color-scheme-3--border);
    --color-scheme-1--accent: var(--color-scheme-3--accent);
  }
  .color-scheme-4 {
    --color-scheme-1--text: var(--color-scheme-4--text);
    --color-scheme-1--background: var(--color-scheme-4--background);
    --color-scheme-1--foreground: var(--color-scheme-4--foreground);
    --color-scheme-1--border: var(--color-scheme-4--border);
    --color-scheme-1--accent: var(--color-scheme-4--accent);
  }
  .color-scheme-5 {
    --color-scheme-1--text: var(--color-scheme-5--text);
    --color-scheme-1--background: var(--color-scheme-5--background);
    --color-scheme-1--foreground: var(--color-scheme-5--foreground);
    --color-scheme-1--border: var(--color-scheme-5--border);
    --color-scheme-1--accent: var(--color-scheme-5--accent);
  }
  .color-scheme-6 {
    --color-scheme-1--text: var(--color-scheme-6--text);
    --color-scheme-1--background: var(--color-scheme-6--background);
    --color-scheme-1--foreground: var(--color-scheme-6--foreground);
    --color-scheme-1--border: var(--color-scheme-6--border);
    --color-scheme-1--accent: var(--color-scheme-6--accent);
  }
.w-slider-dot {
  background-color: var(--color-scheme-1--text);
  opacity: 0.20;
}
.w-slider-dot.w-active {
  background-color: var(--color-scheme-1--text);
  opacity: 1;
}
/* Override .w-slider-nav-invert styles */
.w-slider-nav-invert .w-slider-dot {
  background-color: var(--color-scheme-1--text) !important;
  opacity: 0.20 !important;
}
.w-slider-nav-invert .w-slider-dot.w-active {
  background-color: var(--color-scheme-1--text) !important;
  opacity: 1 !important;
}
</style>
      </div>
    </div>
    <div data-collapse="medium" data-animation="default" data-duration="400" fs-scrolldisable-element="smart-nav" data-easing="ease" data-easing2="ease" role="banner" class="navbar1_component color-scheme-3 w-nav">
      <div class="navbar1_container">
        <a href="index.html" class="navbar1_logo-link w-nav-brand"><img loading="lazy" src="images/Dimath-Logo_2.avif" alt="" class="navbar1_logo"></a>
        <nav role="navigation" class="navbar1_menu is-page-height-tablet w-nav-menu">
          <div class="navbar1_menu-links">
            <a href="index.html" class="navbar1_link is-mobile-nav-link w-nav-link">Home</a>
            <a href="about-us.html" class="navbar1_link is-mobile-nav-link w-nav-link">About Us</a>
            <a href="our-companies.html" class="navbar1_link is-mobile-nav-link w-nav-link">Our Companies</a>
            <a href="contact-us.html" class="navbar1_link is-mobile-nav-link w-nav-link">Contact us</a>
          </div>
          <div class="navbar1_menu-buttons">
            <a href="#" class="button is-small is-mobile-nav w-button">Call Now</a>
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
    <main class="main-wrapper">
      <header class="section_header65 color-scheme-3">
        <div class="padding-global">
          <div class="container-large">
            <div class="padding-section-small">
              <div class="header65_component">
                <div class="text-align-center">
                  <div class="max-width-large align-center">
                    <div class="margin-bottom margin-small">
                      <h1 data-w-id="f1f7528f-895d-4fec-09c8-9a04b734e9db" style="opacity:0" class="heading-style-h2">
                        <?= htmlspecialchars($page_title) ?>
                      </h1>
                    </div>
                   </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </header>
      <section class="section_contact12 color-scheme-3">
        <div class="padding-global">
          <div class="container-large">
            <div class="padding-section-medium">
              <div class="contact12_component">
                <div class="w-richtext">
                  <?= $page_html ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
    <?php include 'includes/footer-global.php'; ?>
  </div>
  <script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=68ad40859eb01bffddd9c8af" type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="js/webflow.js" type="text/javascript"></script>
</body>
</html>