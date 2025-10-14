<?php
/**
 * Product management functions - Updated for optimized table structure
 */

// Ensure database connection helpers are available
require_once __DIR__ . '/database.php';

function getProductBySlug($slug) {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("SELECT * FROM products WHERE slug = ? AND status = 'active' AND deleted_at IS NULL");
        $stmt->execute([$slug]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return null;
    }
}

function getProductById($id) {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ? AND status = 'active' AND deleted_at IS NULL");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return null;
    }
}

function getDefaultProduct() {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->query("SELECT * FROM products WHERE status = 'active' AND deleted_at IS NULL ORDER BY display_order ASC, created_at DESC LIMIT 1");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return null;
    }
}

function getProductFeatures($productId) {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("SELECT * FROM product_features WHERE product_id = ? ORDER BY display_order ASC");
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

function getAllActiveProducts() {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->query("SELECT * FROM products WHERE status = 'active' AND deleted_at IS NULL ORDER BY display_order ASC, created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

function getFeaturedProducts(int $limit = 10) {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("SELECT * FROM products WHERE status = 'active' AND deleted_at IS NULL AND enable_featured_home = 1 ORDER BY display_order ASC, created_at DESC LIMIT :lim");
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

function getProductGalleryImages($product) {
    $images = [];
    
    // Check each image field
    for ($i = 1; $i <= 6; $i++) {
        $imageField = "image_$i";
        if (!empty($product[$imageField])) {
            $images[] = $product[$imageField];
        }
    }
    
    return $images;
}

function getProductMainImage($product) {
    return !empty($product['main_image']) ? $product['main_image'] : null;
}

function getProductFeaturedImage($product) {
    return !empty($product['featured_home_image']) ? $product['featured_home_image'] : $product['main_image'];
}

function parseProductFeatures($product) {
    // Since features_json field was removed, return empty array
    // Features can be managed through rich_content or separate features table if needed
    return [
        ['title' => '', 'description' => ''],
        ['title' => '', 'description' => ''],
        ['title' => '', 'description' => ''],
        ['title' => '', 'description' => ''],
        ['title' => '', 'description' => ''],
        ['title' => '', 'description' => '']
    ];
}

function generateProductMeta($product) {
    $meta = [
        'title' => ($product['meta_title'] ?? '') ?: $product['title'] . ' | Dimath Sports',
        'description' => ($product['meta_description'] ?? '') ?: substr(strip_tags($product['description'] ?? ''), 0, 160),
        'keywords' => 'sports gear, dimath sports, cricket, fitness, equipment'
    ];
    
    return $meta;
}

// Parse gallery images from old format (if any)
function parseGalleryImages($galleryJson) {
    if (empty($galleryJson)) {
        return [];
    }
    
    $images = json_decode($galleryJson, true);
    return is_array($images) ? $images : [];
}
?>