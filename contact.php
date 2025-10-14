<?php
require_once 'config/database.php';
require_once 'config/csrf.php';
require_once 'config/url_helper.php';
$csrfToken = generateCSRFToken();
?>
<!DOCTYPE html><!--  This site was created in Webflow. https://webflow.com  --><!--  Last Published: Fri Oct 10 2025 03:32:47 GMT+0000 (Coordinated Universal Time)  -->
<html data-wf-page="68a97483e5a3e61d547336a0" data-wf-site="68a97272fd9451940c9bc44f">
<head>
  <meta charset="utf-8">
  <title>Contact Dimath Sports | Sports Equipment Suppliers in Sri Lanka</title>
  <meta content="Get in touch with Dimath Sports for sports goods and distribution partnerships. Contact us via phone, WhatsApp, or email. Visit our location with Google Maps directions." name="description">
  <meta content="Contact Dimath Sports | Sports Equipment Suppliers in Sri Lanka" property="og:title">
  <meta content="Get in touch with Dimath Sports for sports goods and distribution partnerships. Contact us via phone, WhatsApp, or email. Visit our location with Google Maps directions." property="og:description">
  <meta content="Contact Dimath Sports | Sports Equipment Suppliers in Sri Lanka" property="twitter:title">
  <meta content="Get in touch with Dimath Sports for sports goods and distribution partnerships. Contact us via phone, WhatsApp, or email. Visit our location with Google Maps directions." property="twitter:description">
  <meta property="og:type" content="website">
  <meta content="summary_large_image" name="twitter:card">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <meta content="Webflow" name="generator">
  <link href="css/normalize.css" rel="stylesheet" type="text/css">
  <link href="css/webflow.css" rel="stylesheet" type="text/css">
  <link href="css/dimathsports-lk.webflow.css" rel="stylesheet" type="text/css">
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
      <header class="section_header50 text-color-white">
        <div class="padding-global">
          <div class="container-large">
            <div class="padding-section-large">
              <div class="header50_component">
                <div class="max-width-large">
                  <div data-w-id="dc1b8fa2-bdc4-a68e-e8e1-c8523fcfa54d" style="opacity:0" class="margin-bottom margin-xsmall">
                    <div class="text-style-tagline text-color-white">Connect</div>
                  </div>
                  <div class="margin-bottom margin-small">
                    <h1 data-w-id="dc1b8fa2-bdc4-a68e-e8e1-c8523fcfa551" style="opacity:0" class="heading-style-h1">Get in Touch</h1>
                  </div>
                  <p data-w-id="dc1b8fa2-bdc4-a68e-e8e1-c8523fcfa553" style="opacity:0" class="text-size-medium">We’re here to answer your questions and help you with your sports needs.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="header50_background-image-wrapper">
          <div class="image-overlay-layer"></div><img sizes="(max-width: 6240px) 100vw, 6240px" srcset="images/Sports-3-p-500.webp 500w, images/Sports-3-p-800.webp 800w, images/Sports-3-p-1080.webp 1080w, images/Sports-3-p-1600.webp 1600w, images/Sports-3-p-2000.webp 2000w, images/Sports-3-p-2600.webp 2600w, images/Sports-3-p-3200.webp 3200w, images/Sports-3.webp 6240w" alt="" src="images/Sports-3.webp" loading="eager" class="header50_background-image">
        </div>
      </header>
      <section class="section_contact2 color-scheme-1">
        <div class="padding-global">
          <div class="container-large">
            <div class="padding-section-large">
              <div class="contact2_component">
                <div class="margin-bottom margin-xxlarge">
                  <div class="text-align-center">
                    <div data-w-id="dc1b8fa2-bdc4-a68e-e8e1-c8523fcfa565" style="opacity:0" class="max-width-large align-center">
                      <div class="margin-bottom margin-xsmall">
                        <div class="text-style-tagline">Connect with Us</div>
                      </div>
                      <div class="margin-bottom margin-small">
                        <h2 class="heading-style-h2">Contact Us Today! <span class="text-color-primery">We’d Love to Hear from You!</span></h2>
                      </div>
                      <p class="text-size-medium">We’re here to assist you with any inquiries.</p>
                    </div>
                  </div>
                </div>
                <div class="max-width-large align-center">
                  <div class="contact2_form-block">
                    <form method="post" action="contact-handler.php" id="contact-form" class="contact2_form" data-wf-ignore="true" novalidate onsubmit="return handleContactSubmit(event)">
                      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                      <input type="hidden" name="ajax" value="1">
                      <div class="form_field-2col">
                        <div class="form_field-wrapper"><label for="Contact-2-First-Name-2" class="form_field-label">First Name</label><input class="form_input w-input" maxlength="256" name="first_name" placeholder="First name" type="text" id="Contact-2-First-Name-2" required><div class="form-error" id="error-first_name" style="color:#d32f2f;font-size:12px;margin-top:6px;display:none"></div></div>
                        <div class="form_field-wrapper"><label for="Contact-2-Last-Name" class="form_field-label">Last Name</label><input class="form_input w-input" maxlength="256" name="last_name" placeholder="Last name" type="text" id="Contact-2-Last-Name" required><div class="form-error" id="error-last_name" style="color:#d32f2f;font-size:12px;margin-top:6px;display:none"></div></div>
                      </div>
                      <div class="form_field-2col is-mobile-1col">
                        <div class="form_field-wrapper"><label for="Contact-2-Email-2" class="form_field-label">Email</label><input class="form_input w-input" maxlength="256" name="email" placeholder="you@example.com" type="email" id="Contact-2-Email-2" required><div class="form-error" id="error-email" style="color:#d32f2f;font-size:12px;margin-top:6px;display:none"></div></div>
                        <div class="form_field-wrapper"><label for="Contact-2-Phone" class="form_field-label">Phone Number</label><input class="form_input w-input" maxlength="256" name="phone" placeholder="Phone number (optional)" type="tel" id="Contact-2-Phone"><div class="form-error" id="error-phone" style="color:#d32f2f;font-size:12px;margin-top:6px;display:none"></div></div>
                      </div>
                      <div class="form_field-wrapper"><label for="Contact-2-Select" class="form_field-label">Choose a Topic</label><select id="Contact-2-Select" name="subject" required class="form_input is-select-input w-select">
                          <option value="">Select One...</option>
                          <option value="General Inquiry">General Inquiry</option>
                          <option value="Product Availability">Product Availability</option>
                          <option value="Bulk Order / Wholesale">Bulk Order / Wholesale</option>
                          <option value="Retail Partnership">Retail Partnership</option>
                          <option value="School / Club Partnership">School / Club Partnership</option>
                          <option value="Corporate Orders">Corporate Orders</option>
                          <option value="Warranty / Returns">Warranty / Returns</option>
                          <option value="Distribution Partnership">Distribution Partnership</option>
                          <option value="Media / PR">Media / PR</option>
                          <option value="Other">Other</option>
                        </select><div class="form-error" id="error-subject" style="color:#d32f2f;font-size:12px;margin-top:6px;display:none"></div></div>
                      <div class="padding-vertical padding-xsmall">
                        <div class="form_field-wrapper">
                          <div class="margin-bottom margin-xsmall"><label for="Contact-2-Select-2" class="form_field-label">Which best describes you?</label></div>
                          <div class="w-layout-grid form_radio-2col"><label class="form_radio w-radio">
                              <div class="w-form-formradioinput w-form-formradioinput--inputType-custom form_radio-icon w-radio-input"></div><input type="radio" name="Contact-2-Radio" id="Contact-2-Radio-1" data-name="Contact 2 Radio" style="opacity:0;position:absolute;z-index:-1" value="Contact 2 Radio 1"><span for="Contact-2-Radio-1" class="form_radio-label w-form-label">Athlete</span>
                            </label><label class="form_radio w-radio">
                              <div class="w-form-formradioinput w-form-formradioinput--inputType-custom form_radio-icon w-radio-input"></div><input type="radio" name="Contact-2-Radio" id="radio" data-name="Contact 2 Radio" style="opacity:0;position:absolute;z-index:-1" value="Contact 2 Radio 2"><span for="radio" class="form_radio-label w-form-label">Retailer</span>
                            </label><label class="form_radio w-radio">
                              <div class="w-form-formradioinput w-form-formradioinput--inputType-custom form_radio-icon w-radio-input"></div><input type="radio" name="Contact-2-Radio" id="Contact 2 Radio -7" data-name="Contact 2 Radio" style="opacity:0;position:absolute;z-index:-1" value="Contact 2 Radio 3"><span for="Contact 2 Radio -7" class="form_radio-label w-form-label">Coach</span>
                            </label><label class="form_radio w-radio">
                              <div class="w-form-formradioinput w-form-formradioinput--inputType-custom form_radio-icon w-radio-input"></div><input type="radio" name="Contact-2-Radio" id="radio" data-name="Contact 2 Radio" style="opacity:0;position:absolute;z-index:-1" value="Contact 2 Radio 4"><span for="radio" class="form_radio-label w-form-label">Parent</span>
                            </label><label class="form_radio w-radio">
                              <div class="w-form-formradioinput w-form-formradioinput--inputType-custom form_radio-icon w-radio-input"></div><input type="radio" name="Contact-2-Radio" id="Contact 2 Radio -9" data-name="Contact 2 Radio" style="opacity:0;position:absolute;z-index:-1" value="Contact 2 Radio 5"><span for="Contact 2 Radio -9" class="form_radio-label w-form-label">Other</span>
                            </label><label class="form_radio w-radio">
                              <div class="w-form-formradioinput w-form-formradioinput--inputType-custom form_radio-icon w-radio-input"></div><input type="radio" name="Contact-2-Radio" id="Contact 2 Radio -10" data-name="Contact 2 Radio" style="opacity:0;position:absolute;z-index:-1" value="Contact 2 Radio 6"><span for="Contact 2 Radio -10" class="form_radio-label w-form-label">Other</span>
                            </label></div>
                        </div>
                      </div>
                      <div class="form_field-wrapper"><label for="Contact-2-Message" class="form_field-label">Message</label><textarea id="Contact-2-Message" name="message" maxlength="5000" placeholder="Type your message..." required class="form_input is-text-area w-input"></textarea><div class="form-error" id="error-message" style="color:#d32f2f;font-size:12px;margin-top:6px;display:none"></div></div>
                      <div class="margin-bottom margin-xsmall"><label id="Contact-2-Checkbox" class="w-checkbox form_checkbox">
                          <div class="w-checkbox-input w-checkbox-input--inputType-custom form_checkbox-icon"></div><input type="checkbox" name="terms" id="Contact2Checkbox" style="opacity:0;position:absolute;z-index:-1"><span for="Contact2Checkbox" class="form_checkbox-label w-form-label">I accept the Terms</span>
                        </label>
                        <div class="form-error" id="error-terms" style="color:#d32f2f;font-size:12px;margin-top:6px;display:none"></div>
                      </div>
                      <div class="form-success" id="success-general"></div>
                      <div class="form-error" id="error-general" style="color:#d32f2f;font-size:13px;margin:4px 0 12px;display:none"></div>
                      <input type="submit" class="button w-button" value="Send Message">
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="section_contact22 color-scheme-3">
        <div class="padding-global">
          <div class="container-large">
            <div class="padding-section-large">
              <div class="contact22_component">
                <div class="w-layout-grid contact22_grid-list">
                  <div class="contact22_item">
                    <div class="margin-bottom margin-small">
                      <div class="contact22_icon-wrapper">
                        <div class="icon-embed-medium w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewbox="0 0 24 24" fill="none" preserveaspectratio="xMidYMid meet" aria-hidden="true" role="img">
                            <path d="M3.05359 5.74219V18.9463H20.9462V6.13867L20.1708 6.64844L12.2147 11.8867C12.1544 11.9184 12.102 11.944 12.0565 11.9619C12.0534 11.9629 12.0366 11.9678 11.9999 11.9678C11.9626 11.9678 11.946 11.9628 11.9432 11.9619C11.8975 11.9439 11.8448 11.9186 11.7841 11.8867L4.05359 6.7959V6.39648L11.7264 11.4219L11.9999 11.6016L12.2733 11.4229L20.62 5.97266L21.6307 5.31152C21.6464 5.38933 21.6551 5.46973 21.6552 5.55371V18.4463C21.6552 18.7675 21.5429 19.041 21.2938 19.2891C21.0449 19.5371 20.7701 19.6494 20.4462 19.6494H3.55359C3.23187 19.6494 2.95869 19.5371 2.71082 19.2891L2.6239 19.1953C2.43623 18.9725 2.35046 18.7279 2.35046 18.4463V5.55371C2.35048 5.46519 2.35953 5.38047 2.37683 5.29883L3.05359 5.74219ZM3.55359 4.34473H20.4462C20.7696 4.34473 21.0438 4.4579 21.2928 4.70703H21.2938C21.4035 4.81669 21.485 4.93216 21.5438 5.05371H2.46082C2.5195 4.93172 2.60127 4.81595 2.71082 4.70605H2.71179C2.95976 4.45718 3.23251 4.34476 3.55359 4.34473Z" fill="currentColor" stroke="currentColor"></path>
                          </svg></div>
                      </div>
                    </div>
                    <div class="margin-bottom margin-xsmall">
                      <h3 class="heading-style-h4">Email</h3>
                    </div>
                    <p>Reach us at contact@dimathcinnamon.com for inquiries and support.</p>
                    <div class="margin-top margin-small">
                      <a href="mailto:contact@dimathcinnamon.com" class="text-style-link">contact@dimathcinnamon.com</a>
                    </div>
                  </div>
                  <div class="contact22_item">
                    <div class="margin-bottom margin-small">
                      <div class="contact22_icon-wrapper">
                        <div class="icon-embed-medium w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewbox="0 0 24 24" fill="none" preserveaspectratio="xMidYMid meet" aria-hidden="true" role="img">
                            <path d="M4.11902 3.34473H7.61902C7.80275 3.34474 7.93038 3.39945 8.03503 3.49805C8.12854 3.58614 8.20705 3.70059 8.2655 3.85156L8.31726 4.01465L8.9823 7.02832C9.01497 7.26011 9.00744 7.44511 8.97253 7.5918C8.94139 7.72276 8.8796 7.83104 8.78015 7.92578L8.77332 7.93164L6.25574 10.415L5.97644 10.6904L6.17664 11.0264C6.60337 11.7435 7.05685 12.416 7.53699 13.042C8.01981 13.6715 8.55599 14.2696 9.14441 14.8369C9.75779 15.4701 10.399 16.0453 11.0682 16.5605C11.7434 17.0804 12.4488 17.5353 13.1844 17.9248L13.5155 18.0996L13.7762 17.832L16.1815 15.3643L16.1913 15.3535C16.3309 15.2021 16.4775 15.111 16.6337 15.0645C16.7647 15.0256 16.8944 15.012 17.0253 15.0215L17.1571 15.0391L19.9774 15.6631C20.1431 15.7092 20.2749 15.7806 20.3817 15.875L20.4813 15.9775C20.5981 16.1186 20.6552 16.2764 20.6552 16.4707V19.8809C20.6552 20.1178 20.581 20.2895 20.4374 20.4316C20.2909 20.5766 20.1181 20.6494 19.8866 20.6494C18.0114 20.6494 16.0911 20.1991 14.1219 19.2842C12.1538 18.3698 10.3229 17.0691 8.62976 15.376C7.0427 13.7889 5.79967 12.0798 4.89539 10.249L4.71863 9.88086C3.80159 7.90938 3.35046 5.99008 3.35046 4.11914C3.35048 3.94128 3.39174 3.79881 3.47351 3.67773L3.56921 3.56348C3.71327 3.41863 3.88502 3.34473 4.11902 3.34473ZM4.06628 4.5752C4.09721 5.28818 4.20923 6.0365 4.39929 6.81836C4.59086 7.60639 4.89058 8.47618 5.2948 9.4248L5.58386 10.1035L6.1073 9.58301L8.12683 7.5752L8.32019 7.38281L8.26257 7.11621L7.69421 4.44922L7.60925 4.05371H4.04382L4.06628 4.5752ZM19.9462 16.377L19.5477 16.2949L17.0624 15.7803L16.7909 15.7246L16.5985 15.9248L14.6356 17.9824L14.1542 18.4863L14.787 18.7812C15.4818 19.1045 16.2353 19.3664 17.0448 19.5693C17.8555 19.7725 18.6477 19.8945 19.4208 19.9336L19.9462 19.96V16.377Z" fill="currentColor" stroke="currentColor"></path>
                          </svg></div>
                      </div>
                    </div>
                    <div class="margin-bottom margin-xsmall">
                      <h3 class="heading-style-h4">Phone</h3>
                    </div>
                    <p>Visit us at Dimath Sports, Suhada Mawatha, Batapola.</p>
                    <div class="margin-top margin-small">
                      <a href="tel:+94912261889" class="text-style-link">+94 912 261 889</a>
                    </div>
                  </div>
                  <div class="contact22_item">
                    <div class="margin-bottom margin-small">
                      <div class="contact22_icon-wrapper">
                        <div class="icon-embed-medium w-embed"><svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewbox="0 0 24 24" fill="none" preserveaspectratio="xMidYMid meet" aria-hidden="true" role="img">
                            <path d="M11.9999 2.34473C14.0242 2.34473 15.8029 3.04933 17.3553 4.47754C18.8789 5.87913 19.6552 7.7626 19.6552 10.1826C19.6551 11.1679 19.4382 12.1526 18.996 13.1406C18.5425 14.154 17.9734 15.1246 17.288 16.0527C16.5966 16.9889 15.8458 17.8627 15.035 18.6738C14.212 19.4974 13.4447 20.2259 12.7333 20.8594L12.7274 20.8643L12.7225 20.8691C12.632 20.9548 12.5274 21.017 12.4052 21.0566C12.2587 21.1041 12.1215 21.126 11.9921 21.126C11.8628 21.126 11.7292 21.104 11.5897 21.0576C11.474 21.0191 11.3759 20.959 11.2899 20.875L11.2811 20.8662L11.2714 20.8584C10.5564 20.2252 9.78741 19.497 8.96472 18.6738C8.15398 17.8627 7.40315 16.9889 6.71179 16.0527C6.02653 15.1248 5.45811 14.1547 5.00671 13.1416C4.56634 12.1534 4.35052 11.1682 4.35046 10.1826C4.35046 7.76231 5.12659 5.8791 6.64832 4.47754C8.19864 3.04953 9.9756 2.34475 11.9999 2.34473ZM11.9999 3.05371C10.0646 3.05371 8.40981 3.72261 7.06824 5.05664C5.71865 6.39887 5.05359 8.12233 5.05359 10.1826C5.0537 11.6021 5.6475 13.1413 6.75183 14.7861C7.85668 16.4317 9.49736 18.2606 11.6591 20.2715L11.996 20.585L12.3358 20.2764C14.5486 18.2689 16.2062 16.4381 17.2889 14.7852C18.3677 13.138 18.9461 11.5989 18.9462 10.1826C18.9462 8.12228 18.2812 6.39888 16.9315 5.05664V5.05566C15.5897 3.72177 13.935 3.05375 11.9999 3.05371ZM11.9979 8.70215C12.3641 8.7022 12.6619 8.82522 12.9188 9.08105C13.175 9.33617 13.2977 9.63248 13.2977 9.99805C13.2977 10.3642 13.1747 10.6605 12.9198 10.915C12.6649 11.1694 12.3682 11.292 12.0018 11.292C11.6348 11.2919 11.3391 11.169 11.0848 10.916C10.8313 10.6634 10.708 10.3691 10.7079 10.0029C10.7079 9.68146 10.8022 9.41279 10.996 9.17871L11.0848 9.08105C11.3378 8.82567 11.6324 8.70215 11.9979 8.70215Z" fill="currentColor" stroke="currentColor"></path>
                          </svg></div>
                      </div>
                    </div>
                    <div class="margin-bottom margin-xsmall">
                      <h3 class="heading-style-h4">Office</h3>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in ero.</p>
                    <div class="margin-top margin-small">
                      <a href="https://maps.app.goo.gl/6giV9NqsSEhGkTSDA" class="text-style-link">Dimath Sports (Private) Limited, Batapola, Sri Lanka</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="section_contact16 color-scheme-2">
        <div class="padding-global">
          <div class="container-large">
            <div class="padding-section-large">
              <div class="contact16_component">
                <div class="margin-bottom margin-xxlarge">
                  <div class="w-layout-grid contact16_content">
                    <div data-w-id="dc1b8fa2-bdc4-a68e-e8e1-c8523fcfa5f4" style="opacity:0" class="contact16_content-left">
                      <div class="max-width-large">
                        <div class="margin-bottom margin-xsmall">
                          <div class="text-style-tagline">Connect</div>
                        </div>
                        <div class="margin-bottom margin-small">
                          <h2 class="heading-style-h2">Find Us <span class="text-color-primery">On MAP</span></h2>
                        </div>
                        <p class="text-size-medium">We’re here to answer your questions and help you with your sports needs.</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div data-w-id="dc1b8fa2-bdc4-a68e-e8e1-c8523fcfa61b" style="opacity:0" class="contact16_map-wrapper">
                  <div class="contact16_map w-embed w-iframe"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7932.539499658192!2d80.11609924126694!3d6.228123025039934!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae17994fd66ca47%3A0x341ceaa4823fdc55!2sDimath%20Sports%20(Private)%20Limited!5e0!3m2!1sen!2slk!4v1758177109129!5m2!1sen!2slk" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
    <?php include 'includes/footer-global.php'; ?>
  </div>
  <script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c8.js?site=68a97272fd9451940c9bc44f" type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <style>
    .form-error{display:none;color:#d32f2f;font-size:12px;margin-top:6px;line-height:1.4}
    .form-error:before{content:"!";display:inline-flex;align-items:center;justify-content:center;width:16px;height:16px;border-radius:50%;background:#d32f2f;color:#fff;font-size:11px;margin-right:6px}
    .w-form-formradioinput,.w-checkbox-input{cursor:pointer}
    .form-success{display:none;position:relative;color:#1b5e20;font-size:14px;margin:12px 0 14px;background:linear-gradient(0deg,#e8f5e9,#e8f5e9);border:1px solid #c8e6c9;border-left:4px solid #2e7d32;padding:14px 16px 14px 48px;border-radius:8px;line-height:1.6;box-shadow:0 1px 0 rgba(46,125,50,.06)}
    .form-success:before{content:"✓";position:absolute;left:16px;top:50%;transform:translateY(-50%);display:inline-flex;align-items:center;justify-content:center;width:22px;height:22px;border-radius:50%;background:#2e7d32;color:#fff;font-weight:700;font-size:13px;box-shadow:0 0 0 2px #e8f5e9}
    .form-success.fade-in{animation:successFade .28s ease-out}
    @keyframes successFade{from{opacity:0;transform:translateY(-2px)}to{opacity:1;transform:translateY(0)}}
  </style>
  <script>
  function clearErrors(){
    var nodes=document.querySelectorAll('.form-error');
    for(var i=0;i<nodes.length;i++){ nodes[i].style.display='none'; nodes[i].textContent=''; }
  }
  function showErrors(errors){
    if(!errors) return;
    Object.keys(errors).forEach(function(key){
      var msg=errors[key];
      if(key==='name'){
        var e1=document.getElementById('error-first_name');
        var e2=document.getElementById('error-last_name');
        if(e1){ e1.textContent=msg; e1.style.display='block'; }
        if(e2){ e2.textContent=msg; e2.style.display='block'; }
      }
      var el=document.getElementById('error-'+key);
      if(el){ el.textContent=msg; el.style.display='block'; }
    });
  }
  function clientValidate(){
    var errs={};
    var first=document.getElementById('Contact-2-First-Name-2').value.trim();
    var last=document.getElementById('Contact-2-Last-Name').value.trim();
    var email=document.getElementById('Contact-2-Email-2').value.trim();
    var phone=document.getElementById('Contact-2-Phone').value.trim();
    var subject=document.getElementById('Contact-2-Select').value.trim();
    var message=document.getElementById('Contact-2-Message').value.trim();
    var terms=document.getElementById('Contact2Checkbox').checked;
    if(first.length<1){ errs.first_name='First name is required.'; }
    if(last.length<1){ errs.last_name='Last name is required.'; }
    if(!email){ errs.email='Email is required.'; }
    else if(!/^\S+@\S+\.\S+$/.test(email)){ errs.email='Enter a valid email.'; }
    if(!subject){ errs.subject='Please choose a topic.'; }
    if(!message || message.length<10){ errs.message='Message must be at least 10 characters.'; }
    if(phone && phone.replace(/\D/g,'').length<7){ errs.phone='Enter a valid phone number.'; }
    if(!terms){ errs.terms='You must accept the Terms.'; }
    return errs;
  }
  function handleContactSubmit(e){
    e.preventDefault();
    var form=document.getElementById('contact-form');
    if(!form){return false;}
    clearErrors();
    var localErrors=clientValidate();
    if(Object.keys(localErrors).length){ showErrors(localErrors); return false; }

    var actionUrl=form.getAttribute('action');
    var csrf=form.querySelector('input[name="csrf_token"]').value;
    var formData=new FormData(form);

    fetch(actionUrl,{
      method:'POST',
      headers:{'X-Requested-With':'XMLHttpRequest','X-CSRF-Token':csrf},
      body:formData,credentials:'same-origin'
    }).then(function(res){
      return res.text().then(function(txt){
        try{ return {ok:res.ok,json:JSON.parse(txt)} }catch(e){ return {ok:res.ok,json:null,raw:txt} }
      });
    }).then(function(payload){
      var data=payload.json;
      if(data && data.success){
        var successEl = document.getElementById('success-general');
        successEl.textContent = data.message || 'Thank you! Your message has been sent.';
        successEl.classList.remove('fade-in');
        successEl.style.display='block';
        void successEl.offsetWidth; // restart animation
        successEl.classList.add('fade-in');
        form.reset();
        return;
      }
      if(data && data.errors){ showErrors(data.errors); return; }
      document.getElementById('error-general').textContent=(data && data.message)?data.message:'Submission failed. Please try again.';
      document.getElementById('error-general').style.display='block';
    }).catch(function(){
      document.getElementById('error-general').textContent='Network error. Please try again.';
      document.getElementById('error-general').style.display='block';
    });
    return false;
  }
  // Sync custom Webflow UI with hidden inputs (since Webflow is ignored)
  document.addEventListener('DOMContentLoaded', function(){
    // Checkbox (Terms)
    var terms = document.getElementById('Contact2Checkbox');
    if(terms){
      var box = terms.previousElementSibling; // custom checkbox div
      var update = function(){ if(!box) return; if(terms.checked){ box.classList.add('w--redirected-checked'); } else { box.classList.remove('w--redirected-checked'); } };
      terms.addEventListener('change', update);
      if(box){ box.addEventListener('click', function(){ terms.checked = !terms.checked; terms.dispatchEvent(new Event('change')); }); }
      update();
    }
    // Radios
    var radios = document.querySelectorAll('input[type="radio"][name="Contact-2-Radio"]');
    var updateRadios = function(){
      for(var i=0;i<radios.length;i++){
        var r = radios[i];
        var dot = r.previousElementSibling; // custom radio div
        if(!dot) continue;
        if(r.checked){ dot.classList.add('w--redirected-checked'); } else { dot.classList.remove('w--redirected-checked'); }
      }
    };
    for(var i=0;i<radios.length;i++){
      (function(r){
        r.addEventListener('change', updateRadios);
        var dot = r.previousElementSibling; if(dot){ dot.addEventListener('click', function(){ r.checked = true; r.dispatchEvent(new Event('change')); }); }
      })(radios[i]);
    }
    updateRadios();
  });
  </script>
  <script src="<?= asset('js/webflow.js') ?>" type="text/javascript"></script>
</body>
</html>