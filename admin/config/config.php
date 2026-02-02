<?php
require_once __DIR__ . '/../../vendor/autoload.php'; // Adjust path to vendor

use Dotenv\Dotenv;

/* =========================
   Auto-detect Environment
========================= */
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';

if (in_array($host, ['localhost', '127.0.0.1'])) {
    $envFile = '.env.local';
    $appEnv = 'local';
} elseif (strpos($host, 'epizy.com') !== false || strpos($host, 'infinityfreeapp.com') !== false) {
    $envFile = '.env.test_site';
    $appEnv = 'test_site';
} else {
    // Default to local if unknown
    $envFile = '.env.local';
    $appEnv = 'local';
}

/* =========================
   Load Environment Variables
========================= */
// Since .env files are in the root, we use dirname(__DIR__, 2)
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2), $envFile);
$dotenv->safeLoad();

/* =========================
   Database Configuration
========================= */
$DB_HOST = $_ENV['DB_HOST'] ?? 'localhost';
$DB_NAME = $_ENV['DB_NAME'] ?? 'dbname';
$DB_USER = $_ENV['DB_USER'] ?? 'root';
$DB_PASS = $_ENV['DB_PASS'] ?? '';
$DB_CHARSET = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

/* =========================
   PDO Connection
========================= */
$dsn = "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=$DB_CHARSET";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS, $options);
} catch (PDOException $e) {
    if ($appEnv === 'local') {
        die('Database connection failed: ' . $e->getMessage());
    } else {
        die('Database connection failed.');
    }
}
