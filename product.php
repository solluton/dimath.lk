<?php
require_once 'config/database.php';
require_once 'config/product_functions.php';
require_once 'config/url_helper.php';
$slug = $_GET['slug'] ?? null;
$product = $slug ? getProductBySlug($slug) : getDefaultProduct();
if (!$product) { include '404.php'; exit; }
    $meta = generateProductMeta($product);
?>
<!DOCTYPE html><!--  This site was created in Webflow. https://webflow.com  --><!--  Last Published: Fri Oct 10 2025 03:32:47 GMT+0000 (Coordinated Universal Time)  -->
<html data-wf-page="68a97464012d996d39df4d82" data-wf-site="68a97272fd9451940c9bc44f">
<head>
  <meta charset="utf-8">
  <title><?php echo htmlspecialchars($meta['title']); ?></title>
  <meta content="<?php echo htmlspecialchars($meta['title']); ?>" property="og:title">
  <meta content="<?php echo htmlspecialchars($meta['description']); ?>" name="description">
  <meta content="<?php echo htmlspecialchars($meta['description']); ?>" property="og:description">
  <meta content="<?php echo htmlspecialchars($meta['title']); ?>" property="twitter:title">
  <meta content="<?php echo htmlspecialchars($meta['description']); ?>" property="twitter:description">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <meta content="Webflow" name="generator">
  <?php include 'includes/scripts-global.php'; ?>
  <?php require_once __DIR__ . '/config/company_helper.php'; ?>
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" type="text/javascript"></script>
  <script type="text/javascript">WebFont.load({  google: {    families: ["Montserrat:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic"]  }});</script>
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
        <style>@import url('https://fonts.googleapis.com/css?family=Bebas%20Neue:400')</style>
        <style>@import url('https://fonts.googleapis.com/css?family=Montserrat:400,500')</style>
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
    <?php include 'includes/navbar-global.php'; ?>
    <main class="main-wrapper">
      <header class="section_product-header5 color-scheme-1">
        <div class="padding-global">
          <div class="container-large">
            <div class="padding-section-medium">
              <div class="product-header5_component">
                <div class="w-layout-grid product-header5_layout">
                  <div data-w-id="6f4165df-ce2b-d605-986b-f4628c5d78f5" style="opacity:0" class="product-header5_gallery">
                    <a href="#" class="product-header5_lightbox-link w-inline-block w-lightbox">
                      <div class="product-header5_main-image-wrapper"><img loading="lazy" src="<?php echo asset(getProductMainImage($product) ?: 'images/placeholder-image.svg'); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" class="product-header5_main-image"></div>
                      <script type="application/json" class="w-json">{
  "items": [],
  "group": ""
}</script>
                    </a>
                    <?php $gallery = getProductGalleryImages($product); if (!empty($gallery)): ?>
                    <div class="product-header5_list-wrapper hide-tablet">
                      <div class="product-header5_list">
                        <?php foreach ($gallery as $gimg): ?>
                        <div class="product-header5_item">
                          <div class="product-header5_image-wrapper"><img loading="lazy" src="<?php echo asset($gimg); ?>" alt="<?php echo htmlspecialchars($product['title']); ?> gallery" class="product-header5_image"></div>
                        </div>
                        <?php endforeach; ?>
                      </div>
                    </div>
                    <?php endif; ?>
                  </div>
                  <div data-w-id="6f4165df-ce2b-d605-986b-f4628c5d7913" style="opacity:0" class="product-header5_product-details">
                    <div class="margin-bottom margin-small">
                  <div class="breadcrumb_component">
                    <a href="#" class="breadcrumb-link w-inline-block">
                          <div>Shop all</div>
                        </a>
                        <div class="breadcrumb-divider w-embed"><svg width="16" height="16" viewbox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 3L11 8L6 13" stroke="CurrentColor" stroke-width="1.5"></path>
                          </svg></div>
                        <a href="#" class="breadcrumb-link w-inline-block">
                          <div>Category</div>
                    </a>
                    <div class="breadcrumb-divider w-embed"><svg width="16" height="16" viewbox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M6 3L11 8L6 13" stroke="CurrentColor" stroke-width="1.5"></path>
                        </svg></div>
                    <a href="#" class="breadcrumb-link w-inline-block">
                          <div>Cricket Bat</div>
                    </a>
                  </div>
                </div>
                    <div class="margin-bottom margin-small">
                      <div class="product-header5_heading-wrapper">
                        <h1 class="heading-style-h3"><?php echo htmlspecialchars($product['title']); ?></h1>
                      </div>
                    </div>
                    <div class="margin-bottom margin-small">
                      <p><?php echo htmlspecialchars($product['description'] ?? ''); ?></p>
                    </div>
                    <div class="margin-bottom margin-small">
                      <div class="product-cta-buttons-wrapper">
                        <a href="<?php echo url('contact'); ?>" class="button w-button">Contact Us</a>
                        <a href="<?php echo htmlspecialchars(getCompanyPhoneHref()); ?>" class="button is-secondary is-alternate w-button">Call Us</a>
                      </div>
                    </div>
                    <div class="product-header5_accordion-wrapper">
                      <div class="product-header5_accordion">
                        <div class="product-header5_heading">
                          <div class="text-weight-semibold text-size-medium-2">Details</div>
                          <div class="product-header5_accordion-icon">
                            <div class="icon-embed-xsmall w-embed"><svg width="100%" height="100%" viewbox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19.0002 12.25V12.75C19.0002 13.0261 18.7764 13.25 18.5003 13.25H12.7502V19C12.7502 19.2761 12.5264 19.5 12.2502 19.5H11.7503C11.4741 19.5 11.2502 19.2761 11.2502 19V13.25H5.50025C5.2241 13.25 5.00024 13.0261 5.00024 12.75V12.25C5.00024 11.9739 5.2241 11.75 5.50025 11.75H11.2502V6C11.2502 5.72385 11.4741 5.5 11.7503 5.5H12.2502C12.5264 5.5 12.7502 5.72385 12.7502 6V11.75H18.5003C18.7764 11.75 19.0002 11.9739 19.0002 12.25Z" fill="currentColor"></path>
                              </svg></div>
                          </div>
                        </div>
                        <div class="product-header5_details">
                          <div class="margin-bottom margin-small">
                            <p><?php echo htmlspecialchars($product['details'] ?? ''); ?></p>
                          </div>
                        </div>
                      </div>
              </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </header>
      <section class="section_product5 color-scheme-3">
        <div class="padding-global">
          <div class="container-large">
            <div class="padding-section-large">
              <div class="product5_component">
                <div class="margin-bottom margin-xxlarge">
                  <div class="product5_heading-wrapper">
                    <div data-w-id="6f4165df-ce2b-d605-986b-f4628c5d7981" style="opacity:0" class="product5_heading">
                      <div class="max-width-large">
                        <div class="margin-bottom margin-xsmall">
                          <div class="text-style-tagline">Essentials</div>
                        </div>
                        <div class="margin-bottom margin-xsmall">
                          <h2 class="heading-style-h2">Similar <span class="text-color-white">Products</span></h2>
                        </div>
                        <p class="text-size-medium">Explore our diverse range of sports equipment today!</p>
                      </div>
                    </div>
                    <div class="button-group is-right hide-mobile-landscape">
                      <a data-w-id="6f4165df-ce2b-d605-986b-f4628c5d798c" style="opacity:0" href="<?= url('our-products') ?>" class="button is-secondary is-alternate w-button">View All</a>
                    </div>
                  </div>
                </div>
                <?php $featured = function_exists('getFeaturedProducts') ? getFeaturedProducts(8) : []; ?>
                <div data-delay="4000" data-animation="slide" class="product5_slider w-slider" data-autoplay="false" data-easing="ease" data-hide-arrows="false" data-disable-swipe="false" data-autoplay-limit="0" data-nav-spacing="3" data-duration="500" data-infinite="false">
                  <div class="product5_mask w-slider-mask">
                    <?php if (!empty($featured)): ?>
                      <?php foreach ($featured as $fp): ?>
                      <div class="product5_slide w-slide">
                        <div class="product5_item">
                          <a href="<?php echo url('product/' . urlencode($fp['slug'])); ?>" class="product5_item-link w-inline-block">
                            <div class="margin-bottom margin-xsmall">
                              <div class="product5_image-wrapper"><img loading="lazy" src="<?php echo asset($fp['main_image'] ?: 'images/placeholder-image.svg'); ?>" alt="<?php echo htmlspecialchars($fp['title']); ?>" class="product5_image"></div>
                            </div>
                            <div class="product-content-wrapper">
                              <div class="product5_title-wrapper">
                                <h3><?php echo htmlspecialchars($fp['title']); ?></h3>
                                <?php if (!empty($fp['category'])): ?><div class="text-size-small text-style-allcaps"><?php echo htmlspecialchars($fp['category']); ?></div><?php endif; ?>
                              </div>
                            </div>
                          </a>
                        </div>
                      </div>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <div class="product5_slide w-slide">
                        <div class="product5_item">
                          <div class="margin-bottom margin-xsmall">
                            <div class="product5_image-wrapper"><img loading="lazy" src="<?php echo asset(getProductMainImage($product) ?: 'images/placeholder-image.svg'); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" class="product5_image"></div>
                          </div>
                          <div class="product-content-wrapper">
                            <div class="product5_title-wrapper">
                              <h3><?php echo htmlspecialchars($product['title']); ?></h3>
                              <?php if (!empty($product['category'])): ?><div class="text-size-small text-style-allcaps"><?php echo htmlspecialchars($product['category']); ?></div><?php endif; ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php endif; ?>
                  </div>
                  <div class="slider-arrow is-bottom-previous w-slider-arrow-left">
                    <div class="slider-arrow-icon_default w-embed"><svg width="100%" height="100%" viewbox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3.31066 8.75001L9.03033 14.4697L7.96967 15.5303L0.439339 8.00001L7.96967 0.469676L9.03033 1.53034L3.31066 7.25001L15.5 7.25L15.5 8.75L3.31066 8.75001Z" fill="currentColor"></path>
                      </svg></div>
                  </div>
                  <div class="slider-arrow is-bottom-next w-slider-arrow-right">
                    <div class="slider-arrow-icon_default w-embed"><svg width="100%" height="100%" viewbox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.6893 7.25L6.96967 1.53033L8.03033 0.469666L15.5607 8L8.03033 15.5303L6.96967 14.4697L12.6893 8.75H0.5V7.25H12.6893Z" fill="currentColor"></path>
                      </svg></div>
                  </div>
                  <div class="product5_slide-nav w-slider-nav w-slider-nav-invert w-round"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="section_cta51 color-scheme-2">
      <div class="padding-global">
        <div class="container-large">
            <div class="padding-section-large">
              <div class="cta51_component">
                <div data-w-id="46b430ab-7526-64f4-1829-a407bcf8bb7a" class="cta51_card">
                  <div class="text-align-center">
                  <div class="max-width-large">
                  <div class="margin-bottom margin-small">
                        <h2 class="heading-style-h2">Our Commitment <span class="text-color-primery">to Sports Excellence</span></h2>
                      </div>
                      <p class="text-size-medium">Join us in promoting sports across Sri Lanka with quality gear and unwavering support.</p>
                  </div>
                  </div>
                    <div class="margin-top margin-medium">
                      <div class="button-group is-center">
                      <a href="product.html" aria-current="page" class="button is-full-width-mobile w-button w--current">View Products</a>
                      <a href="contact.html" class="button is-secondary is-alternate is-full-width-mobile w-button">Contact Us</a>
                    </div>
                  </div>
                    </div>
                    </div>
                  </div>
                    </div>
                    </div>
      </section>
    </main>
    <?php include 'includes/footer-global.php'; ?>
  <script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=68a97272fd9451940c9bc44f" type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="<?php echo asset('js/webflow.js'); ?>" type="text/javascript"></script>
</body>
</html>