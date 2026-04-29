<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Header CORS
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Access-Control-Allow-Credentials: true');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Deteksi Autoload
$autoload = __DIR__ . '/vendor/autoload.php';
if (!file_exists($autoload)) {
    $autoload = __DIR__ . '/../vendor/autoload.php';
}

if (!file_exists($autoload)) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Vendor tidak ditemukan. Pastikan composer.json ada di root.']);
    exit;
}

require_once $autoload;

// Load Env jika ada
if (class_exists('Dotenv\Dotenv')) {
    $envPath = file_exists(__DIR__ . '/.env') ? __DIR__ : __DIR__ . '/../';
    if (file_exists($envPath . '.env')) {
        $dotenv = Dotenv\Dotenv::createImmutable($envPath);
        $dotenv->load();
    }
}

use App\Core\Router;
$router = new Router();

$routesPath = file_exists(__DIR__ . '/routes/api.php') ? __DIR__ : __DIR__ . '/..';
require_once $routesPath . '/routes/api.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Menghapus folder lokal agar routing bersih di Vercel [cite: 10, 11]
$uri = str_replace(['/Sempaja_Waterpark/public', '/Sempaja_Waterpark'], '', $uri);
if (empty($uri)) $uri = '/';

$router->dispatch($method, $uri);