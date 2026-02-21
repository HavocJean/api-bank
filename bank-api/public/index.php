<?php
header('Content-Type: application/json; charset=utf-8');

require __DIR__.'/../vendor/autoload.php';

use App\Router\Router;
use App\Controllers\AccountController;
use App\Controllers\TransactionController;

$router = new Router();

$router->add('POST', '/conta', [AccountController::class,'register']);
$router->add('GET', '/conta', [AccountController::class, 'show']);
$router->add('POST', '/transacao', [TransactionController::class, 'transaction']);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$router->dispatch($method, $uri);