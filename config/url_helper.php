<?php
/**
 * URL Helper Functions
 * Provides functions to generate correct URLs for the site
 */

// Load environment functions
require_once __DIR__ . '/env.php';

/**
 * Get the base URL for the site
 * Uses SITE_URL from environment or auto-detects based on current environment
 */
function getBaseUrl() {
    // If SITE_URL is defined in env, prefer it (works for both web and CLI)
    $site_url = env('SITE_URL');
    if ($site_url) {
        // Force HTTPS for production domain dimath.lk, otherwise respect current protocol
        if ($site_url === 'dimath.lk') {
            return 'https://' . $site_url;
        }
        $is_https = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
        $protocol = $is_https ? 'https' : 'http';
        return $protocol . '://' . $site_url;
    }

    // Check if we're running from command line with a default
    if (php_sapi_name() === 'cli') {
        $fallback = defined('DEFAULT_SITE_URL') ? DEFAULT_SITE_URL : env('SITE_URL', 'dimath.lk');
        // Force HTTPS for production domain
        if ($fallback === 'dimath.lk') {
            return 'https://' . $fallback;
        }
        return 'http://' . $fallback;
    }
    
    // Fallback: Auto-detect based on current environment
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $script_name = dirname($_SERVER['SCRIPT_NAME'] ?? '');
    
    // Remove trailing slash and normalize
    $script_name = rtrim($script_name, '/');
    
    // Ensure base URL points to site root (strip /admin suffix if present)
    $script_name = preg_replace('#/admin$#i', '', $script_name);
    
    // Build base URL
    $base_url = $protocol . '://' . $host . $script_name;
    
    return $base_url;
}

/**
 * Generate a URL relative to the base URL (without .php extension)
 */
function url($path = '') {
    $base_url = getBaseUrl();
    $path = ltrim($path, '/');
    
    // Remove .php extension if present
    $path = preg_replace('/\.php$/', '', $path);
    
    if (empty($path)) {
        return $base_url . '/';
    }
    
    return $base_url . '/' . $path;
}

/**
 * Generate an asset URL (for images, CSS, JS)
 */
function asset($path) {
    return url($path);
}

/**
 * Generate a product URL (without .php extension)
 */
function productUrl($slug) {
    return url('product/' . $slug);
}

/**
 * Generate a page URL (without .php extension)
 */
function pageUrl($page) {
    return url($page);
}

/**
 * Generate admin URL (keeps .php extension for admin)
 */
function adminUrl($path = '') {
    $base_url = getBaseUrl();
    $path = ltrim($path, '/');
    
    if (empty($path)) {
        return $base_url . '/admin/';
    }
    
    return $base_url . '/admin/' . $path;
}
?>
