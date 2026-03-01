<?php
header('Content-Type: application/json; charset=utf-8');

require __DIR__.'/../vendor/autoload.php';

use App\Router\Router;

use App\Database\Connection;
use App\Controllers\AccountController;
use App\Controllers\TransactionController;
use App\Repositories\AccountRepository;
use App\Exceptions\ExceptionHandler;

$pdo = Connection::get();

$accountRepository = new AccountRepository($pdo);
$accountController = new AccountController($accountRepository);

$router = new Router();

$router->add('POST', '/conta', [$accountController,'register']);
$router->add('GET', '/conta', [$accountController, 'show']);
$router->add('POST', '/transacao', [TransactionController::class, 'transaction']);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

try {
    $router->dispatch($method, $uri);
} catch (Throwable $e) {
    ExceptionHandler::handle($e);
}