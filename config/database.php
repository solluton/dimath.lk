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

        // Attempt to add/align columns used by the new admin/UI
        try { $pdo->exec("ALTER TABLE products ADD COLUMN key_features TEXT NULL"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE products ADD COLUMN image_1 VARCHAR(255) NULL"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE products ADD COLUMN image_2 VARCHAR(255) NULL"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE products ADD COLUMN image_3 VARCHAR(255) NULL"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE products ADD COLUMN image_4 VARCHAR(255) NULL"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE products ADD COLUMN image_5 VARCHAR(255) NULL"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE products ADD COLUMN image_6 VARCHAR(255) NULL"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE products ADD COLUMN featured_home_image VARCHAR(255) NULL"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE products ADD COLUMN enable_featured_home TINYINT(1) NOT NULL DEFAULT 0"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE products ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL"); } catch (PDOException $e) {}
        // New single product fields
        try { $pdo->exec("ALTER TABLE products ADD COLUMN category VARCHAR(100) NULL"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE products ADD COLUMN rating_score DECIMAL(3,2) NULL DEFAULT 0.00"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE products ADD COLUMN reviews_count INT NULL DEFAULT 0"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE products ADD COLUMN show_reviews TINYINT(1) NOT NULL DEFAULT 1"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE products ADD COLUMN details TEXT NULL"); } catch (PDOException $e) {}
        // Ensure slug is unique (ignore if already exists)
        try { $pdo->exec("CREATE UNIQUE INDEX idx_products_slug ON products(slug)"); } catch (PDOException $e) {}
        
        // Create/upgrade contact leads table to new schema (supports first/last name)
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
            status ENUM('new', 'read', 'replied', 'closed') DEFAULT 'new',
            ip_address VARCHAR(45) NULL,
            user_agent TEXT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        
        $pdo->exec($sql);

        // Attempt to add new columns if table already exists
        try { $pdo->exec("ALTER TABLE contact_leads ADD COLUMN phone VARCHAR(50) NULL"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE contact_leads ADD COLUMN first_name VARCHAR(100) NULL"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE contact_leads ADD COLUMN last_name VARCHAR(100) NULL"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE contact_leads MODIFY COLUMN phone VARCHAR(50) NULL"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE contact_leads ADD COLUMN company VARCHAR(150) NULL"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE contact_leads ADD COLUMN subject VARCHAR(191) NULL"); } catch (PDOException $e) {}
        // Remove legacy terms_accept column if present (no longer needed)
        try { $pdo->exec("ALTER TABLE contact_leads DROP COLUMN terms_accept"); } catch (PDOException $e) {}
        
        // Create products table
        $sql = "CREATE TABLE IF NOT EXISTS products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            subtitle VARCHAR(255) NULL,
            description TEXT NOT NULL,
            tagline VARCHAR(500) NULL,
            main_image VARCHAR(255) NULL,
            gallery_images TEXT NULL,
            features_section_title VARCHAR(255) NULL,
            features_section_subtitle VARCHAR(255) NULL,
            meta_title VARCHAR(255) NULL,
            meta_description TEXT NULL,
            slug VARCHAR(191) UNIQUE NULL,
            status ENUM('active', 'inactive') DEFAULT 'active',
            display_order INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        
        $pdo->exec($sql);
        
        // Create product_features table for the 'Why Choose' section
        $sql = "CREATE TABLE IF NOT EXISTS product_features (
            id INT AUTO_INCREMENT PRIMARY KEY,
            product_id INT NOT NULL,
            title VARCHAR(255) NOT NULL,
            description TEXT NOT NULL,
            icon VARCHAR(255) NULL,
            display_order INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
        )";
        
        $pdo->exec($sql);

        // Create product_categories table
        $sql = "CREATE TABLE IF NOT EXISTS product_categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(150) NOT NULL,
            slug VARCHAR(191) UNIQUE NOT NULL,
            description TEXT NULL,
            status ENUM('active','inactive') DEFAULT 'active',
            display_order INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        $pdo->exec($sql);
        // Attempt to add columns/indexes if table already exists (safe-guards)
        try { $pdo->exec("ALTER TABLE product_categories ADD COLUMN description TEXT NULL"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE product_categories ADD COLUMN status ENUM('active','inactive') DEFAULT 'active'"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE product_categories ADD COLUMN display_order INT DEFAULT 0"); } catch (PDOException $e) {}
        try { $pdo->exec("CREATE UNIQUE INDEX idx_product_categories_slug ON product_categories(slug)"); } catch (PDOException $e) {}

        // Add or upgrade product columns (safe-guards if table exists already)
        try { $pdo->exec("ALTER TABLE products ADD COLUMN subtitle VARCHAR(255) NULL"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE products ADD COLUMN tagline VARCHAR(500) NULL"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE products ADD COLUMN gallery_images TEXT NULL"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE products ADD COLUMN features_section_title VARCHAR(255) NULL"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE products ADD COLUMN features_section_subtitle VARCHAR(255) NULL"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE products ADD COLUMN featured_home_image VARCHAR(255) NULL"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE products ADD COLUMN enable_featured_slider TINYINT(1) NOT NULL DEFAULT 0"); } catch (PDOException $e) {}
        // Add category_id to products (optional link to categories)
        try { $pdo->exec("ALTER TABLE products ADD COLUMN category_id INT NULL"); } catch (PDOException $e) {}
        try { $pdo->exec("ALTER TABLE products ADD CONSTRAINT fk_products_category FOREIGN KEY (category_id) REFERENCES product_categories(id) ON SET NULL ON DELETE SET NULL"); } catch (PDOException $e) {}
        
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
