# Pintaweb

Лёгкий PHP-проект для сайта магазина-паба «Пинта» без тяжёлых фреймворков. Проект готов к запуску сразу после клонирования и подходит как для локальной разработки, так и для обычного виртуального хостинга.

## Технологии

- PHP 8.2+
- SQLite
- PDO
- Tailwind CSS
- Alpine.js
- MVC-lite архитектура
- PSR-12

## Установка

1. Клонируйте репозиторий.
2. При необходимости выполните:

   ```bash
   composer install
   ```

   Composer не обязателен для запуска: проект содержит собственный автозагрузчик и работает без внешних пакетов.

## Запуск

Локально через встроенный PHP-сервер:

```bash
php -S localhost:8000 -t public
```

После запуска откройте:

- Главная страница: `http://localhost:8000/`
- Админ-вход: `http://localhost:8000/admin`

Данные администратора, создаваемого автоматически при первом запуске:

- Логин: `admin`
- Пароль: `52525647`

## Структура проекта

```text
app/
    Controllers/
    Core/
    Middleware/
    Models/
    Views/
config/
database/
public/
    assets/
routes/
storage/
vendor/
composer.json
README.md
```

## Архитектура

Проект построен как лёгкий MVC-lite фундамент:

- `public/index.php` — front controller и bootstrap приложения
- `routes/web.php` — описание маршрутов
- `app/Controllers` — HTTP-контроллеры
- `app/Models` — работа с данными
- `app/Core` — базовые классы (`Router`, `Request`, `Database`, `View`, `Session`, `Csrf`)
- `app/Middleware` — middleware проверки авторизации
- `app/Views` — шаблоны и layout

## Особенности

- База SQLite создаётся автоматически при первом запуске
- Таблица пользователей создаётся автоматически
- Администратор `admin` создаётся автоматически, если отсутствует
- Пароль хранится только как `password_hash()`
- Авторизация использует `PHP Sessions`, `password_verify()`, `CSRF`, `Prepared Statements`
- Главная страница и админ-панель легко расширяются без изменения базовой архитектуры