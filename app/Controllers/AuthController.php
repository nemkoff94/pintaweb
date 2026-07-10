<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Database;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\User;

final class AuthController
{
    public function __construct(private readonly array $config)
    {
    }

    public function index(Request $request): void
    {
        if (is_array(Session::get('auth_user'))) {
            Response::redirect('/admin/dashboard');
        }

        $this->showLogin($request);
    }

    public function showLogin(Request $request): void
    {
        if (is_array(Session::get('auth_user'))) {
            Response::redirect('/admin/dashboard');
        }

        View::render('admin.login', [
            'config' => $this->config,
            'title' => 'Вход в админ-панель',
            'csrfToken' => Csrf::token(),
            'error' => Session::pullFlash('error'),
            'oldLogin' => Session::pullFlash('old_login', 'admin'),
        ]);
    }

    public function login(Request $request): void
    {
        if (! Csrf::validate($request->input('_token'))) {
            http_response_code(419);
            Session::flash('error', 'Сессия формы истекла. Попробуйте ещё раз.');
            Response::redirect('/admin');
        }

        $login = $request->input('login', '');
        $password = $request->input('password', '');

        Session::flash('old_login', $login);

        $userModel = new User(Database::connection($this->config));
        $user = $userModel->findByLogin($login ?? '');

        if (! is_array($user) || ! password_verify($password ?? '', $user['password_hash'])) {
            Session::flash('error', 'Неверный логин или пароль.');
            Response::redirect('/admin');
        }

        Session::regenerate();
        Session::put('auth_user', [
            'id' => $user['id'],
            'login' => $user['login'],
        ]);
        Session::forget('_flash');

        Response::redirect('/admin/dashboard');
    }

    public function logout(Request $request): void
    {
        if ($request->method() !== 'POST') {
            $target = is_array(Session::get('auth_user')) ? '/admin/dashboard' : '/admin';
            Response::redirect($target);
        }

        if (! Csrf::validate($request->input('_token'))) {
            http_response_code(419);
            Session::flash('error', 'Сессия формы истекла. Попробуйте ещё раз.');
            Response::redirect('/admin/dashboard');
        }

        Session::forget('auth_user');
        Session::regenerate();
        Session::flash('error', 'Вы вышли из административной панели.');

        Response::redirect('/admin');
    }
}
