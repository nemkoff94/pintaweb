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

    $router->get('/privacy', [\App\Controllers\HomeController::class, 'privacy']);

    $router->post('/admin/taps/create', [AdminController::class, 'createTap'], [AuthMiddleware::class]);
    $router->post('/admin/taps/update', [AdminController::class, 'updateTap'], [AuthMiddleware::class]);
    $router->post('/admin/taps/toggle', [AdminController::class, 'toggleTap'], [AuthMiddleware::class]);
    $router->post('/admin/taps/delete', [AdminController::class, 'deleteTap'], [AuthMiddleware::class]);

    $router->post('/admin/events/create', [AdminController::class, 'createEvent'], [AuthMiddleware::class]);
    $router->post('/admin/events/update', [AdminController::class, 'updateEvent'], [AuthMiddleware::class]);
    $router->post('/admin/events/delete', [AdminController::class, 'deleteEvent'], [AuthMiddleware::class]);

    $router->post('/admin/promotions/create', [AdminController::class, 'createPromotion'], [AuthMiddleware::class]);
    $router->post('/admin/promotions/update', [AdminController::class, 'updatePromotion'], [AuthMiddleware::class]);
    $router->post('/admin/promotions/delete', [AdminController::class, 'deletePromotion'], [AuthMiddleware::class]);

    $router->post('/admin/news/create', [AdminController::class, 'createNews'], [AuthMiddleware::class]);
    $router->post('/admin/news/update', [AdminController::class, 'updateNews'], [AuthMiddleware::class]);
    $router->post('/admin/news/delete', [AdminController::class, 'deleteNews'], [AuthMiddleware::class]);
};
