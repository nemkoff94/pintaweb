<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;

final class AuthMiddleware
{
    public function handle(Request $request): void
    {
        if (! is_array(Session::get('auth_user'))) {
            Session::flash('error', 'Пожалуйста, войдите в систему.');
            Response::redirect('/admin');
        }
    }
}
