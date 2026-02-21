<?php

require __DIR__.'/../vendor/autoload.php';

use App\Router\Router;
use App\Controllers\AccountController;

$router = new Router();

$router->add('POST', '/conta', [AccountController::class,'register']);
$router->add('GET', '/conta', [AccountController::class, 'show']);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$router->dispatch($method, $uri);