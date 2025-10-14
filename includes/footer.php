<?php
// Load company details for social media links
$company_json = file_get_contents(__DIR__ . '/../config/company_details.json');
$company_data = json_decode($company_json, true);
$social_media = $company_data['social_media'] ?? [];
?>

<!-- Global Footer -->
<section class="section footer">
  <div class="container">
    <div class="footer-content">
      <div data-w-id="e66f247d-44b3-1cc7-b84b-ae0ea672d4b3" class="footer-details-menu-wrapper">
        <div class="footer-details">
          <a href="/" class="footer-logo-link w-inline-block"><img src="images/logo-neomed.svg" loading="lazy" alt="" class="footer-logo-image"></a>
          <div class="footer-details-description-wrap">
            <p class="footer-details-description-text">At NEO MED PHARMACEUTICALS, we are dedicated to providing high-quality pharmaceutical distribution solutions tailored to meet the needs of healthcare providers. Your trust is our priority.</p>
          </div>
          <div class="footer-social-media-wrapper">
            <?php if (!empty($social_media['linkedin'])): ?>
            <a href="<?php echo htmlspecialchars($social_media['linkedin']); ?>" target="_blank" class="footer-social-media-link w-inline-block">
              <div class="footer-social-media-icon"></div>
            </a>
            <?php endif; ?>
            <?php if (!empty($social_media['facebook'])): ?>
            <a href="<?php echo htmlspecialchars($social_media['facebook']); ?>" target="_blank" class="footer-social-media-link w-inline-block">
              <div class="footer-social-media-icon"></div>
            </a>
            <?php endif; ?>
            <?php if (!empty($social_media['twitter'])): ?>
            <a href="<?php echo htmlspecialchars($social_media['twitter']); ?>" target="_blank" class="footer-social-media-link w-inline-block">
              <div class="footer-social-media-icon"></div>
            </a>
            <?php endif; ?>
            <?php if (!empty($social_media['instagram'])): ?>
            <a href="<?php echo htmlspecialchars($social_media['instagram']); ?>" target="_blank" class="footer-social-media-link w-inline-block">
              <div class="footer-social-media-icon"></div>
            </a>
            <?php endif; ?>
          </div>
        </div>
        <div class="footer-menu-wrapper">
          <div class="footer-menu-single">
            <div class="footer-menu-title-wrapper">
              <h5 class="footer-menu-title">Services</h5>
            </div>
            <div class="footer-menu-list-wrapper">
              <ul role="list" class="footer-menu-list">
                <li class="footer-menu-list-item">
                  <a href="service/pharmaceutical-product-distribution" class="footer-menu-text-link">Pharmaceutical Product Distribution</a>
                </li>
                <li class="footer-menu-list-item">
                  <a href="service/warehousing-inventory-management" class="footer-menu-text-link">Warehousing &amp; Inventory Management</a>
                </li>
                <li class="footer-menu-list-item">
                  <a href="service/cold-chain-logistics" class="footer-menu-text-link">Cold Chain Logistics</a>
                </li>
                <li class="footer-menu-list-item">
                  <a href="service/order-fulfillment-delivery" class="footer-menu-text-link">Order Fulfillment &amp; Delivery</a>
                </li>
                <li class="footer-menu-list-item">
                  <a href="service/customer-support-after-sales-services" class="footer-menu-text-link">Customer Support &amp; After-Sales Services</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="footer-menu-single">
            <div class="footer-menu-title-wrapper">
              <h5 class="footer-menu-title">Sitemap</h5>
            </div>
            <div class="footer-menu-list-wrapper">
              <ul role="list" class="footer-menu-list">
                <li class="footer-menu-list-item">
                  <a href="/" class="footer-menu-text-link">Home</a>
                </li>
                <li class="footer-menu-list-item">
                  <a href="about-us" class="footer-menu-text-link">About us</a>
                </li>
                <li class="footer-menu-list-item">
                  <a href="services" class="footer-menu-text-link">Services</a>
                </li>
                <li class="footer-menu-list-item">
                  <a href="partnership" class="footer-menu-text-link">Partners</a>
                </li>
                <li class="footer-menu-list-item">
                  <a href="quality-assurance" class="footer-menu-text-link">Quality Assurance</a>
                </li>
                <li class="footer-menu-list-item">
                  <a href="contact-us" class="footer-menu-text-link">Contact Us</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="footer-menu-single">
            <div class="footer-menu-title-wrapper">
              <h5 class="footer-menu-title">Other</h5>
            </div>
            <div class="footer-menu-list-wrapper">
              <ul role="list" class="footer-menu-list">
                <li class="footer-menu-list-item">
                  <a href="terms-conditions" class="footer-menu-text-link">Terms &amp; Conditions</a>
                </li>
                <li class="footer-menu-list-item">
                  <a href="privacy-policies" class="footer-menu-text-link">Privacy Policies</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-copyright-wrapper">
        <div class="footer-copyright-text">© <?php echo date('Y'); ?> <?php echo htmlspecialchars($company_data['company_name'] ?? 'NEO MED PHARMACEUTICALS'); ?>. All rights reserved.</div>
      </div>
    </div>
  </div>
</section>