<?php
require_once __DIR__ . '/../src/autoload.php';

use AlphaPit\Router;
use AlphaPit\Database;
use AlphaPit\Model;
use AlphaPit\Controller;

$config = [
    'host' => 'localhost',
    'dbname' => 'alpha',
    'user' => 'root',
    'password' => '',
    'charset' => 'utf8mb4'
];

$router = new Router();

$router->get('/', function () {
    $controller = new class extends Controller {
        public function index()
        {
            $this->view('home', ['title' => 'Welcome to AlphaPit']);
        }
    };
    $controller->index();
});

$router->get('/users', function () use ($config) {
    $db = Database::getInstance($config)->connection();
    $model = new Model($db, 'users');
    header('Content-Type: application/json');
    echo json_encode($model->all());
});

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
