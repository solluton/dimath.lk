<?php
/**
 * Simple database connection for background scripts (no sessions)
 */

function getSimpleDBConnection() {
    // Load environment variables
    require_once __DIR__ . '/env.php';
    loadEnv();
    
    // Require critical environment variables (no fallbacks)
    function requireEnvValue($key) {
        $val = env($key);
        if ($val === null || $val === '') {
            throw new Exception("Missing required environment variable: $key. Please set it in .env file.");
        }
        return $val;
    }
    
    $host = requireEnvValue('DB_HOST');
    $dbname = requireEnvValue('DB_NAME');
    $username = requireEnvValue('DB_USER');
    $password = env('DB_PASS', ''); // Password can be empty
    $port = env('DB_PORT', '3306'); // Port can have default
    
    try {
        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        
        return new PDO($dsn, $username, $password, $options);
    } catch (PDOException $e) {
        error_log("Database connection failed: " . $e->getMessage());
        throw new Exception("Database connection failed: " . $e->getMessage());
    }
}
?>
