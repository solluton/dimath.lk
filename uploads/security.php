<?php
/**
 * Upload Directory Security Protection
 * This file provides additional PHP-level security for upload directories
 */

// Prevent direct access to this file
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    http_response_code(403);
    die('Access denied');
}

// Prevent execution of any PHP files in upload directories
if (isset($_SERVER['REQUEST_URI']) && preg_match('/\.php$/i', $_SERVER['REQUEST_URI'])) {
    http_response_code(403);
    die('PHP execution not allowed in upload directories');
}

// Log any suspicious access attempts
if (isset($_SERVER['REQUEST_URI'])) {
    $suspiciousPatterns = [
        '/\.php$/i',
        '/\.phtml$/i',
        '/\.php3$/i',
        '/\.php4$/i',
        '/\.php5$/i',
        '/\.phps$/i',
        '/\.exe$/i',
        '/\.bat$/i',
        '/\.cmd$/i',
        '/\.com$/i',
        '/\.scr$/i',
        '/\.js$/i',
        '/\.vbs$/i',
        '/\.asp$/i',
        '/\.aspx$/i',
        '/\.ini$/i',
        '/\.conf$/i',
        '/\.config$/i',
        '/\.bak$/i',
        '/\.backup$/i',
        '/\.log$/i',
        '/\.tmp$/i',
        '/\.temp$/i'
    ];
    
    foreach ($suspiciousPatterns as $pattern) {
        if (preg_match($pattern, $_SERVER['REQUEST_URI'])) {
            error_log("SECURITY ALERT: Suspicious file access attempt: " . $_SERVER['REQUEST_URI'] . " from IP: " . $_SERVER['REMOTE_ADDR']);
            http_response_code(403);
            die('Access denied - suspicious file type');
        }
    }
}

// Set security headers
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

// Prevent directory traversal attacks
if (strpos($_SERVER['REQUEST_URI'], '..') !== false) {
    http_response_code(403);
    die('Directory traversal attempt blocked');
}
?>
