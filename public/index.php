<?php

declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$allowedOrigins = [
    'http://localhost:5173',
    'http://127.0.0.1:5173',
    'http://localhost:3000',
];

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
if (in_array($origin, $allowedOrigins)) {
    header("Access-Control-Allow-Origin: {$origin}");
} else {
    header('Access-Control-Allow-Origin: http://localhost:5173');
}

header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age: 86400');

// Handle preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$contentType = $_SERVER['CONTENT_TYPE'] ?? '';
if (stripos($contentType, 'multipart/form-data') === false) {
    header('Content-Type: application/json');
}

// UPDATE: Penyesuaian path vendor agar fleksibel di server
$autoload = __DIR__ . '/vendor/autoload.php';
if (!file_exists($autoload)) {
    $autoload = __DIR__ . '/../vendor/autoload.php';
}

if (!file_exists($autoload)) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'vendor/autoload.php tidak ditemukan.']);
    exit;
}
require_once $autoload;

// UPDATE: Penyesuaian path .env
$envPath = file_exists(__DIR__ . '/.env') ? __DIR__ : __DIR__ . '/../';
$dotenv = Dotenv\Dotenv::createImmutable($envPath);
$dotenv->load();

use App\Core\Router;

$router = new Router();

// UPDATE: Penyesuaian path routes api
$routesPath = file_exists(__DIR__ . '/routes/api.php') ? __DIR__ . '/routes/api.php' : __DIR__ . '/../routes/api.php';
require_once $routesPath;

$method = $_SERVER['REQUEST_METHOD'];
$uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// UPDATE: Menghapus folder lokal Sempaja_Waterpark agar routing Vercel jalan
$uri = str_replace(['/Sempaja_Waterpark/public', '/Sempaja_Waterpark'], '', $uri);

if (empty($uri) || $uri === '') $uri = '/';

$router->dispatch($method, $uri);