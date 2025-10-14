<?php
/**
 * Redirect Management Functions
 * Handles product redirects
 */

require_once __DIR__ . '/database.php';

/**
 * Create or update a redirect entry
 * @param string $old_slug The old slug
 * @param string $new_slug The new slug
 * @param int $product_id The ID of the product
 * @return bool Success status
 */
function createOrUpdateRedirect($old_slug, $new_slug, $product_id) {
    try {
        $pdo = getDBConnection();
        
        // Check if redirect already exists
        $stmt = $pdo->prepare("
            SELECT id FROM slug_redirects 
            WHERE old_slug = ? AND redirect_type = 'product'
        ");
        $stmt->execute([$old_slug]);
        $existing = $stmt->fetch();
        
        if ($existing) {
            // Update existing redirect
            $stmt = $pdo->prepare("
                UPDATE slug_redirects 
                SET new_slug = ?, product_id = ?, created_at = NOW()
                WHERE id = ?
            ");
            return $stmt->execute([$new_slug, $product_id, $existing['id']]);
        } else {
            // Create new redirect
            $stmt = $pdo->prepare("
                INSERT INTO slug_redirects (old_slug, new_slug, redirect_type, product_id, created_at)
                VALUES (?, ?, 'product', ?, NOW())
            ");
            return $stmt->execute([$old_slug, $new_slug, $product_id]);
        }
    } catch (Exception $e) {
        error_log("Error creating redirect: " . $e->getMessage());
        return false;
    }
}

/**
 * Delete redirects for a specific product
 * @param int $product_id The ID of the product
 * @return bool Success status
 */
function deleteRedirectsForProduct($product_id) {
    try {
        $pdo = getDBConnection();
        
        $stmt = $pdo->prepare("
            DELETE FROM slug_redirects 
            WHERE product_id = ? AND redirect_type = 'product'
        ");
        return $stmt->execute([$product_id]);
    } catch (Exception $e) {
        error_log("Error deleting redirects: " . $e->getMessage());
        return false;
    }
}

/**
 * Handle product slug change
 * @param int $product_id The product ID
 * @param string $old_slug The old slug
 * @param string $new_slug The new slug
 * @return bool Success status
 */
function handleProductSlugChange($product_id, $old_slug, $new_slug) {
    if ($old_slug && $new_slug && $old_slug !== $new_slug) {
        return createOrUpdateRedirect($old_slug, $new_slug, $product_id);
    }
    return true;
}

/**
 * Handle product deletion
 * @param int $product_id The product ID
 * @return bool Success status
 */
function handleProductDeletion($product_id) {
    return deleteRedirectsForProduct($product_id);
}
?>