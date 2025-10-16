<?php
// Database configuration using environment variables
// This ensures the database connection uses .env file values

// Load environment variables
require_once __DIR__ . '/env.php';
require_once __DIR__ . '/security.php';

// Database configuration from .env file ONLY (no hardcoded defaults)
function requireEnvValue($key) {
    $val = env($key);
    if ($val === null || $val === '') {
        http_response_code(500);
        die('Missing required env variable: ' . $key . '. Please set it in .env');
    }
    return $val;
}

define('DB_HOST', requireEnvValue('DB_HOST'));
define('DB_USER', requireEnvValue('DB_USER'));
define('DB_PASS', env('DB_PASS', ''));
define('DB_NAME', requireEnvValue('DB_NAME'));

// Secure session configuration
function secureSession() {
    // Prevent session fixation
    ini_set('session.use_strict_mode', 1);
    
    // Secure session cookies
    ini_set('session.cookie_httponly', 1);
    // Only mark secure when running over HTTPS; allow HTTP during local dev
    $is_https = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
    ini_set('session.cookie_secure', $is_https ? 1 : 0);
    ini_set('session.cookie_samesite', 'Strict');
    ini_set('session.cookie_lifetime', 0); // Session cookie expires when browser closes
    
    // Session security settings
    ini_set('session.use_only_cookies', 1);
    ini_set('session.use_trans_sid', 0);
    
    // Regenerate session ID periodically
    if (!isset($_SESSION['last_regeneration'])) {
        $_SESSION['last_regeneration'] = time();
    } elseif (time() - $_SESSION['last_regeneration'] > 300) { // 5 minutes
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
}

// Start secure session only if not already started
function startSecureSession() {
    if (session_status() === PHP_SESSION_NONE) {
        secureSession();
        session_start();
    }
}

// Create database connection
function getDBConnection() {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Set database timezone to Sri Lanka
        setDatabaseTimezone($pdo);
        
        return $pdo;
    } catch(PDOException $e) {
        handleDatabaseError($e, 'database connection');
        return false;
    }
}

// Initialize database and create users table if it doesn't exist
function initializeDatabase() {
    try {
        // First connect without database to create it if needed
        $pdo = new PDO("mysql:host=" . DB_HOST, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Create database if it doesn't exist
        $db_name = DB_NAME;
        $pdo->exec("CREATE DATABASE IF NOT EXISTS " . $db_name);
        $pdo->exec("USE " . $db_name);
        
        // Create users table
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            username VARCHAR(50) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            role ENUM('admin', 'user') DEFAULT 'user',
            remember_token VARCHAR(255) NULL,
            reset_token VARCHAR(255) NULL,
            reset_token_expiry DATETIME NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        
        $pdo->exec($sql);

        // Product management removed - no product table modifications needed
        
        // Create/upgrade contact leads table to align with admin panel usage
        $sql = "CREATE TABLE IF NOT EXISTS contact_leads (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(150) NOT NULL,
            first_name VARCHAR(100) NULL,
            last_name VARCHAR(100) NULL,
            email VARCHAR(100) NOT NULL,
            phone VARCHAR(50) NULL,
            company VARCHAR(150) NULL,
            subject VARCHAR(191) NULL,
            message TEXT NOT NULL,
            terms_accepted TINYINT(1) DEFAULT 0,
            status ENUM('new', 'read', 'replied', 'closed') DEFAULT 'new',
            ip_address VARCHAR(45) NULL,
            user_agent TEXT NULL,
            deleted_at TIMESTAMP NULL DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_contact_email_created_at (email, created_at),
            INDEX idx_contact_status_created_at (status, created_at)
        )";
        
        $pdo->exec($sql);

        // Attempt to add new columns if table already exists
        try { $pdo->exec("ALTER TABLE contact_leads ADD COLUMN phone VARCHAR(50) NULL"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE contact_leads ADD COLUMN first_name VARCHAR(100) NULL"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE contact_leads ADD COLUMN last_name VARCHAR(100) NULL"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE contact_leads MODIFY COLUMN phone VARCHAR(50) NULL"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE contact_leads ADD COLUMN company VARCHAR(150) NULL"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE contact_leads ADD COLUMN subject VARCHAR(191) NULL"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE contact_leads ADD COLUMN terms_accepted TINYINT(1) DEFAULT 0"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE contact_leads ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL"); } catch (PDOException $e) {}
        
        // Product management removed - no product tables needed
        
        // Check if admin user exists (no hardcoded credentials)
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE role = 'admin'");
        $stmt->execute();
        
        if ($stmt->fetchColumn() == 0) {
            // No admin user exists - this should be created manually or through a setup script
            error_log("No admin user found. Please create an admin user manually.");
        }
        
        return true;
    } catch(PDOException $e) {
        handleDatabaseError($e, 'database initialization');
        return false;
    }
}

// Session management
// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Get current user data
function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("SELECT id, name, email, username, role, profile_picture FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        return null;
    }
}

// Redirect to login if not authenticated
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }
}

// Redirect to dashboard if already logged in
function redirectIfLoggedIn() {
    if (isLoggedIn()) {
        header('Location: dashboard.php');
        exit();
    }
}

// Set timezone to Sri Lanka (Asia/Colombo)
date_default_timezone_set('Asia/Colombo');

// Set MySQL timezone to match PHP
function setDatabaseTimezone($pdo) {
    try {
        $pdo->exec("SET time_zone = '+05:30'");
    } catch(PDOException $e) {
        // Log error but don't fail
        error_log("Failed to set database timezone: " . $e->getMessage());
    }
}

// Initialize database on include
initializeDatabase();

// Only start session early if headers not sent, to avoid warnings when included mid-output
if (php_sapi_name() !== 'cli' && session_status() === PHP_SESSION_NONE && !headers_sent()) {
    startSecureSession();
}
?>
