<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Database;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Models\AdminContent;

final class AdminController
{
    public function __construct(private readonly array $config)
    {
    }

    public function dashboard(Request $request): void
    {
        $section = $this->normalizeSection($request->input('section', 'taps'));
        $repository = new AdminContent(Database::connection($this->config));

        View::render('admin.dashboard', [
            'config' => $this->config,
            'title' => 'Управление контентом',
            'layout' => 'admin.layout',
            'csrfToken' => Csrf::token(),
            'section' => $section,
            'flashSuccess' => Session::pullFlash('success'),
            'flashError' => Session::pullFlash('error'),
            'taps' => $repository->listTaps(),
            'events' => $repository->listEvents(),
            'promotions' => $repository->listPromotions(),
            'news' => $repository->listNews(),
            'mediaAssets' => $repository->listMediaAssets(),
        ]);
    }

    public function createTap(Request $request): void
    {
        if (! $this->validateCsrf($request, 'taps')) {
            return;
        }

        $name = $request->input('name', '') ?? '';
        $style = $request->input('style', '') ?? '';
        $abv = $this->toDecimal($request->input('abv', '0'));
        $priceStoreLiter = $this->toDecimal($request->input('price_store_liter', '0'));
        $priceBarHalf = $this->toDecimal($request->input('price_bar_half', '0'));

        if ($name === '' || $style === '') {
            Session::flash('error', 'Для сорта на кране заполните название и стиль.');
            Response::redirect('/admin/dashboard?section=taps');
        }

        $repository = new AdminContent(Database::connection($this->config));
        $imagePath = $this->resolveImagePath('tap_image', $request->input('existing_image'));
        $now = date(DATE_ATOM);

        $repository->createTap([
            ':name' => $name,
            ':style' => $style,
            ':abv' => $abv,
            ':price_store_liter' => $priceStoreLiter,
            ':price_bar_half' => $priceBarHalf,
            ':image_path' => $imagePath,
            ':is_on_tap' => 0,
            ':created_at' => $now,
            ':updated_at' => $now,
        ]);

        Session::flash('success', 'Новый сорт добавлен.');
        Response::redirect('/admin/dashboard?section=taps');
    }

    public function updateTap(Request $request): void
    {
        if (! $this->validateCsrf($request, 'taps')) {
            return;
        }

        $id = (int) ($request->input('id', '0') ?? 0);

        if ($id <= 0) {
            Session::flash('error', 'Не удалось определить сорт для обновления.');
            Response::redirect('/admin/dashboard?section=taps');
        }

        $name = $request->input('name', '') ?? '';
        $style = $request->input('style', '') ?? '';

        if ($name === '' || $style === '') {
            Session::flash('error', 'Для обновления сорта заполните название и стиль.');
            Response::redirect('/admin/dashboard?section=taps');
        }

        $repository = new AdminContent(Database::connection($this->config));
        $imagePath = $this->resolveImagePath('tap_image', $request->input('existing_image'), $request->input('current_image'));

        $repository->updateTap($id, [
            ':name' => $name,
            ':style' => $style,
            ':abv' => $this->toDecimal($request->input('abv', '0')),
            ':price_store_liter' => $this->toDecimal($request->input('price_store_liter', '0')),
            ':price_bar_half' => $this->toDecimal($request->input('price_bar_half', '0')),
            ':image_path' => $imagePath,
            ':updated_at' => date(DATE_ATOM),
        ]);

        Session::flash('success', 'Сорт обновлён.');
        Response::redirect('/admin/dashboard?section=taps');
    }

    public function toggleTap(Request $request): void
    {
        if (! $this->validateCsrf($request, 'taps')) {
            return;
        }

        $id = (int) ($request->input('id', '0') ?? 0);

        if ($id <= 0) {
            Session::flash('error', 'Не удалось изменить статус сорта.');
            Response::redirect('/admin/dashboard?section=taps');
        }

        $enabled = $request->input('enabled', '0') === '1';

        $repository = new AdminContent(Database::connection($this->config));
        $repository->toggleTap($id, $enabled);

        Session::flash('success', 'Статус сорта обновлён.');
        Response::redirect('/admin/dashboard?section=taps');
    }

