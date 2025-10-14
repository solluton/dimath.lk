<?php
// Product directory handler for clean URLs
// This handles /product/{slug} format in PHP built-in server

$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);

// Extract slug from the path
if (preg_match('#^/product/([^/]+)/?$#', $path, $matches)) {
    $slug = $matches[1];
    $_GET['slug'] = $slug;
    
    // Include the main product.php file
    include '../product.php';
    exit;
}

// If no slug provided, redirect to products page
header('Location: /our-products.php');
exit;
?>
