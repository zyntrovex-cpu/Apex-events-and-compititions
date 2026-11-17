<?php
/**
 * APEX Events & Competitions — Database configuration
 *
 * For production use, set these values with environment variables (.env) or
 * override $_ENV before this file is required. The defaults below work with
 * a stock XAMPP install.
 */

$dbConfig = [
    'host'     => $_ENV['DB_HOST']     ?? getenv('DB_HOST')     ?: 'localhost',
    'name'     => $_ENV['DB_NAME']     ?? getenv('DB_NAME')     ?: 'apex_db',
    'user'     => $_ENV['DB_USER']     ?? getenv('DB_USER')     ?: 'root',
    'pass'     => $_ENV['DB_PASS']     ?? getenv('DB_PASS')     ?: '',
    'charset'  => 'utf8mb4',
    'port'     => $_ENV['DB_PORT']     ?? getenv('DB_PORT')     ?: 3306,
];

/**
 * Return a shared PDO connection with safe defaults.
 */
function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }
    global $dbConfig;

    $dsn = sprintf(
        'mysql:host=%s;port=%d;dbname=%s;charset=%s',
        $dbConfig['host'], (int)$dbConfig['port'], $dbConfig['name'], $dbConfig['charset']
    );

    try {
        $pdo = new PDO($dsn, $dbConfig['user'], $dbConfig['pass'], [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'",
        ]);
    } catch (PDOException $e) {
        http_response_code(500);
        if (!empty($_ENV['APP_DEBUG']) || getenv('APP_DEBUG') === 'true') {
            exit('Database connection failed: ' . htmlspecialchars($e->getMessage()));
        }
        error_log('[APEX] DB connection failed: ' . $e->getMessage());
        exit('We could not connect to the database right now. Please try again shortly.');
    }

    return $pdo;
}
