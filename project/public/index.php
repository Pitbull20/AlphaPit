<?php
require_once __DIR__ . '/../../framework/autoload.php';
require_once __DIR__ . '/../autoload.php';
define('VIEW_PATH', __DIR__ . '/../views');

use AlphaPit\Router;
use AlphaPit\Database;
use AlphaPit\DI\ServiceContainer;
use App\AppModule;

$config = [
    'host' => 'localhost',
    'dbname' => 'alpha',
    'user' => 'root',
    'password' => '',
    'charset' => 'utf8mb4'
];


$container = new ServiceContainer();
$container->set(\PDO::class, function () use ($config) {
    return Database::getInstance($config)->connection();
});

$router = new Router();
$appModule = new AppModule();
$router->registerModule($appModule, $container);

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
