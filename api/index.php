<?php
// CORS Headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Database Connection
$host = 'your_host';
$db = 'your_database';
$user = 'your_user';
$pass = 'your_password';
$charset = 'utf8mb4';

dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Route Handling
$requestUri = explode('?', $_SERVER['REQUEST_URI'], 2)[0];
$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestUri) {
    case '/auth':
        require 'handlers/auth.php';
        break;
    case '/files':
        require 'handlers/files.php';
        break;
    case '/folders':
        require 'handlers/folders.php';
        break;
    case '/shares':
        require 'handlers/shares.php';
        break;
    case '/admin':
        require 'handlers/admin.php';
        break;
    case '/storage':
        require 'handlers/storage.php';
        break;
    case '/notifications':
        require 'handlers/notifications.php';
        break;
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Not Found']);
        break;
}