    public function deleteTap(Request $request): void
    {
        if (! $this->validateCsrf($request, 'taps')) {
            return;
        }

        $id = (int) ($request->input('id', '0') ?? 0);

        if ($id <= 0) {
            Session::flash('error', 'Не удалось удалить сорт.');
            Response::redirect('/admin/dashboard?section=taps');
        }

        $repository = new AdminContent(Database::connection($this->config));
        $repository->deleteTap($id);

        Session::flash('success', 'Сорт удалён.');
        Response::redirect('/admin/dashboard?section=taps');
    }

    public function createEvent(Request $request): void
    {
        if (! $this->validateCsrf($request, 'events')) {
            return;
        }

        $title = $request->input('title', '') ?? '';
        $announce = $request->input('announce', '') ?? '';
        $description = $request->input('description', '') ?? '';
        $eventAt = $request->input('event_at', '') ?? '';

        if ($title === '' || $announce === '' || $description === '' || $eventAt === '') {
            Session::flash('error', 'Для события заполните название, анонс, описание и дату.');
            Response::redirect('/admin/dashboard?section=events');
        }

        $repository = new AdminContent(Database::connection($this->config));
        $coverPath = $this->resolveImagePath('event_cover', $request->input('existing_image'));
        $now = date(DATE_ATOM);

        $repository->createEvent([
            ':title' => $title,
            ':announce' => $announce,
            ':description' => $description,
            ':cover_image_path' => $coverPath,
            ':event_at' => $eventAt,
            ':created_at' => $now,
            ':updated_at' => $now,
        ]);

        Session::flash('success', 'Событие добавлено.');
        Response::redirect('/admin/dashboard?section=events');
    }

    public function updateEvent(Request $request): void
    {
        if (! $this->validateCsrf($request, 'events')) {
            return;
        }

        $id = (int) ($request->input('id', '0') ?? 0);

        if ($id <= 0) {
            Session::flash('error', 'Не удалось определить событие для обновления.');
            Response::redirect('/admin/dashboard?section=events');
        }

        $title = $request->input('title', '') ?? '';
        $announce = $request->input('announce', '') ?? '';
        $description = $request->input('description', '') ?? '';
        $eventAt = $request->input('event_at', '') ?? '';

        if ($title === '' || $announce === '' || $description === '' || $eventAt === '') {
            Session::flash('error', 'Для обновления события заполните обязательные поля.');
            Response::redirect('/admin/dashboard?section=events');
        }

        $repository = new AdminContent(Database::connection($this->config));
        $coverPath = $this->resolveImagePath('event_cover', $request->input('existing_image'), $request->input('current_image'));

        $repository->updateEvent($id, [
            ':title' => $title,
            ':announce' => $announce,
            ':description' => $description,
            ':cover_image_path' => $coverPath,
            ':event_at' => $eventAt,
            ':updated_at' => date(DATE_ATOM),
        ]);

        Session::flash('success', 'Событие обновлено.');
        Response::redirect('/admin/dashboard?section=events');
    }

    public function deleteEvent(Request $request): void
    {
        if (! $this->validateCsrf($request, 'events')) {
            return;
        }

        $id = (int) ($request->input('id', '0') ?? 0);

        if ($id <= 0) {
            Session::flash('error', 'Не удалось удалить событие.');
            Response::redirect('/admin/dashboard?section=events');
        }

        $repository = new AdminContent(Database::connection($this->config));
        $repository->deleteEvent($id);

        Session::flash('success', 'Событие удалено.');
        Response::redirect('/admin/dashboard?section=events');
    }

