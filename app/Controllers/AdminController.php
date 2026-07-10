<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\View;

final class AdminController
{
    public function __construct(private readonly array $config)
    {
    }

    public function dashboard(Request $request): void
    {
        View::render('admin.dashboard', [
            'config' => $this->config,
            'title' => 'Административная панель',
        ]);
    }
}
