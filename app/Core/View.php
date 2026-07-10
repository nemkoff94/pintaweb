<?php

declare(strict_types=1);

namespace App\Core;

final class View
{
    public static function render(string $view, array $data = []): void
    {
        $viewsPath = dirname(__DIR__) . '/Views/';
        $contentView = $viewsPath . str_replace('.', '/', $view) . '.php';

        if (! file_exists($contentView)) {
            http_response_code(500);
            echo 'View not found.';
            exit;
        }

        extract($data, EXTR_SKIP);

        $layout = $viewsPath . 'layout.php';

        require $layout;
    }
}
