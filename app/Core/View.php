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

        $layoutName = 'layout';

        if (isset($data['layout']) && is_string($data['layout']) && $data['layout'] !== '') {
            $layoutName = $data['layout'];
            unset($data['layout']);
        }

        extract($data, EXTR_SKIP);

        $layout = $viewsPath . str_replace('.', '/', $layoutName) . '.php';

        if (! file_exists($layout)) {
            http_response_code(500);
            echo 'Layout not found.';
            exit;
        }

        require $layout;
    }
}