    public function createPromotion(Request $request): void
    {
        if (! $this->validateCsrf($request, 'promotions')) {
            return;
        }

        $title = $request->input('title', '') ?? '';
        $announce = $request->input('announce', '') ?? '';
        $description = $request->input('description', '') ?? '';

        if ($title === '' || $announce === '' || $description === '') {
            Session::flash('error', 'Для акции заполните название, анонс и описание.');
            Response::redirect('/admin/dashboard?section=promotions');
        }

        $repository = new AdminContent(Database::connection($this->config));
        $coverPath = $this->resolveImagePath('promotion_cover', $request->input('existing_image'));
        $now = date(DATE_ATOM);

        $repository->createPromotion([
            ':title' => $title,
            ':announce' => $announce,
            ':description' => $description,
            ':cover_image_path' => $coverPath,
            ':created_at' => $now,
            ':updated_at' => $now,
        ]);

        Session::flash('success', 'Акция добавлена.');
        Response::redirect('/admin/dashboard?section=promotions');
    }

    public function updatePromotion(Request $request): void
    {
        if (! $this->validateCsrf($request, 'promotions')) {
            return;
        }

        $id = (int) ($request->input('id', '0') ?? 0);

        if ($id <= 0) {
            Session::flash('error', 'Не удалось определить акцию для обновления.');
            Response::redirect('/admin/dashboard?section=promotions');
        }

        $title = $request->input('title', '') ?? '';
        $announce = $request->input('announce', '') ?? '';
        $description = $request->input('description', '') ?? '';

        if ($title === '' || $announce === '' || $description === '') {
            Session::flash('error', 'Для обновления акции заполните обязательные поля.');
            Response::redirect('/admin/dashboard?section=promotions');
        }

        $repository = new AdminContent(Database::connection($this->config));
        $coverPath = $this->resolveImagePath('promotion_cover', $request->input('existing_image'), $request->input('current_image'));

        $repository->updatePromotion($id, [
            ':title' => $title,
            ':announce' => $announce,
            ':description' => $description,
            ':cover_image_path' => $coverPath,
            ':updated_at' => date(DATE_ATOM),
        ]);

        Session::flash('success', 'Акция обновлена.');
        Response::redirect('/admin/dashboard?section=promotions');
    }

    public function deletePromotion(Request $request): void
    {
        if (! $this->validateCsrf($request, 'promotions')) {
            return;
        }

        $id = (int) ($request->input('id', '0') ?? 0);

        if ($id <= 0) {
            Session::flash('error', 'Не удалось удалить акцию.');
            Response::redirect('/admin/dashboard?section=promotions');
        }

        $repository = new AdminContent(Database::connection($this->config));
        $repository->deletePromotion($id);

        Session::flash('success', 'Акция удалена.');
        Response::redirect('/admin/dashboard?section=promotions');
    }

    public function createNews(Request $request): void
    {
        if (! $this->validateCsrf($request, 'news')) {
            return;
        }

        $title = $request->input('title', '') ?? '';
        $content = $request->input('content', '') ?? '';

        if ($title === '' || $content === '') {
            Session::flash('error', 'Для новости заполните название и текст.');
            Response::redirect('/admin/dashboard?section=news');
        }

        $repository = new AdminContent(Database::connection($this->config));
        $coverPath = $this->resolveImagePath('news_cover', $request->input('existing_image'));
        $now = date(DATE_ATOM);

        $repository->createNews([
            ':title' => $title,
            ':content' => $content,
            ':cover_image_path' => $coverPath,
            ':created_at' => $now,
            ':updated_at' => $now,
        ]);

        Session::flash('success', 'Новость добавлена.');
        Response::redirect('/admin/dashboard?section=news');
    }

    public function updateNews(Request $request): void
    {
        if (! $this->validateCsrf($request, 'news')) {
            return;
        }

        $id = (int) ($request->input('id', '0') ?? 0);

        if ($id <= 0) {
            Session::flash('error', 'Не удалось определить новость для обновления.');
            Response::redirect('/admin/dashboard?section=news');
        }

        $title = $request->input('title', '') ?? '';
        $content = $request->input('content', '') ?? '';

        if ($title === '' || $content === '') {
            Session::flash('error', 'Для обновления новости заполните обязательные поля.');
            Response::redirect('/admin/dashboard?section=news');
        }

        $repository = new AdminContent(Database::connection($this->config));
        $coverPath = $this->resolveImagePath('news_cover', $request->input('existing_image'), $request->input('current_image'));

        $repository->updateNews($id, [
            ':title' => $title,
            ':content' => $content,
            ':cover_image_path' => $coverPath,
            ':updated_at' => date(DATE_ATOM),
        ]);

        Session::flash('success', 'Новость обновлена.');
        Response::redirect('/admin/dashboard?section=news');
    }

