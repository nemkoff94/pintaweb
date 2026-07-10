<?php

declare(strict_types=1);

/** @var string $section */
$section = $section ?? 'taps';
$csrfToken = is_string($csrfToken ?? null) ? $csrfToken : '';
$flashSuccess = is_string($flashSuccess ?? null) ? $flashSuccess : null;
$flashError = is_string($flashError ?? null) ? $flashError : null;
$user = $_SESSION['auth_user'] ?? null;

$sections = [
    'taps' => ['label' => 'На кранах', 'icon' => 'beer-mug-empty'],
    'events' => ['label' => 'События', 'icon' => 'calendar-days'],
    'promotions' => ['label' => 'Акции', 'icon' => 'tags'],
    'news' => ['label' => 'Новости', 'icon' => 'newspaper'],
];

$sectionTitles = [
    'taps' => 'Управление сортами на кранах',
    'events' => 'Управление событиями',
    'promotions' => 'Управление акциями',
    'news' => 'Управление новостями',
];

$sectionDescriptions = [
    'taps' => 'Добавляйте новые сорта, меняйте их статус и быстро редактируйте цены.',
    'events' => 'Ведите календарь мероприятий и публикуйте анонсы в несколько кликов.',
    'promotions' => 'Обновляйте спецпредложения и сохраняйте единый стиль карточек.',
    'news' => 'Публикуйте новости с оформленным текстом и обложками из медиатеки.',
];

