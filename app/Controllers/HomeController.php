<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\View;

final class HomeController
{
    public function __construct(private readonly array $config)
    {
    }

    public function index(Request $request): void
    {
        // If a static landing exists, serve it as the homepage
        $base = dirname(__DIR__, 2);
        $static = $base . '/public/pinta-static/index.html';

        if (is_file($static)) {
            // Serve the static file and stop further processing
            header('Content-Type: text/html; charset=utf-8');
            echo file_get_contents($static);
            return;
        }

        View::render('home.index', [
            'config' => $this->config,
            'title' => 'Главная',
        ]);
    }
}
