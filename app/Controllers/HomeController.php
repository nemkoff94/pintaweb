<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\View;
use App\Core\Database;
use App\Models\AdminContent;

final class HomeController
{
    public function __construct(private readonly array $config)
    {
    }

    public function index(Request $request): void
    {
        $repository = new AdminContent(Database::connection($this->config));

        View::render('home.index', [
            'config' => $this->config,
            'title' => 'Главная',
            'bodyClass' => 'home-page',
            'taps' => $repository->listTaps(),
            'events' => $repository->listEvents(),
            'promotions' => $repository->listPromotions(),
            'news' => $repository->listNews(),
        ]);
    }

    public function privacy(Request $request): void
    {
        View::render('home.privacy', [
            'config' => $this->config,
            'title' => 'Политика конфиденциальности',
        ]);
    }
}