$shorten = static function (string $text, int $limit = 120): string {
    $clean = trim(strip_tags($text));

    if ($clean === '') {
        return '';
    }

    if (function_exists('mb_strlen') && function_exists('mb_substr')) {
        return mb_strlen($clean) > $limit ? mb_substr($clean, 0, $limit) . '...' : $clean;
    }

    return strlen($clean) > $limit ? substr($clean, 0, $limit) . '...' : $clean;
};
?>
<div class="admin-root">
    <aside class="admin-sidebar">
        <div class="admin-brand">
            <div class="admin-logo">P</div>
            <div>
                <div class="admin-title"><?= htmlspecialchars($config['site_name'], ENT_QUOTES, 'UTF-8'); ?> Admin</div>
                <div class="admin-subtitle">Управление контентом</div>
            </div>
        </div>

        <nav class="admin-nav">
            <?php foreach ($sections as $key => $item): ?>
                <a
                    class="admin-nav-link <?= $section === $key ? 'is-active' : ''; ?>"
                    href="/admin/dashboard?section=<?= urlencode($key); ?>"
                >
                    <i class="fa-solid fa-<?= htmlspecialchars($item['icon'], ENT_QUOTES, 'UTF-8'); ?>"></i>
                    <?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8'); ?>
                </a>
            <?php endforeach; ?>
        </nav>

        <div class="admin-side-actions">
            <a class="admin-side-btn" href="/">На сайт</a>
            <form action="/admin/logout" method="post">
                <input type="hidden" name="_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                <button type="submit" class="admin-side-btn">Выйти</button>
            </form>
        </div>

        <?php if (is_array($user)): ?>
            <p class="admin-subtitle" style="margin-top: 18px;">
                Авторизован: <?= htmlspecialchars((string) ($user['login'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>
            </p>
        <?php endif; ?>
    </aside>

    <div class="admin-main">
        <div class="mobile-nav">
            <?php foreach ($sections as $key => $item): ?>
                <a class="admin-nav-link <?= $section === $key ? 'is-active' : ''; ?>" href="/admin/dashboard?section=<?= urlencode($key); ?>">
                    <i class="fa-solid fa-<?= htmlspecialchars($item['icon'], ENT_QUOTES, 'UTF-8'); ?>"></i>
                    <?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8'); ?>
                </a>
            <?php endforeach; ?>
        </div>

        <header class="admin-top">
            <div>
                <h1 class="admin-heading"><?= htmlspecialchars($sectionTitles[$section] ?? 'Админка', ENT_QUOTES, 'UTF-8'); ?></h1>
                <p class="admin-muted"><?= htmlspecialchars($sectionDescriptions[$section] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
            <span class="admin-pill">Современный режим управления</span>
        </header>

        <?php if ($flashSuccess !== null): ?>
            <div class="admin-flash success"><?= htmlspecialchars($flashSuccess, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>

        <?php if ($flashError !== null): ?>
            <div class="admin-flash error"><?= htmlspecialchars($flashError, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>

        <?php if ($section === 'taps'): ?>
            <section class="admin-card" style="margin-bottom: 16px;">
                <div class="admin-card-header admin-card-header-row">
                    <h2 class="admin-card-title">Список сортов на кранах</h2>
                    <button type="button" class="admin-btn primary" data-form-toggle="tap-create-form">
                        <i class="fa-solid fa-plus"></i>
                        Добавить сорт
                    </button>
                </div>
                <div class="admin-card-body admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                        <tr>
                            <th>Фото</th>
                            <th>Название</th>
                            <th>Стиль</th>
                            <th>ABV</th>
                            <th>Цены</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($taps as $tap): ?>
                            <tr>
                                <td>
                                    <div class="admin-thumb">
                                        <?php if (is_string($tap['image_path'] ?? null) && $tap['image_path'] !== ''): ?>
                                            <img src="<?= htmlspecialchars((string) $tap['image_path'], ENT_QUOTES, 'UTF-8'); ?>" alt="">
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars((string) $tap['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?= htmlspecialchars((string) $tap['style'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?= htmlspecialchars((string) $tap['abv'], ENT_QUOTES, 'UTF-8'); ?>%</td>
                                <td>
                                    Магазин: <?= htmlspecialchars((string) $tap['price_store_liter'], ENT_QUOTES, 'UTF-8'); ?> руб/л<br>
                                    Бар: <?= htmlspecialchars((string) $tap['price_bar_half'], ENT_QUOTES, 'UTF-8'); ?> руб/0.5
                                </td>
                                <td>
                                    <span class="status-pill <?= ((int) $tap['is_on_tap']) === 1 ? 'on' : 'off'; ?>">
                                        <?= ((int) $tap['is_on_tap']) === 1 ? 'Сейчас на кране' : 'Не на кране'; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="inline-actions">
                                        <form class="toggle-form" action="/admin/taps/toggle" method="post">
                                            <input type="hidden" name="_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                                            <input type="hidden" name="id" value="<?= (int) $tap['id']; ?>">
                                            <input type="hidden" name="enabled" value="<?= ((int) $tap['is_on_tap']) === 1 ? '0' : '1'; ?>">
                                            <button class="admin-btn ghost" type="submit">
                                                <i class="fa-solid fa-toggle-<?= ((int) $tap['is_on_tap']) === 1 ? 'on' : 'off'; ?>"></i>
                                                Переключить
                                            </button>
                                        </form>

                                        <button
                                            class="admin-btn danger"
                                            data-modal-target="delete-modal"
                                            data-modal-toggle="delete-modal"
                                            data-delete-form="tap-delete-<?= (int) $tap['id']; ?>"
                                            data-delete-title="Удалить сорт <?= htmlspecialchars((string) $tap['name'], ENT_QUOTES, 'UTF-8'); ?>?"
                                            type="button"
                                        >
                                            <i class="fa-solid fa-trash"></i>
                                            Удалить
                                        </button>
                                    </div>

                                    <details style="margin-top: 10px;">
                                        <summary style="cursor: pointer;">Редактировать</summary>
                                        <form action="/admin/taps/update" method="post" enctype="multipart/form-data" class="admin-grid" style="margin-top: 10px;">
                                            <input type="hidden" name="_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                                            <input type="hidden" name="id" value="<?= (int) $tap['id']; ?>">
                                            <input type="hidden" name="current_image" value="<?= htmlspecialchars((string) ($tap['image_path'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">

                                            <input class="admin-input" type="text" name="name" value="<?= htmlspecialchars((string) $tap['name'], ENT_QUOTES, 'UTF-8'); ?>" required>
                                            <input class="admin-input" type="text" name="style" value="<?= htmlspecialchars((string) $tap['style'], ENT_QUOTES, 'UTF-8'); ?>" required>
                                            <input class="admin-input" type="text" name="abv" value="<?= htmlspecialchars((string) $tap['abv'], ENT_QUOTES, 'UTF-8'); ?>" required>
                                            <input class="admin-input" type="text" name="price_store_liter" value="<?= htmlspecialchars((string) $tap['price_store_liter'], ENT_QUOTES, 'UTF-8'); ?>" required>
                                            <input class="admin-input" type="text" name="price_bar_half" value="<?= htmlspecialchars((string) $tap['price_bar_half'], ENT_QUOTES, 'UTF-8'); ?>" required>
                                            <input class="admin-input" type="file" name="tap_image" accept="image/*">
                                            <select class="admin-select" name="existing_image">
                                                <option value="">Оставить текущее</option>
                                                <?php foreach ($mediaAssets as $asset): ?>
                                                    <option value="<?= htmlspecialchars((string) $asset['relative_path'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars((string) $asset['original_name'], ENT_QUOTES, 'UTF-8'); ?></option>
                                                <?php endforeach; ?>
                                            </select>

                                            <button class="admin-btn ghost" type="submit">Сохранить</button>
                                        </form>
                                    </details>

                                    <form id="tap-delete-<?= (int) $tap['id']; ?>" action="/admin/taps/delete" method="post" style="display:none;">
                                        <input type="hidden" name="_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                                        <input type="hidden" name="id" value="<?= (int) $tap['id']; ?>">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (! is_array($taps) || $taps === []): ?>
                            <tr>
                                <td colspan="7" class="admin-muted">Список пока пуст. Добавьте первый сорт.</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="tap-create-form" class="admin-card admin-collapsible" style="margin-bottom: 16px;" hidden>
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Добавить новый сорт</h2>
                </div>
                <div class="admin-card-body">
                    <form action="/admin/taps/create" method="post" enctype="multipart/form-data" class="admin-grid">
                        <input type="hidden" name="_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">

                        <div class="admin-grid two">
                            <label class="admin-field">
                                <span class="admin-label">Название</span>
                                <input class="admin-input" type="text" name="name" required>
                            </label>
                            <label class="admin-field">
                                <span class="admin-label">Стиль</span>
                                <input class="admin-input" type="text" name="style" required>
                            </label>
                        </div>

                        <div class="admin-grid two">
                            <label class="admin-field">
                                <span class="admin-label">Процент алкоголя</span>
                                <input class="admin-input" type="text" name="abv" placeholder="5.4" required>
                            </label>
                            <label class="admin-field">
                                <span class="admin-label">Стоимость за литр в магазине</span>
                                <input class="admin-input" type="text" name="price_store_liter" placeholder="420" required>
                            </label>
                        </div>

                        <div class="admin-grid two">
                            <label class="admin-field">
                                <span class="admin-label">Стоимость за бокал в баре (0,5)</span>
                                <input class="admin-input" type="text" name="price_bar_half" placeholder="230" required>
                            </label>
                            <label class="admin-field">
                                <span class="admin-label">Загрузить фото</span>
                                <input class="admin-input" type="file" name="tap_image" accept="image/*">
                            </label>
                        </div>

                        <label class="admin-field">
                            <span class="admin-label">Или выбрать из загруженных</span>
                            <select class="admin-select" name="existing_image">
                                <option value="">Не выбрано</option>
                                <?php foreach ($mediaAssets as $asset): ?>
                                    <option value="<?= htmlspecialchars((string) $asset['relative_path'], ENT_QUOTES, 'UTF-8'); ?>">
                                        <?= htmlspecialchars((string) $asset['original_name'], ENT_QUOTES, 'UTF-8'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </label>

                        <div>
                            <button type="submit" class="admin-btn primary">
                                <i class="fa-solid fa-plus"></i>
                                Добавить сорт
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        <?php endif; ?>

        <?php if ($section === 'events'): ?>
            <section class="admin-card" style="margin-bottom: 16px;">
                <div class="admin-card-header admin-card-header-row">
                    <h2 class="admin-card-title">Текущие события</h2>
                    <button type="button" class="admin-btn primary" data-form-toggle="event-create-form">
                        <i class="fa-solid fa-plus"></i>
                        Добавить событие
                    </button>
                </div>
                <div class="admin-card-body admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                        <tr>
                            <th>Обложка</th>
                            <th>Название</th>
                            <th>Анонс</th>
                            <th>Дата</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($events as $event): ?>
                            <tr>
                                <td>
                                    <div class="admin-thumb">
                                        <?php if (is_string($event['cover_image_path'] ?? null) && $event['cover_image_path'] !== ''): ?>
                                            <img src="<?= htmlspecialchars((string) $event['cover_image_path'], ENT_QUOTES, 'UTF-8'); ?>" alt="">
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars((string) $event['title'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?= htmlspecialchars((string) $event['announce'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?= htmlspecialchars((string) $event['event_at'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <details>
                                        <summary style="cursor: pointer;">Редактировать</summary>
                                        <form action="/admin/events/update" method="post" enctype="multipart/form-data" class="admin-grid" style="margin-top: 10px;">
                                            <input type="hidden" name="_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                                            <input type="hidden" name="id" value="<?= (int) $event['id']; ?>">
                                            <input type="hidden" name="current_image" value="<?= htmlspecialchars((string) ($event['cover_image_path'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">

                                            <input class="admin-input" type="text" name="title" value="<?= htmlspecialchars((string) $event['title'], ENT_QUOTES, 'UTF-8'); ?>" required>
                                            <textarea class="admin-textarea" name="announce" required><?= htmlspecialchars((string) $event['announce'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                                            <textarea class="admin-textarea js-richtext" name="description" required><?= htmlspecialchars((string) $event['description'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                                            <input class="admin-input" type="text" name="event_at" value="<?= htmlspecialchars((string) $event['event_at'], ENT_QUOTES, 'UTF-8'); ?>" required>
                                            <input class="admin-input" type="file" name="event_cover" accept="image/*">
                                            <select class="admin-select" name="existing_image">
                                                <option value="">Оставить текущую</option>
                                                <?php foreach ($mediaAssets as $asset): ?>
                                                    <option value="<?= htmlspecialchars((string) $asset['relative_path'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars((string) $asset['original_name'], ENT_QUOTES, 'UTF-8'); ?></option>
                                                <?php endforeach; ?>
                                            </select>

                                            <button class="admin-btn ghost" type="submit">Сохранить</button>
                                        </form>
                                    </details>

                                    <button
                                        class="admin-btn danger"
                                        data-modal-target="delete-modal"
                                        data-modal-toggle="delete-modal"
                                        data-delete-form="event-delete-<?= (int) $event['id']; ?>"
                                        data-delete-title="Удалить событие <?= htmlspecialchars((string) $event['title'], ENT_QUOTES, 'UTF-8'); ?>?"
                                        type="button"
                                        style="margin-top: 8px;"
                                    >
                                        <i class="fa-solid fa-trash"></i>
                                        Удалить
                                    </button>

                                    <form id="event-delete-<?= (int) $event['id']; ?>" action="/admin/events/delete" method="post" style="display:none;">
                                        <input type="hidden" name="_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                                        <input type="hidden" name="id" value="<?= (int) $event['id']; ?>">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (! is_array($events) || $events === []): ?>
                            <tr>
                                <td colspan="5" class="admin-muted">События пока не добавлены.</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="event-create-form" class="admin-card admin-collapsible" style="margin-bottom: 16px;" hidden>
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Добавить новое событие</h2>
                </div>
                <div class="admin-card-body">
                    <form action="/admin/events/create" method="post" enctype="multipart/form-data" class="admin-grid">
                        <input type="hidden" name="_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">

                        <label class="admin-field">
                            <span class="admin-label">Название</span>
                            <input class="admin-input" type="text" name="title" required>
                        </label>

                        <label class="admin-field">
                            <span class="admin-label">Анонс</span>
                            <textarea class="admin-textarea" name="announce" required></textarea>
                        </label>

                        <label class="admin-field">
                            <span class="admin-label">Описание</span>
                            <textarea class="admin-textarea js-richtext admin-editor" name="description" required></textarea>
                        </label>

                        <div class="admin-grid two">
                            <label class="admin-field">
                                <span class="admin-label">Обложка (загрузить)</span>
                                <input class="admin-input" type="file" name="event_cover" accept="image/*">
                            </label>
                            <label class="admin-field">
                                <span class="admin-label">Дата и время</span>
                                <input class="admin-input" data-event-datepicker type="text" name="event_at" placeholder="2026-07-10 20:00" required>
                            </label>
                        </div>

                        <label class="admin-field">
                            <span class="admin-label">Или выбрать обложку из загруженных</span>
                            <select class="admin-select" name="existing_image">
                                <option value="">Не выбрано</option>
                                <?php foreach ($mediaAssets as $asset): ?>
                                    <option value="<?= htmlspecialchars((string) $asset['relative_path'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars((string) $asset['original_name'], ENT_QUOTES, 'UTF-8'); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>

                        <div>
                            <button class="admin-btn primary" type="submit">
                                <i class="fa-solid fa-calendar-plus"></i>
                                Добавить событие
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        <?php endif; ?>

        <?php if ($section === 'promotions'): ?>
            <section class="admin-card" style="margin-bottom: 16px;">
                <div class="admin-card-header admin-card-header-row">
                    <h2 class="admin-card-title">Текущие акции</h2>
                    <button type="button" class="admin-btn primary" data-form-toggle="promotion-create-form">
                        <i class="fa-solid fa-plus"></i>
                        Добавить акцию
                    </button>
                </div>
                <div class="admin-card-body admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                        <tr>
                            <th>Обложка</th>
                            <th>Название</th>
                            <th>Анонс</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($promotions as $promotion): ?>
                            <tr>
                                <td>
                                    <div class="admin-thumb">
                                        <?php if (is_string($promotion['cover_image_path'] ?? null) && $promotion['cover_image_path'] !== ''): ?>
                                            <img src="<?= htmlspecialchars((string) $promotion['cover_image_path'], ENT_QUOTES, 'UTF-8'); ?>" alt="">
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars((string) $promotion['title'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?= htmlspecialchars((string) $promotion['announce'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <details>
                                        <summary style="cursor: pointer;">Редактировать</summary>
                                        <form action="/admin/promotions/update" method="post" enctype="multipart/form-data" class="admin-grid" style="margin-top: 10px;">
                                            <input type="hidden" name="_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                                            <input type="hidden" name="id" value="<?= (int) $promotion['id']; ?>">
                                            <input type="hidden" name="current_image" value="<?= htmlspecialchars((string) ($promotion['cover_image_path'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">

                                            <input class="admin-input" type="text" name="title" value="<?= htmlspecialchars((string) $promotion['title'], ENT_QUOTES, 'UTF-8'); ?>" required>
                                            <textarea class="admin-textarea" name="announce" required><?= htmlspecialchars((string) $promotion['announce'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                                            <textarea class="admin-textarea js-richtext" name="description" required><?= htmlspecialchars((string) $promotion['description'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                                            <input class="admin-input" type="file" name="promotion_cover" accept="image/*">
                                            <select class="admin-select" name="existing_image">
                                                <option value="">Оставить текущую</option>
                                                <?php foreach ($mediaAssets as $asset): ?>
                                                    <option value="<?= htmlspecialchars((string) $asset['relative_path'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars((string) $asset['original_name'], ENT_QUOTES, 'UTF-8'); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <button class="admin-btn ghost" type="submit">Сохранить</button>
                                        </form>
                                    </details>

                                    <button
                                        class="admin-btn danger"
                                        data-modal-target="delete-modal"
                                        data-modal-toggle="delete-modal"
                                        data-delete-form="promotion-delete-<?= (int) $promotion['id']; ?>"
                                        data-delete-title="Удалить акцию <?= htmlspecialchars((string) $promotion['title'], ENT_QUOTES, 'UTF-8'); ?>?"
                                        type="button"
                                        style="margin-top: 8px;"
                                    >
                                        <i class="fa-solid fa-trash"></i>
                                        Удалить
                                    </button>

                                    <form id="promotion-delete-<?= (int) $promotion['id']; ?>" action="/admin/promotions/delete" method="post" style="display:none;">
                                        <input type="hidden" name="_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                                        <input type="hidden" name="id" value="<?= (int) $promotion['id']; ?>">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (! is_array($promotions) || $promotions === []): ?>
                            <tr>
                                <td colspan="4" class="admin-muted">Акции пока не добавлены.</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="promotion-create-form" class="admin-card admin-collapsible" style="margin-bottom: 16px;" hidden>
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Добавить новую акцию</h2>
                </div>
                <div class="admin-card-body">
                    <form action="/admin/promotions/create" method="post" enctype="multipart/form-data" class="admin-grid">
                        <input type="hidden" name="_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">

                        <label class="admin-field">
                            <span class="admin-label">Название</span>
                            <input class="admin-input" type="text" name="title" required>
                        </label>

                        <label class="admin-field">
                            <span class="admin-label">Анонс</span>
                            <textarea class="admin-textarea" name="announce" required></textarea>
                        </label>

                        <label class="admin-field">
                            <span class="admin-label">Описание</span>
                            <textarea class="admin-textarea js-richtext" name="description" required></textarea>
                        </label>

                        <div class="admin-grid two">
                            <label class="admin-field">
                                <span class="admin-label">Обложка (загрузить)</span>
                                <input class="admin-input" type="file" name="promotion_cover" accept="image/*">
                            </label>
                            <label class="admin-field">
                                <span class="admin-label">Или выбрать из загруженных</span>
                                <select class="admin-select" name="existing_image">
                                    <option value="">Не выбрано</option>
                                    <?php foreach ($mediaAssets as $asset): ?>
                                        <option value="<?= htmlspecialchars((string) $asset['relative_path'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars((string) $asset['original_name'], ENT_QUOTES, 'UTF-8'); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </label>
                        </div>

                        <div>
                            <button class="admin-btn primary" type="submit">
                                <i class="fa-solid fa-tags"></i>
                                Добавить акцию
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        <?php endif; ?>

        <?php if ($section === 'news'): ?>
            <section class="admin-card" style="margin-bottom: 16px;">
                <div class="admin-card-header admin-card-header-row">
                    <h2 class="admin-card-title">Список новостей</h2>
                    <button type="button" class="admin-btn primary" data-form-toggle="news-create-form">
                        <i class="fa-solid fa-plus"></i>
                        Добавить новость
                    </button>
                </div>
                <div class="admin-card-body admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                        <tr>
                            <th>Обложка</th>
                            <th>Название</th>
                            <th>Текст</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($news as $item): ?>
                            <tr>
                                <td>
                                    <div class="admin-thumb">
                                        <?php if (is_string($item['cover_image_path'] ?? null) && $item['cover_image_path'] !== ''): ?>
                                            <img src="<?= htmlspecialchars((string) $item['cover_image_path'], ENT_QUOTES, 'UTF-8'); ?>" alt="">
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars((string) $item['title'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?= htmlspecialchars($shorten((string) $item['content']), ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <details>
                                        <summary style="cursor: pointer;">Редактировать</summary>
                                        <form action="/admin/news/update" method="post" enctype="multipart/form-data" class="admin-grid" style="margin-top: 10px;">
                                            <input type="hidden" name="_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                                            <input type="hidden" name="id" value="<?= (int) $item['id']; ?>">
                                            <input type="hidden" name="current_image" value="<?= htmlspecialchars((string) ($item['cover_image_path'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">

                                            <input class="admin-input" type="text" name="title" value="<?= htmlspecialchars((string) $item['title'], ENT_QUOTES, 'UTF-8'); ?>" required>
                                            <textarea class="admin-textarea js-richtext" name="content" required><?= htmlspecialchars((string) $item['content'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                                            <input class="admin-input" type="file" name="news_cover" accept="image/*">
                                            <select class="admin-select" name="existing_image">
                                                <option value="">Оставить текущую</option>
                                                <?php foreach ($mediaAssets as $asset): ?>
                                                    <option value="<?= htmlspecialchars((string) $asset['relative_path'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars((string) $asset['original_name'], ENT_QUOTES, 'UTF-8'); ?></option>
                                                <?php endforeach; ?>
                                            </select>

                                            <button class="admin-btn ghost" type="submit">Сохранить</button>
                                        </form>
                                    </details>

                                    <button
                                        class="admin-btn danger"
                                        data-modal-target="delete-modal"
                                        data-modal-toggle="delete-modal"
                                        data-delete-form="news-delete-<?= (int) $item['id']; ?>"
                                        data-delete-title="Удалить новость <?= htmlspecialchars((string) $item['title'], ENT_QUOTES, 'UTF-8'); ?>?"
                                        type="button"
                                        style="margin-top: 8px;"
                                    >
                                        <i class="fa-solid fa-trash"></i>
                                        Удалить
                                    </button>

                                    <form id="news-delete-<?= (int) $item['id']; ?>" action="/admin/news/delete" method="post" style="display:none;">
                                        <input type="hidden" name="_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                                        <input type="hidden" name="id" value="<?= (int) $item['id']; ?>">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (! is_array($news) || $news === []): ?>
                            <tr>
                                <td colspan="4" class="admin-muted">Новости пока не добавлены.</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="news-create-form" class="admin-card admin-collapsible" style="margin-bottom: 16px;" hidden>
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Добавить новость</h2>
                </div>
                <div class="admin-card-body">
                    <form action="/admin/news/create" method="post" enctype="multipart/form-data" class="admin-grid">
                        <input type="hidden" name="_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">

                        <label class="admin-field">
                            <span class="admin-label">Название</span>
                            <input class="admin-input" type="text" name="title" required>
                        </label>

                        <label class="admin-field">
                            <span class="admin-label">Текст новости</span>
                            <textarea class="admin-textarea js-richtext" name="content" required></textarea>
                        </label>

                        <div class="admin-grid two">
                            <label class="admin-field">
                                <span class="admin-label">Обложка (загрузить)</span>
                                <input class="admin-input" type="file" name="news_cover" accept="image/*">
                            </label>
                            <label class="admin-field">
                                <span class="admin-label">Или выбрать из загруженных</span>
                                <select class="admin-select" name="existing_image">
                                    <option value="">Не выбрано</option>
                                    <?php foreach ($mediaAssets as $asset): ?>
                                        <option value="<?= htmlspecialchars((string) $asset['relative_path'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars((string) $asset['original_name'], ENT_QUOTES, 'UTF-8'); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </label>
                        </div>

                        <div>
                            <button class="admin-btn primary" type="submit">
                                <i class="fa-solid fa-plus"></i>
                                Добавить новость
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        <?php endif; ?>
    </div>
</div>

<div id="delete-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex h-full w-full items-center justify-center bg-black/45 p-4">
    <div class="relative w-full max-w-md rounded-xl bg-white p-6 shadow-2xl">
        <button type="button" class="absolute end-3 top-3 text-gray-400 hover:text-gray-900" data-modal-hide="delete-modal">
            <span class="sr-only">Закрыть</span>
            <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
        <div class="text-center">
            <i class="fa-solid fa-triangle-exclamation" style="font-size: 34px; color: #c92f2f;"></i>
            <h3 id="delete-modal-title" class="mb-2 mt-4 text-lg font-semibold text-gray-900">Подтвердите удаление</h3>
            <p class="mb-5 text-sm text-gray-500">Это действие нельзя отменить.</p>
            <div class="inline-actions" style="justify-content: center;">
                <button data-modal-hide="delete-modal" type="button" class="admin-btn ghost">Отмена</button>
                <button id="delete-modal-confirm" type="button" class="admin-btn danger">Удалить</button>
            </div>
        </div>
    </div>
</div>

<script>
    (() => {
        let activeFormId = null;
        const titleNode = document.getElementById('delete-modal-title');
        const confirmButton = document.getElementById('delete-modal-confirm');

        document.querySelectorAll('[data-delete-form]').forEach((button) => {
            button.addEventListener('click', () => {
                activeFormId = button.getAttribute('data-delete-form');
                if (titleNode) {
                    titleNode.textContent = button.getAttribute('data-delete-title') || 'Подтвердите удаление';
                }
            });
        });

        if (confirmButton) {
            confirmButton.addEventListener('click', () => {
                if (!activeFormId) {
                    return;
                }

                const form = document.getElementById(activeFormId);
                if (form) {
                    form.submit();
                }
            });
        }
    })();
</script>
