<?php

declare(strict_types=1);

use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Middleware\AuthMiddleware;

return static function (\App\Core\Router $router): void {
    $router->get('/', [HomeController::class, 'index']);
    $router->get('/admin', [AuthController::class, 'index']);
    $router->get('/admin/login', [AuthController::class, 'showLogin']);
    $router->post('/admin/login', [AuthController::class, 'login']);
    $router->get('/admin/logout', [AuthController::class, 'logout']);
    $router->post('/admin/logout', [AuthController::class, 'logout']);
    $router->get('/admin/dashboard', [AdminController::class, 'dashboard'], [AuthMiddleware::class]);
};
