<?php
require_once __DIR__ . '/database.php';
/**
 * Custom Scripts Helper Functions
 * Provides functions to manage and inject custom scripts into website pages
 */

/**
 * Get all active custom scripts
 */
function getActiveCustomScripts() {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("SELECT * FROM custom_scripts WHERE is_active = 1 ORDER BY created_at ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log("Error fetching custom scripts: " . $e->getMessage());
        return [];
    }
}

/**
 * Get scripts for head section
 */
function getHeadScripts() {
    $scripts = getActiveCustomScripts();
    $headScripts = [];
    
    foreach ($scripts as $script) {
        if (!empty($script['script_head'])) {
            $headScripts[] = $script['script_head'];
        }
    }
    
    return $headScripts;
}

/**
 * Get scripts for body section
 */
function getBodyScripts() {
    $scripts = getActiveCustomScripts();
    $bodyScripts = [];
    
    foreach ($scripts as $script) {
        if (!empty($script['script_body'])) {
            $bodyScripts[] = $script['script_body'];
        }
    }
    
    return $bodyScripts;
}

/**
 * Output head scripts directly
 */
function outputHeadScripts() {
    $headScripts = getHeadScripts();
    
    foreach ($headScripts as $script) {
        echo "\n" . $script . "\n";
    }
}

/**
 * Output body scripts directly
 */
function outputBodyScripts() {
    $bodyScripts = getBodyScripts();
    
    foreach ($bodyScripts as $script) {
        echo "\n" . $script . "\n";
    }
}

/**
 * Inject custom scripts into HTML content
 */
function injectCustomScripts($html) {
    $headScripts = getHeadScripts();
    $bodyScripts = getBodyScripts();
    
    // Inject head scripts
    if (!empty($headScripts)) {
        $headScriptContent = "\n" . implode("\n", $headScripts) . "\n";
        $html = str_replace('</head>', $headScriptContent . '</head>', $html);
    }
    
    // Inject body scripts
    if (!empty($bodyScripts)) {
        $bodyScriptContent = "\n" . implode("\n", $bodyScripts) . "\n";
        $html = str_replace('</body>', $bodyScriptContent . '</body>', $html);
    }
    
    return $html;
}

/**
 * Get all custom scripts (for admin)
 */
function getAllCustomScripts() {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("SELECT * FROM custom_scripts ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        error_log("Error fetching all custom scripts: " . $e->getMessage());
        return [];
    }
}

/**
 * Toggle script status
 */
function toggleScriptStatus($scriptId, $status) {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("UPDATE custom_scripts SET is_active = ? WHERE id = ?");
        return $stmt->execute([$status ? 1 : 0, $scriptId]);
    } catch (Exception $e) {
        error_log("Error toggling script status: " . $e->getMessage());
        return false;
    }
}

/**
 * Delete custom script
 */
function deleteCustomScript($scriptId) {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("DELETE FROM custom_scripts WHERE id = ?");
        return $stmt->execute([$scriptId]);
    } catch (Exception $e) {
        error_log("Error deleting custom script: " . $e->getMessage());
        return false;
    }
}
?>
