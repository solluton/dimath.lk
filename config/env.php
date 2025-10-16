<?php
/**
 * Environment helper
 * Reads variables from a .env-like source with simple fallbacks
 */

function env($key, $default = null) {
    static $cache = null;
    if ($cache === null) {
        $cache = [];
        $env_path = __DIR__ . '/../.env';
        if (file_exists($env_path)) {
            $lines = file($env_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos(ltrim($line), '#') === 0) { continue; }
                $parts = explode('=', $line, 2);
                if (count($parts) === 2) {
                    $cache[trim($parts[0])] = trim($parts[1]);
                }
            }
        }
    }
    return $cache[$key] ?? $default;
}

/**
 * Load environment variables from .env file
 */
function loadEnv() {
    $env_path = __DIR__ . '/../.env';
    if (file_exists($env_path)) {
        $lines = file($env_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(ltrim($line), '#') === 0) { continue; }
            $parts = explode('=', $line, 2);
            if (count($parts) === 2) {
                $key = trim($parts[0]);
                $value = trim($parts[1]);
                if (!getenv($key)) {
                    putenv("$key=$value");
                    $_ENV[$key] = $value;
                    $_SERVER[$key] = $value;
                }
            }
        }
    }
}

// Provide sensible defaults for CLI scripts when .env is missing
if (!getenv('SITE_URL') && !isset($_SERVER['HTTP_HOST'])) {
    // Ensure getBaseUrl() has a domain to use in CLI contexts
    if (!defined('DEFAULT_SITE_URL')) {
        define('DEFAULT_SITE_URL', 'dimath.lk');
    }
}
