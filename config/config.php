<?php

declare(strict_types=1);

$baseUrl = $_ENV['APP_URL'] ?? 'http://localhost:8000';

return [
    'site_name' => 'Пинта',
    'site_tagline' => 'Магазин-паб',
    'url' => rtrim($baseUrl, '/'),
    'debug' => false,
    'timezone' => 'Europe/Moscow',
    'database' => [
        'path' => dirname(__DIR__) . '/database/database.sqlite',
    ],
];
