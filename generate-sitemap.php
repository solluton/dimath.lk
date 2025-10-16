<?php
/**
 * Generate Sitemap XML for Dimath Group Website
 * This script generates a sitemap.xml file with all static pages and legal pages
 * ADMIN ONLY - Requires authentication
 */

require_once 'config/database.php';
require_once 'config/url_helper.php';

// ADMIN ONLY ACCESS - Command line execution only
if (php_sapi_name() !== 'cli') {
    // Block all web access
    http_response_code(403);
    header('Content-Type: text/plain');
    die('Access denied. This script can only be run from command line by administrators.');
}

try {
    // Get base URL (set SITE_URL=dimath.lk in .env for live)
    $base_url = getBaseUrl();
    
    // Try to fetch legal pages from database if table exists
    $legal_pages = [];
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("SELECT page_type, updated_at FROM legal_pages ORDER BY updated_at DESC");
        $stmt->execute();
        $legal_pages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        // Legal pages table doesn't exist, continue with static pages only
        echo "Note: Legal pages table not found, using static pages only.\n";
    }
    
    // Generate XML content
    $xml_content = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml_content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    
    // Static pages for Dimath Group website
    $static_pages = [
        ['url' => '', 'priority' => '1.0', 'changefreq' => 'weekly'],
        ['url' => 'about-us', 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['url' => 'our-companies', 'priority' => '0.9', 'changefreq' => 'weekly'],
        ['url' => 'contact-us', 'priority' => '0.7', 'changefreq' => 'monthly'],
        ['url' => 'privacy-policy', 'priority' => '0.5', 'changefreq' => 'yearly'],
        ['url' => 'terms-of-service', 'priority' => '0.5', 'changefreq' => 'yearly'],
        ['url' => 'cookies-policy', 'priority' => '0.5', 'changefreq' => 'yearly'],
        ['url' => 'sitemap', 'priority' => '0.6', 'changefreq' => 'monthly']
    ];
    
    $url_count = 0;
    
    // Add static pages
    foreach ($static_pages as $page) {
        $xml_content .= "  <url>\n";
        $xml_content .= "    <loc>" . htmlspecialchars(rtrim($base_url, '/') . '/' . ltrim($page['url'], '/')) . "</loc>\n";
        $xml_content .= "    <priority>" . $page['priority'] . "</priority>\n";
        $xml_content .= "    <changefreq>" . $page['changefreq'] . "</changefreq>\n";
        $xml_content .= "  </url>\n";
        $url_count++;
    }
    
    // Add legal pages from database
    foreach ($legal_pages as $page) {
        $xml_content .= "  <url>\n";
        $xml_content .= "    <loc>" . htmlspecialchars(rtrim($base_url, '/') . '/' . $page['page_type']) . "</loc>\n";
        $xml_content .= "    <lastmod>" . date('Y-m-d', strtotime($page['updated_at'])) . "</lastmod>\n";
        $xml_content .= "    <priority>0.5</priority>\n";
        $xml_content .= "    <changefreq>yearly</changefreq>\n";
        $xml_content .= "  </url>\n";
        $url_count++;
    }
    
    $xml_content .= '</urlset>' . "\n";
    
    // Write to sitemap.xml file
    $sitemap_file = __DIR__ . '/sitemap.xml';
    $result = file_put_contents($sitemap_file, $xml_content, LOCK_EX);
    
    if ($result !== false) {
        // Set proper permissions
        chmod($sitemap_file, 0644);
        echo "Sitemap generated successfully with $url_count URLs\n";
    } else {
        throw new Exception("Failed to write sitemap.xml file");
    }
    
} catch (Exception $e) {
    // Fallback to static sitemap if database fails
    http_response_code(500);
    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    echo '  <url><loc>' . rtrim(getBaseUrl(), '/') . '/</loc><priority>1.0</priority><changefreq>weekly</changefreq></url>' . "\n";
    echo '</urlset>' . "\n";
}
?>
