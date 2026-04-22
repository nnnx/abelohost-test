<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Core\Router;
use Core\View;

set_exception_handler(function (Throwable $e): void {
    http_response_code(500);
    try {
        View::render('error', [
            'httpCode' => 500,
            'message' => $e->getMessage(),
        ]);
    } catch (Throwable $viewError) {
        echo 'Critical error: ' . $viewError->getMessage();
    }
    exit;
});

$router = new Router();
$routes = require __DIR__ . '/../config/routes.php';
$routes($router);

$router->dispatch(
    $_SERVER['REQUEST_URI'],
    $_SERVER['REQUEST_METHOD']
);