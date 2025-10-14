<?php
/**
 * Password Security Helper Functions
 * Provides secure password validation and strength checking
 */

/**
 * Validate password strength
 * @param string $password The password to validate
 * @return array Array with 'valid' boolean and 'errors' array
 */
function validatePasswordStrength($password) {
    $errors = [];
    
    // Check minimum length
    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters long';
    }
    
    // Check for common weak passwords
    $weakPasswords = [
        'admin123', 'password', '123456', 'admin', 'root', 'user',
        'test123', 'qwerty', 'abc123', 'password123', 'admin123456',
        '12345678', 'password1', 'admin1234', 'test', 'demo'
    ];
    
    if (in_array(strtolower($password), $weakPasswords)) {
        $errors[] = 'Password is too common. Please choose a stronger password';
    }
    
    // Check for uppercase letter
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = 'Password must contain at least one uppercase letter';
    }
    
    // Check for lowercase letter
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = 'Password must contain at least one lowercase letter';
    }
    
    // Check for number
    if (!preg_match('/[0-9]/', $password)) {
        $errors[] = 'Password must contain at least one number';
    }
    
    // Check for special character
    if (!preg_match('/[^A-Za-z0-9]/', $password)) {
        $errors[] = 'Password must contain at least one special character (!@#$%^&*)';
    }
    
    // Check for common patterns
    if (preg_match('/(.)\1{2,}/', $password)) {
        $errors[] = 'Password cannot contain repeated characters (e.g., aaa, 111)';
    }
    
    // Check for sequential characters
    if (preg_match('/(abc|bcd|cde|def|efg|fgh|ghi|hij|ijk|jkl|klm|lmn|mno|nop|opq|pqr|qrs|rst|stu|tuv|uvw|vwx|wxy|xyz)/i', $password)) {
        $errors[] = 'Password cannot contain sequential characters (e.g., abc, 123)';
    }
    
    return [
        'valid' => empty($errors),
        'errors' => $errors
    ];
}

/**
 * Generate a secure random password
 * @param int $length Password length (default 12)
 * @return string Generated password
 */
function generateSecurePassword($length = 12) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
    $password = '';
    
    // Ensure at least one character from each required type
    $password .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'[random_int(0, 25)]; // Uppercase
    $password .= 'abcdefghijklmnopqrstuvwxyz'[random_int(0, 25)]; // Lowercase
    $password .= '0123456789'[random_int(0, 9)]; // Number
    $password .= '!@#$%^&*'[random_int(0, 7)]; // Special character
    
    // Fill remaining length
    for ($i = 4; $i < $length; $i++) {
        $password .= $chars[random_int(0, strlen($chars) - 1)];
    }
    
    // Shuffle the password
    return str_shuffle($password);
}

/**
 * Check if password has been compromised (basic check)
 * @param string $password The password to check
 * @return bool True if password appears to be compromised
 */
function isPasswordCompromised($password) {
    // This is a basic implementation
    // In production, you might want to integrate with HaveIBeenPwned API
    
    $compromisedPatterns = [
        '/password/i',
        '/admin/i',
        '/123456/',
        '/qwerty/i',
        '/abc123/i',
        '/test/i',
        '/demo/i'
    ];
    
    foreach ($compromisedPatterns as $pattern) {
        if (preg_match($pattern, $password)) {
            return true;
        }
    }
    
    return false;
}
?>
