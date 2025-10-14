<?php
/**
 * Secure Error Handling System
 * Provides secure error handling without information disclosure
 */

/**
 * Handle database errors securely
 * @param Exception $e The exception to handle
 * @param string $context Additional context for logging
 * @return string User-friendly error message
 */
function handleDatabaseError($e, $context = '') {
    // Log detailed error for debugging
    $logMessage = "Database error" . ($context ? " in $context" : '') . ": " . $e->getMessage();
    error_log($logMessage);
    
    // Return generic user message
    return "A database error occurred. Please try again later.";
}

/**
 * Handle general errors securely
 * @param Exception $e The exception to handle
 * @param string $context Additional context for logging
 * @return string User-friendly error message
 */
function handleGeneralError($e, $context = '') {
    // Log detailed error for debugging
    $logMessage = "General error" . ($context ? " in $context" : '') . ": " . $e->getMessage();
    error_log($logMessage);
    
    // Return generic user message
    return "An error occurred. Please try again later.";
}

/**
 * Secure database connection with error handling
 * @return PDO|false Returns PDO object or false on failure
 */
function getSecureDBConnection() {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch(PDOException $e) {
        handleDatabaseError($e, 'database connection');
        return false;
    }
}

/**
 * Safe die function that logs errors
 * @param string $message User-friendly message
 * @param Exception|null $e Optional exception to log
 */
function secureDie($message, $e = null) {
    if ($e) {
        error_log("Fatal error: " . $e->getMessage());
    }
    die($message);
}

/**
 * Validate and sanitize input
 * @param mixed $input The input to validate
 * @param string $type The expected type (string, int, email, etc.)
 * @return mixed Sanitized input or false if invalid
 */
function validateInput($input, $type = 'string') {
    switch ($type) {
        case 'string':
            return is_string($input) ? trim($input) : false;
        case 'int':
            return is_numeric($input) ? (int)$input : false;
        case 'email':
            return filter_var($input, FILTER_VALIDATE_EMAIL);
        case 'url':
            return filter_var($input, FILTER_VALIDATE_URL);
        default:
            return $input;
    }
}

/**
 * Check if user is authenticated
 * @return bool True if authenticated, false otherwise
 */
function isAuthenticated() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Require authentication
 * Redirects to login if not authenticated
 */
function requireAuthentication() {
    if (!isAuthenticated()) {
        header('Location: login.php');
        exit();
    }
}

/**
 * Check if user has admin role
 * @return bool True if admin, false otherwise
 */
function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

/**
 * Require admin role
 * Redirects to dashboard if not admin
 */
function requireAdmin() {
    requireAuthentication();
    if (!isAdmin()) {
        header('Location: dashboard.php');
        exit();
    }
}
?>
