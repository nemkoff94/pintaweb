<?php

declare(strict_types=1);
?>
<section>
    <!-- HERO: 50% viewport height, dark overlay -->
    <section class="hero" style="min-height:50vh;background-image:linear-gradient(rgba(0,0,0,0.55),rgba(0,0,0,0.55)),url('/assets/images/pinta/hero_pinta.webp');">
        <div class="container hero-grid" style="align-items:end;">
            <div style="grid-column:1/-1;text-align:center;padding:36px 12px;">
                <h1 class="hero-title" style="font-size:26px;">Добро пожаловать в Пинту: место, где хорошие люди встречаются с хорошим пивом!</h1>
                <div style="margin-top:16px;"><a href="#book" class="btn btn--primary">Забронировать</a></div>
            </div>
        </div>
    </section>

    <!-- ABOUT -->
    <section class="section" id="about">
        <div class="container" style="display:grid;grid-template-columns:1fr 420px;gap:28px;align-items:center;">
            <div>
                <h2 class="section-title">О нас</h2>
                <p class="muted">В первом зале - магазин разливных напитков с большим выбором на кранах. Во втором зале - уютный ретро-паб в стиле советской квартиры, где можно пообщаться с друзьями за кружечкой пива. Заботимся о свежести и качестве пива. Создаем дружелюбную атмосферу.</p>
            </div>
            <div>
                <img src="/assets/images/pinta/bar_vert.webp" alt="Бар" style="width:100%;height:auto;border-radius:12px;" />
            </div>
        </div>
    </section>

    <!-- TAPS -->
    <section class="section" id="taps">
        <div class="container">
            <h2 class="section-title">Сегодня на кранах:</h2>
            <div class="slider-wrap" style="position:relative;margin-top:12px;">
                <button class="slider-btn prev" aria-label="Назад" style="position:absolute;left:-10px;top:50%;transform:translateY(-50%);z-index:5;">◀</button>
                <div class="slider horizontal-scroll taps-slider" data-visible-desktop="4">
                    <?php
                    $onTaps = [];
                    foreach (($taps ?? []) as $tap) {
                        if ((int) ($tap['is_on_tap'] ?? 0) === 1) {
                            $onTaps[] = $tap;
                        }
                    }

                    if (count($onTaps) === 0): ?>
                        <div class="card">Скоро появятся сорта на кранах — следите за обновлениями.</div>
                    <?php else:
                        foreach ($onTaps as $tap): ?>
                            <article class="slider-item card">
                                <div style="height:160px;overflow:hidden;border-radius:10px;margin-bottom:8px;">
                                    <img src="<?= htmlspecialchars($tap['image_path'] ?: '/assets/images/pinta/hero-placeholder.svg', ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($tap['name'], ENT_QUOTES, 'UTF-8') ?>" style="width:100%;height:100%;object-fit:cover;" />
                                </div>
                                <h4 style="margin:6px 0;font-size:18px;"><?= htmlspecialchars($tap['name'], ENT_QUOTES, 'UTF-8') ?></h4>
                                <div class="muted"><?= htmlspecialchars($tap['style'] ?? '', ENT_QUOTES, 'UTF-8') ?> · <?= htmlspecialchars((string) ($tap['abv'] ?? ''), ENT_QUOTES, 'UTF-8') ?>%</div>
                            </article>
                        <?php endforeach;
                    endif; ?>
                </div>
                <button class="slider-btn next" aria-label="Вперёд" style="position:absolute;right:-10px;top:50%;transform:translateY(-50%);z-index:5;">▶</button>
            </div>
        </div>
    </section>

    <!-- PROMOTIONS -->
    <section class="section" id="promotions">
        <div class="container">
            <h2 class="section-title">Акции</h2>
            <div class="cards mt-4">
                <?php if (empty($promotions ?? [])): ?>
                    <div class="card">Здесь скоро появятся актуальные акции — ждите новостей!</div>
                <?php else:
                    foreach ($promotions as $promo): ?>
                        <article class="card">
                            <h3><?= htmlspecialchars($promo['title'], ENT_QUOTES, 'UTF-8') ?></h3>
                            <p class="muted"><?= htmlspecialchars($promo['announce'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                        </article>
                    <?php endforeach;
                endif; ?>
            </div>
        </div>
    </section>

    <!-- EVENTS -->
    <section class="section" id="events">
        <div class="container">
            <h2 class="section-title">События</h2>
            <div class="cards mt-4">
                <?php if (empty($events ?? [])): ?>
                    <div class="card">Событий пока нет — но скоро всё изменится!</div>
                <?php else:
                    foreach ($events as $ev): ?>
                        <article class="card">
                            <h3><?= htmlspecialchars($ev['title'], ENT_QUOTES, 'UTF-8') ?></h3>
                            <p class="muted"><?= htmlspecialchars($ev['announce'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                            <div class="text-sm muted">Дата: <?= htmlspecialchars($ev['event_at'] ?? '', ENT_QUOTES, 'UTF-8') ?></div>
                        </article>
                    <?php endforeach;
                endif; ?>
            </div>
        </div>
    </section>

    <!-- NEWS -->
    <section class="section" id="news">
        <div class="container">
            <h2 class="section-title">Новости</h2>
            <div class="cards mt-4">
                <?php if (empty($news ?? [])): ?>
                    <div class="card">Новости будут здесь — следите за обновлениями.</div>
                <?php else:
                    foreach ($news as $n): ?>
                        <article class="card">
                            <h3><?= htmlspecialchars($n['title'], ENT_QUOTES, 'UTF-8') ?></h3>
                            <p class="muted"><?= htmlspecialchars($n['content'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                        </article>
                    <?php endforeach;
                endif; ?>
            </div>
        </div>
    </section>

    <!-- CONTACTS -->
    <section class="section" id="contacts">
        <div class="container" style="display:grid;grid-template-columns:1fr 560px;gap:24px;align-items:start;">
            <div>
                <h2 class="section-title">Контакты</h2>
                <p class="muted">Телефон для бронирования и предзаказа: <a href="tel:+79533392119">+7 953 339 2119</a></p>
                <p class="muted">Адрес: Малоярославец, ул. Московская, дом 14.</p>
                <p class="muted">График работы: Ежедневно с 10:00 до 22:00. Работаем до последнего гостя. По предварительной договоренности работаем после 22:00.</p>
                <p class="muted">Мы в VK: <a href="https://vk.com/pinta_mal">https://vk.com/pinta_mal</a></p>
            </div>
            <div>
                <div style="position:relative;overflow:hidden;">
                    <a href="https://yandex.ru/maps/org/pinta/76021133852/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:0px;">Пинта</a>
                    <a href="https://yandex.ru/maps/10697/maloyaroslavets/category/beer_shop/40891073018/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:14px;">Магазин пива в Малоярославце</a>
                    <a href="https://yandex.ru/maps/10697/maloyaroslavets/category/pub/167978289740/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:28px;">Паб в Малоярославце</a>
                    <iframe src="https://yandex.ru/map-widget/v1/org/pinta/76021133852/?ll=36.471430%2C55.010597&z=17" width="560" height="400" frameborder="1" allowfullscreen="true" style="position:relative;border-radius:10px;"></iframe>
                </div>
            </div>
        </div>
    </section>

    <script src="/assets/js/home.js"></script>
</section>
