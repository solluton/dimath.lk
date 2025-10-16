<?php
/**
 * Legal Pages Helper Functions
 * Loads legal page content from database
 */

/**
 * Load legal page content from database
 */
function getLegalPageContent($page_type) {
    static $cache = [];
    
    if (!isset($cache[$page_type])) {
        try {
            require_once __DIR__ . '/database.php';
            $pdo = getDBConnection();
            $stmt = $pdo->prepare("SELECT title, content FROM legal_pages WHERE page_type = ?");
            $stmt->execute([$page_type]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                $cache[$page_type] = [
                    'title' => $result['title'],
                    'content' => $result['content']
                ];
            } else {
                // Fallback content if page not found in database
                $cache[$page_type] = [
                    'title' => ucfirst(str_replace('-', ' ', $page_type)),
                    'content' => '<p>Content not available. Please contact the administrator.</p>'
                ];
            }
        } catch (Exception $e) {
            // Fallback content if database error
            $cache[$page_type] = [
                'title' => ucfirst(str_replace('-', ' ', $page_type)),
                'content' => '<p>Content not available. Please contact the administrator.</p>'
            ];
        }
    }
    
    return $cache[$page_type];
}

/**
 * Get legal page title
 */
function getLegalPageTitle($page_type) {
    $content = getLegalPageContent($page_type);
    return $content['title'];
}

/**
 * Get legal page content
 */
function getLegalPageContentHtml($page_type) {
    $content = getLegalPageContent($page_type);
    return $content['content'];
}

/**
 * Check if legal page exists
 */
function legalPageExists($page_type) {
    try {
        require_once __DIR__ . '/database.php';
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM legal_pages WHERE page_type = ?");
        $stmt->execute([$page_type]);
        return $stmt->fetchColumn() > 0;
    } catch (Exception $e) {
        return false;
    }
}
?>
