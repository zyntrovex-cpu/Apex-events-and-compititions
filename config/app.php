<?php
/**
 * APEX Events & Competitions — Application bootstrap
 */

// Load .env if present
$envFile = dirname(__DIR__) . '/.env';
if (is_file($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#') continue;
        if (!str_contains($line, '=')) continue;
        [$k, $v] = array_map('trim', explode('=', $line, 2));
        $v = trim($v, "\"'");
        if ($k !== '' && !isset($_ENV[$k])) {
            $_ENV[$k] = $v;
            putenv("$k=$v");
        }
    }
}

date_default_timezone_set($_ENV['APP_TIMEZONE'] ?? 'Asia/Karachi');

if (($_ENV['APP_DEBUG'] ?? '') === 'true') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
}

// Secure session configuration — start session once, before any output
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'domain'   => '',
        'secure'   => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    session_name('APEXSESSID');
    session_start();
}

require_once __DIR__ . '/database.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/csrf.php';
require_once dirname(__DIR__) . '/includes/freeze.php';

define('APP_ROOT', dirname(__DIR__));
define('ASSET_PATH', 'assets');
define('UPLOAD_PATH', 'uploads');

/**
 * Site-wide dynamic constants loaded from DB.
 */
if (!function_exists('setting')) {
    function setting(string $key, string $default = ''): string {
        static $cache = null;
        if ($cache === null) {
            try {
                $stmt = db()->query('SELECT setting_key, setting_value FROM site_settings');
                $cache = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
            } catch (Throwable $e) { $cache = []; }
        }
        return (string)($cache[$key] ?? $default);
    }
}
