<?php
// CTA Section Component - "Let's Build the Future Together"
// This component can be included on any page that needs the main CTA section
require_once 'config/url_helper.php';
require_once 'config/company_helper.php';
?>

<section class="section_cta39 color-scheme-3">
  <div class="padding-global">
    <div class="container-large">
      <div class="padding-section-large">
        <div data-w-id="99700eb4-2ede-6f63-b432-797cde7e2f84" class="cta39_component">
          <div class="w-layout-grid cta39_card">
            <div class="cta39_card-content">
              <div class="cta39_card-content-top">
                <div class="margin-bottom margin-small">
                  <h2 class="heading-style-h2">Let's Build the Future Together</h2>
                </div>
                <p class="text-size-medium">Whether you are a potential partner, customer, or investor, we welcome you to explore opportunities with the Dimath Group. Together, we can create sustainable value and long-term success.</p>
              </div>
              <div class="margin-top margin-medium">
                <div class="button-group">
                  <a href="<?php echo url('contact-us'); ?>" class="button w-button">Contact Us Today</a>
                  <a href="<?php echo getCompanyPhoneHref(); ?>" class="button is-secondary w-button">Call Now</a>
                </div>
              </div>
            </div>
            <div class="cta39_image-wrapper"><img sizes="(max-width: 2657px) 100vw, 2657px" srcset="images/cta-dimath_1.webp 500w, images/cta-dimath_1.webp 800w, images/cta-dimath_1.webp 1080w, images/cta-dimath_1.webp 2657w" alt="" src="images/cta-dimath_1.webp" loading="eager" class="cta39_image"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>