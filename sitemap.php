<?php
require_once 'config/database.php';

try {
    $pdo = getDBConnection();
    
    // Fetch all active products
    $stmt = $pdo->prepare("SELECT title, slug, updated_at FROM products WHERE status = 'active' ORDER BY display_order ASC, created_at ASC");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $products = [];
    error_log("Error fetching products for sitemap: " . $e->getMessage());
}

// Set page title and meta
$page_title = "Sitemap - DMT Cricket Sri Lanka";
$page_description = "Find all pages and products on the DMT Cricket website. Browse our complete sitemap to discover softball cricket gear, bats, balls, and gloves.";
?>
<!DOCTYPE html>
<html data-wf-page="68ac3917626e46cbd1a97b47" data-wf-site="68ac3916626e46cbd1a97ae5">
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($page_title) ?></title>
  <meta content="<?= htmlspecialchars($page_description) ?>" name="description">
  <meta content="<?= htmlspecialchars($page_title) ?>" property="og:title">
  <meta content="<?= htmlspecialchars($page_description) ?>" property="og:description">
  <meta content="<?= htmlspecialchars($page_title) ?>" property="twitter:title">
  <meta content="<?= htmlspecialchars($page_description) ?>" property="twitter:description">
  <meta property="og:type" content="website">
  <meta content="summary_large_image" name="twitter:card">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <meta content="Webflow" name="generator">
  <?php include 'includes/scripts-global.php'; ?>
</head>
<body>
  <div class="page-wrapper">
    <div class="global-styles">
      <div class="style-overrides w-embed">
        <style>
/* Ensure all elements inherit the color from its parent */
a,
.w-nav-link:not(.navbar1_link) {
  color: inherit;
  text-decoration: inherit;
}

/* Override any specific color assignments */
* {
  color: inherit !important;
}

/* Ensure text color is inherited from parent */
.w-nav-link:not(.navbar1_link) {
  font-size: inherit;
}
        </style>
      </div>
    </div>
    
    <?php include 'includes/navbar-global.php'; ?>
    
    <div class="main-wrapper">
      <div class="section">
        <div class="container">
          <div class="padding-section-large">
            <div class="margin-bottom margin-large">
              <h1 class="heading-style-h1">Website Sitemap</h1>
              <p class="text-size-medium">Find all pages and products on the DMT Cricket website. Browse our complete sitemap to discover softball cricket gear, bats, balls, and gloves.</p>
            </div>
            
            <!-- Main Pages -->
            <div class="margin-bottom margin-large">
              <h2 class="heading-style-h2">Main Pages</h2>
              <div class="w-layout-grid grid-2-columns">
                <div class="sitemap-section">
                  <h3 class="heading-style-h6">Core Pages</h3>
                  <ul class="sitemap-list">
                    <li><a href="/" class="sitemap-link">Home</a></li>
                    <li><a href="/about" class="sitemap-link">About Us</a></li>
                    <li><a href="/our-products" class="sitemap-link">Our Products</a></li>
                    <li><a href="/contact" class="sitemap-link">Contact Us</a></li>
                  </ul>
                </div>
                <div class="sitemap-section">
                  <h3 class="heading-style-h6">Legal Pages</h3>
                  <ul class="sitemap-list">
                    <li><a href="/privacy-policy" class="sitemap-link">Privacy Policy</a></li>
                    <li><a href="/terms-of-service" class="sitemap-link">Terms of Service</a></li>
                  </ul>
                </div>
              </div>
            </div>
            
            <!-- Product Pages -->
            <?php if (!empty($products)): ?>
            <div class="margin-bottom margin-large">
              <h2 class="heading-style-h2">Product Pages</h2>
              <div class="w-layout-grid grid-3-columns">
                <?php foreach ($products as $product): ?>
                <div class="sitemap-section">
                  <a href="/product/<?= htmlspecialchars($product['slug']) ?>" class="sitemap-link">
                    <h3 class="heading-style-h6"><?= htmlspecialchars($product['title']) ?></h3>
                    <p class="text-size-small">Last updated: <?= date('M j, Y', strtotime($product['updated_at'])) ?></p>
                  </a>
                </div>
                <?php endforeach; ?>
              </div>
            </div>
            <?php endif; ?>
            
            <!-- Additional Information -->
            <div class="margin-bottom margin-large">
              <h2 class="heading-style-h2">Additional Information</h2>
              <div class="sitemap-info">
                <p class="text-size-medium">This sitemap includes all publicly accessible pages on the DMT Cricket website. For the most up-to-date information about our products and services, please visit our main pages.</p>
                <div class="margin-top margin-medium">
                  <a href="/" class="button w-button">Back to Home</a>
                  <a href="/our-products" class="button is-secondary w-button">View All Products</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <?php include 'includes/footer-global.php'; ?>
  </div>
  
  <style>
    .sitemap-list {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    
    .sitemap-list li {
      margin-bottom: 0.5rem;
    }
    
    .sitemap-link {
      color: #0c2461;
      text-decoration: none;
      transition: color 0.3s ease;
    }
    
    .sitemap-link:hover {
      color: #1e3a8a;
      text-decoration: underline;
    }
    
    .sitemap-section {
      background: #f8fafc;
      padding: 1.5rem;
      border-radius: 8px;
      border: 1px solid #e2e8f0;
    }
    
    .sitemap-section h3 {
      margin-bottom: 1rem;
      color: #0c2461;
    }
    
    .sitemap-info {
      background: #f0f9ff;
      padding: 2rem;
      border-radius: 12px;
      border: 1px solid #bae6fd;
    }
    
    .grid-2-columns {
      grid-template-columns: 1fr 1fr;
      gap: 2rem;
    }
    
    .grid-3-columns {
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 1.5rem;
    }
    
    @media (max-width: 768px) {
      .grid-2-columns {
        grid-template-columns: 1fr;
        gap: 1rem;
      }
      
      .grid-3-columns {
        grid-template-columns: 1fr;
        gap: 1rem;
      }
    }
  </style>
</body>
</html>
