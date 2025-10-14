<?php
/**
 * CSRF Protection System
 * Provides CSRF token generation and validation
 */

/**
 * Generate a CSRF token and store it in session
 * @return string The generated CSRF token
 */
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validate a CSRF token
 * @param string $token The token to validate
 * @return bool True if token is valid, false otherwise
 */
function validateCSRFToken($token) {
    if (!isset($_SESSION['csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Get CSRF token HTML input field
 * @return string HTML input field with CSRF token
 */
function getCSRFTokenField() {
    $token = generateCSRFToken();
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
}

/**
 * Validate CSRF token from POST data
 * @return bool True if valid, false otherwise
 */
function validateCSRFPost() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return true; // Not a POST request, no CSRF risk
    }
    
    $token = $_POST['csrf_token'] ?? '';
    return validateCSRFToken($token);
}

/**
 * Require CSRF validation for POST requests
 * Dies with error message if validation fails
 */
function requireCSRFValidation() {
    if (!validateCSRFPost()) {
        http_response_code(403);
        die('CSRF token validation failed. Please try again.');
    }
}

/**
 * Regenerate CSRF token (useful after successful form submission)
 */
function regenerateCSRFToken() {
    unset($_SESSION['csrf_token']);
    generateCSRFToken();
}
?>
