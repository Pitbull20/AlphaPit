<?php
require_once __DIR__ . '/../../framework/autoload.php';
require_once __DIR__ . '/../autoload.php';
define('VIEW_PATH', __DIR__ . '/../views');

use AlphaPit\Router;
use AlphaPit\Database;
use AlphaPit\DI\ServiceContainer;
use AlphaPit\Env;
use App\AppModule;

Env::load(__DIR__ . '/../../.env');

$config = [
    'host' => getenv('DB_HOST') ?: 'localhost',
    'dbname' => getenv('DB_NAME') ?: 'alpha',
    'user' => getenv('DB_USER') ?: 'root',
    'password' => getenv('DB_PASSWORD') ?: '',
    'charset' => getenv('DB_CHARSET') ?: 'utf8mb4'
];

$container = new ServiceContainer();
$container->set(\PDO::class, function () use ($config) {
    return Database::getInstance($config)->connection();
});

$router = new Router();
$appModule = new AppModule();
$router->registerModule($appModule, $container);

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
