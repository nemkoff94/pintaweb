<?php

declare(strict_types=1);

$resolveImage = static function (?string $path, string $fallback): string {
    $path = trim((string) $path);

    return $path !== '' ? $path : $fallback;
};

$formatPrice = static function ($value): string {
    if ($value === null || $value === '' || (float) $value <= 0) {
        return 'По запросу';
    }

    return number_format((float) $value, 0, ',', ' ') . ' ₽';
};

$formatPercent = static function ($value): string {
    if ($value === null || $value === '') {
        return '—';
    }

    $formatted = number_format((float) $value, 1, ',', ' ');
    $formatted = rtrim(rtrim($formatted, '0'), ',');

    return $formatted . '%';
};

$formatDate = static function (?string $value): string {
    $value = trim((string) $value);

    if ($value === '') {
        return '';
    }

    $timestamp = strtotime($value);

    return $timestamp ? date('d.m.Y', $timestamp) : $value;
};

$onTaps = [];
foreach (($taps ?? []) as $tap) {
    if ((int) ($tap['is_on_tap'] ?? 0) === 1) {
        $onTaps[] = $tap;
    }
}

$featuredPromotions = array_slice($promotions ?? [], 0, 3);
$featuredEvents = array_slice($events ?? [], 0, 3);
$featuredNews = array_slice($news ?? [], 0, 3);
?>
<section class="home-page-shell">
    <section class="home-hero">
        <div class="container home-hero__grid">
            <div class="home-hero__copy">
                <div class="home-hero__eyebrow">Паб, ресторан и пространство для вечеров с характером</div>
                <h1 class="home-hero__title">Пинта — место, где вкус, сервис и атмосфера собраны как в лучших отелях и ресторанах.</h1>
                <p class="home-hero__lead">Сдержанная эстетика, внимательный сервис, свежие напитки на кранах и комфортная посадка для встреч, ужинов и спокойных длинных вечеров.</p>

                <div class="home-hero__actions">
                    <a href="#contacts" class="btn btn--primary">Забронировать стол</a>
                    <a href="#taps" class="btn btn--ghost">Посмотреть краны</a>
                </div>

                <div class="home-hero__stats" aria-label="Ключевые факты">
                    <div class="stat-tile">
                        <strong>2 зала</strong>
                        <span>для разного настроения</span>
                    </div>
                    <div class="stat-tile">
                        <strong>Ежедневно</strong>
                        <span>с 10:00 до 22:00</span>
                    </div>
                    <div class="stat-tile">
                        <strong>18+</strong>
                        <span>взрослая атмосфера и комфорт</span>
                    </div>
                </div>
            </div>

            <aside class="home-hero__panel">
                <div class="home-hero__panel-kicker">Сейчас открыто</div>
                <div class="home-hero__panel-title">Ежедневно с 10:00 до 22:00</div>
                <p class="home-hero__panel-text">Бронируйте стол заранее, заказывайте напитки на вынос и приходите на спокойный вечер без спешки.</p>

                <ul class="home-hero__panel-list">
                    <li><span>Телефон</span><a href="tel:+79533392119">+7 953 339 2119</a></li>
                    <li><span>Адрес</span><strong>Малоярославец, ул. Московская, 14</strong></li>
                    <li><span>VK</span><a href="https://vk.com/pinta_mal">vk.com/pinta_mal</a></li>
                </ul>
            </aside>
        </div>
    </section>

    <section class="home-section">
        <div class="container">
            <div class="section-intro section-intro--wide">
                <span class="section-kicker">Атмосфера</span>
                <h2>Визуально спокойное, но живое место для встреч, ужинов и длинных разговоров.</h2>
                <p>Мы собрали пространство так, чтобы оно ощущалось дорогим без показной роскоши: мягкий свет, тёплые фактуры, структурированные секции и понятная навигация по сценарию вечера.</p>
            </div>

            <div class="experience-grid">
                <article class="experience-card">
                    <div class="experience-card__title">Сервис</div>
                    <p>Быстрая подача, аккуратная посадка, понятные рекомендации и внимание к деталям — как в хорошем ресторане.</p>
                </article>
                <article class="experience-card">
                    <div class="experience-card__title">Напитки</div>
                    <p>Большой выбор на кранах, свежая ротация позиций и понятная витрина с сортами, стилем и крепостью.</p>
                </article>
                <article class="experience-card">
                    <div class="experience-card__title">Атмосфера</div>
                    <p>Баланс камерности и статуса: место, куда удобно прийти вдвоём, с друзьями или для спокойного ужина.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="home-section home-story">
        <div class="container home-story__grid">
            <div class="home-story__media">
                <img src="/assets/images/pinta/bar_vert.webp" alt="Интерьер Пинты" />
            </div>
            <div class="home-story__content">
                <span class="section-kicker">О нас</span>
                <h2>Ресторанная подача, дружелюбный паб и аккуратная визуальная дисциплина.</h2>
                <p>В первом зале работает магазин разливных напитков с большим выбором на кранах. Во втором — уютный ретро-паб с более камерным настроением. Мы держим фокус на свежести, качестве и ощущении «хорошо проведённого вечера».</p>

                <div class="home-story__points">
                    <div class="home-story__point">Свежие напитки и понятная витрина</div>
                    <div class="home-story__point">Уютная посадка и мягкий свет</div>
                    <div class="home-story__point">Вечерний формат без суеты</div>
                </div>
            </div>
        </div>
    </section>

    <section class="home-section" id="taps">
        <div class="container">
            <div class="section-intro">
                <span class="section-kicker">Сегодня на кранах</span>
                <h2>Подборка актуальных сортов с чистой визуальной подачей.</h2>
                <p>Карточки показывают ключевые параметры сразу: стиль, крепость и ориентир по цене. Это быстрее для гостя и выглядит как полноценное меню уровня хорошего заведения.</p>
            </div>

            <div class="slider-wrap home-slider-wrap">
                <button class="slider-btn prev" aria-label="Назад">‹</button>
                <div class="slider horizontal-scroll taps-slider" data-visible-desktop="4">
                    <?php if (count($onTaps) === 0): ?>
                        <div class="tap-card tap-card--empty">Скоро здесь появятся сорта на кранах. Мы обновим витрину, как только добавим новые позиции.</div>
                    <?php else: ?>
                        <?php foreach ($onTaps as $tap): ?>
                            <article class="tap-card slider-item">
                                <div class="tap-card__media">
                                    <img src="<?= htmlspecialchars($resolveImage($tap['image_path'] ?? '', '/assets/images/pinta/hero-placeholder.svg'), ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars((string) ($tap['name'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" />
                                    <span class="tap-card__badge">На кране</span>
                                </div>
                                <div class="tap-card__body">
                                    <div class="tap-card__meta">
                                        <span><?= htmlspecialchars((string) ($tap['style'] ?? 'Стиль не указан'), ENT_QUOTES, 'UTF-8') ?></span>
                                        <span><?= htmlspecialchars($formatPercent($tap['abv'] ?? null), ENT_QUOTES, 'UTF-8') ?></span>
                                    </div>
                                    <h3><?= htmlspecialchars((string) ($tap['name'] ?? ''), ENT_QUOTES, 'UTF-8') ?></h3>
                                    <div class="tap-card__prices">
                                        <div>
                                            <span>Магазин, л</span>
                                            <strong><?= htmlspecialchars($formatPrice($tap['price_store_liter'] ?? null), ENT_QUOTES, 'UTF-8') ?></strong>
                                        </div>
                                        <div>
                                            <span>Бар, 0.5 л</span>
                                            <strong><?= htmlspecialchars($formatPrice($tap['price_bar_half'] ?? null), ENT_QUOTES, 'UTF-8') ?></strong>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <button class="slider-btn next" aria-label="Вперёд">›</button>
            </div>
        </div>
    </section>

    <section class="home-section home-editorial">
        <div class="container">
            <div class="section-intro">
                <span class="section-kicker">Программа вечера</span>
                <h2>Акции, события и новости поданы как аккуратная подборка, а не как хаотичный список.</h2>
            </div>

            <div class="editorial-grid">
                <article class="content-card">
                    <div class="content-card__head">
                        <span class="content-card__label">Акции</span>
                    </div>
                    <?php if (empty($featuredPromotions)): ?>
                        <p class="content-card__empty">Скоро появятся специальные предложения на вечерние часы и подборки к напиткам.</p>
                    <?php else: ?>
                        <?php foreach ($featuredPromotions as $promo): ?>
                            <div class="content-item">
                                <h3><?= htmlspecialchars((string) ($promo['title'] ?? ''), ENT_QUOTES, 'UTF-8') ?></h3>
                                <p><?= htmlspecialchars((string) ($promo['announce'] ?? ''), ENT_QUOTES, 'UTF-8') ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </article>

                <article class="content-card">
                    <div class="content-card__head">
                        <span class="content-card__label">События</span>
                    </div>
                    <?php if (empty($featuredEvents)): ?>
                        <p class="content-card__empty">Событий пока нет, но этот блок готов под дегустации, музыкальные вечера и камерные встречи.</p>
                    <?php else: ?>
                        <?php foreach ($featuredEvents as $ev): ?>
                            <div class="content-item">
                                <div class="content-item__meta"><?= htmlspecialchars($formatDate($ev['event_at'] ?? null), ENT_QUOTES, 'UTF-8') ?></div>
                                <h3><?= htmlspecialchars((string) ($ev['title'] ?? ''), ENT_QUOTES, 'UTF-8') ?></h3>
                                <p><?= htmlspecialchars((string) ($ev['announce'] ?? ''), ENT_QUOTES, 'UTF-8') ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </article>

                <article class="content-card">
                    <div class="content-card__head">
                        <span class="content-card__label">Новости</span>
                    </div>
                    <?php if (empty($featuredNews)): ?>
                        <p class="content-card__empty">Здесь будут обновления меню, режима работы и сезонных новинок.</p>
                    <?php else: ?>
                        <?php foreach ($featuredNews as $item): ?>
                            <div class="content-item">
                                <h3><?= htmlspecialchars((string) ($item['title'] ?? ''), ENT_QUOTES, 'UTF-8') ?></h3>
                                <p><?= htmlspecialchars((string) ($item['content'] ?? ''), ENT_QUOTES, 'UTF-8') ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </article>
            </div>
        </div>
    </section>

    <section class="home-section" id="contacts">
        <div class="container contact-grid">
            <div class="section-intro contact-intro">
                <span class="section-kicker">Контакты</span>
                <h2>Резерв столов, адрес и карта — в одном спокойном блоке.</h2>
                <p>Мы сделали этот блок максимально прямым: быстрый звонок, точный адрес, график работы и карта без лишних отвлекающих элементов.</p>

                <div class="contact-list">
                    <div class="contact-row">
                        <span>Телефон</span>
                        <a href="tel:+79533392119">+7 953 339 2119</a>
                    </div>
                    <div class="contact-row">
                        <span>Адрес</span>
                        <strong>Малоярославец, ул. Московская, дом 14</strong>
                    </div>
                    <div class="contact-row">
                        <span>График</span>
                        <strong>Ежедневно с 10:00 до 22:00</strong>
                    </div>
                    <div class="contact-row">
                        <span>VK</span>
                        <a href="https://vk.com/pinta_mal">https://vk.com/pinta_mal</a>
                    </div>
                </div>
            </div>

            <div class="map-shell">
                <iframe src="https://yandex.ru/map-widget/v1/org/pinta/76021133852/?ll=36.471430%2C55.010597&z=17" title="Пинта на карте" width="560" height="400" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
    </section>

    <script src="/assets/js/home.js"></script>
</section>