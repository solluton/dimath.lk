<?php
// Redirect old product-edit.php URLs to the unified product-create.php
// This ensures backward compatibility for any existing bookmarks or links

if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Redirect to the unified product-create.php with the same ID
    header('Location: product-create.php?id=' . urlencode($_GET['id']), true, 301);
    exit();
        } else {
    // If no ID provided, redirect to products list
    header('Location: products.php', true, 301);
        exit();
}
?>