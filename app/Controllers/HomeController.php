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
        View::render('home.index', [
            'config' => $this->config,
            'title' => 'Главная',
        ]);
    }
}