    public function deleteNews(Request $request): void
    {
        if (! $this->validateCsrf($request, 'news')) {
            return;
        }

        $id = (int) ($request->input('id', '0') ?? 0);

        if ($id <= 0) {
            Session::flash('error', 'Не удалось удалить новость.');
            Response::redirect('/admin/dashboard?section=news');
        }

        $repository = new AdminContent(Database::connection($this->config));
        $repository->deleteNews($id);

        Session::flash('success', 'Новость удалена.');
        Response::redirect('/admin/dashboard?section=news');
    }

    private function validateCsrf(Request $request, string $section): bool
    {
        if (Csrf::validate($request->input('_token'))) {
            return true;
        }

        http_response_code(419);
        Session::flash('error', 'Сессия формы истекла. Попробуйте ещё раз.');
        Response::redirect('/admin/dashboard?section=' . $section);

        return false;
    }

    private function normalizeSection(?string $section): string
    {
        $allowed = ['taps', 'events', 'promotions', 'news'];

        return in_array($section, $allowed, true) ? $section : 'taps';
    }

    private function toDecimal(?string $value): float
    {
        if (! is_string($value)) {
            return 0.0;
        }

        $normalized = str_replace(',', '.', trim($value));

        if (! is_numeric($normalized)) {
            return 0.0;
        }

        return round((float) $normalized, 2);
    }

    private function resolveImagePath(string $fileInputKey, ?string $existingPath = null, ?string $fallback = null): ?string
    {
        $selectedPath = is_string($existingPath) && $existingPath !== '' ? $existingPath : null;

        if (! isset($_FILES[$fileInputKey]) || ! is_array($_FILES[$fileInputKey])) {
            return $selectedPath ?? $fallback;
        }

        $file = $_FILES[$fileInputKey];

        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return $selectedPath ?? $fallback;
        }

        if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
            return $selectedPath ?? $fallback;
        }

        $tempName = is_string($file['tmp_name'] ?? null) ? $file['tmp_name'] : null;

        if ($tempName === null || ! is_uploaded_file($tempName)) {
            return $selectedPath ?? $fallback;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = $finfo !== false ? finfo_file($finfo, $tempName) : null;

        if ($finfo !== false) {
            finfo_close($finfo);
        }

        $allowed = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            'image/gif' => 'gif',
        ];

        if (! is_string($mimeType) || ! isset($allowed[$mimeType])) {
            Session::flash('error', 'Допустимы только изображения JPG, PNG, WEBP или GIF.');
            return $selectedPath ?? $fallback;
        }

        $uploadDir = dirname(__DIR__, 2) . '/public/uploads';

        if (! is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = 'img_' . date('Ymd_His') . '_' . bin2hex(random_bytes(6)) . '.' . $allowed[$mimeType];
        $absolutePath = $uploadDir . '/' . $fileName;

        if (! move_uploaded_file($tempName, $absolutePath)) {
            Session::flash('error', 'Не удалось сохранить загруженное изображение.');
            return $selectedPath ?? $fallback;
        }

        $relativePath = '/uploads/' . $fileName;

        $repository = new AdminContent(Database::connection($this->config));
        $repository->createMediaAsset([
            ':file_name' => $fileName,
            ':original_name' => is_string($file['name'] ?? null) ? (string) $file['name'] : $fileName,
            ':relative_path' => $relativePath,
            ':mime_type' => $mimeType,
            ':size_bytes' => (int) ($file['size'] ?? 0),
            ':created_at' => date(DATE_ATOM),
        ]);

        return $relativePath;
    }
}
