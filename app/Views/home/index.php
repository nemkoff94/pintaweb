<?php

declare(strict_types=1);
?>
<section class="relative overflow-hidden retro-hero">
    <div class="absolute inset-0 hero-glow opacity-40"></div>
    <div class="mx-auto max-w-6xl px-6 py-20">
        <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
            <div class="space-y-6">
                <h1 class="retro-title">ПИНТА - Магазин-паб в Малоярославце</h1>
                <p class="retro-lead">Более 20 сортов розлива различного стиля на кранах, всегда свежие закуски к пиву. Бережное отношение к хранению пива и сохранению его вкусовых свойств.</p>
                <div class="flex gap-4 flex-wrap">
                    <a href="/" class="retro-cta">Посмотреть ассортимент</a>
                    <a href="/contacts" class="retro-cta retro-cta--outline">Контакты</a>
                </div>
            </div>
            <div class="flex justify-center">
                <div class="retro-poster">
                    <img src="/assets/images/pinta/poster-placeholder.svg" alt="Фото пока не добавлено" class="placeholder-img"/>
                </div>
            </div>
        </div>

        <section class="mt-14">
            <h2 class="retro-section-title">Наши преимущества</h2>
            <div class="adv-cards mt-6">
                <article class="retro-card">
                    <h3 class="retro-card-title">Разливное пиво</h3>
                    <p class="retro-card-body">Более 20 сортов пива на разливной линии. Всё пиво свежее и правильно хранится.</p>
                </article>
                <article class="retro-card">
                    <h3 class="retro-card-title">Бутылочное пиво</h3>
                    <p class="retro-card-body">Ассортимент разного по стилю баночного и бутылочного пива. Постоянно пополняется.</p>
                </article>
                <article class="retro-card">
                    <h3 class="retro-card-title">Снеки и прочее</h3>
                    <p class="retro-card-body">Закуски к вашим напиткам на любой вкус. Мясные снеки, сыр, орешки и рыба.</p>
                </article>
            </div>
        </section>
        
        <!-- Наш интерьер -->
        <section class="mt-14">
            <h2 class="retro-section-title">Наш интерьер</h2>
            <div class="mt-6 grid grid-cols-4 gap-4">
                <img src="/assets/images/pinta/pub.webp" alt="Интерьер — фото 1" class="w-full h-48 object-cover rounded-lg" />
                <img src="/assets/images/pinta/pub2.webp" alt="Интерьер — фото 2" class="w-full h-48 object-cover rounded-lg" />
                <img src="/assets/images/pinta/pub3.webp" alt="Интерьер — фото 3" class="w-full h-48 object-cover rounded-lg" />
                <img src="/assets/images/pinta/pub4.webp" alt="Интерьер — фото 4" class="w-full h-48 object-cover rounded-lg" />
            </div>
            <p class="mt-4 text-sm text-stone-700">Каждый уголок Пинты напоминает теплые вечера дома, только с отличным пивом.</p>
        </section>

        <!-- Разливное пиво (мини-карточки) -->
        <section class="mt-14">
            <h2 class="retro-section-title">Разливное пиво</h2>
            <div class="mt-6 flex gap-4 overflow-x-auto py-2">
                <?php for ($i=0;$i<5;$i++): ?>
                <article class="retro-card" style="min-width:260px;">
                    <div class="w-full h-40 bg-white rounded-md overflow-hidden mb-3 flex items-center justify-center">
                        <img src="/assets/images/pinta/hero-placeholder.svg" alt="Фото пока не добавлено" class="w-full h-full object-cover placeholder-img" />
                    </div>
                    <h3 class="retro-card-title">Сорт пива <?= $i+1 ?></h3>
                    <p class="retro-card-body">Стиль · 5.2% · IBU 30</p>
                </article>
                <?php endfor; ?>
            </div>
        </section>

        <!-- Бутылочное пиво -->
        <section class="mt-14">
            <h2 class="retro-section-title">Бутылочное пиво</h2>
            <div class="mt-6 grid grid-cols-4 gap-4">
                <?php for ($i=0;$i<8;$i++): ?>
                <div class="retro-card">
                    <div class="flex items-center justify-center mb-3">
                        <img src="/assets/images/pinta/bottle-placeholder.svg" alt="Фото пока не добавлено" class="w-32 h-auto placeholder-img" />
                    </div>
                    <h4 class="retro-card-title">Бутылка <?= $i+1 ?></h4>
                    <p class="retro-card-body">Краткое описание вкуса.</p>
                </div>
                <?php endfor; ?>
            </div>
        </section>

        <!-- Настольные игры -->
        <section class="mt-14">
            <h2 class="retro-section-title">Настольные игры</h2>
            <div class="mt-6 grid grid-cols-3 gap-4">
                <?php $games = ['Alias','Uno','Дженга','Монополия','Имаджинариум','Каркассон']; ?>
                <?php foreach($games as $g): ?>
                <div class="retro-card">
                    <img src="/assets/images/pinta/game-placeholder.svg" alt="Фото пока не добавлено" class="w-full h-32 object-cover rounded-md mb-3 placeholder-img" />
                    <h4 class="retro-card-title"><?= htmlspecialchars($g, ENT_QUOTES, 'UTF-8') ?></h4>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Отзывы -->
        <section class="mt-14 mb-20">
            <h2 class="retro-section-title">Отзывы</h2>
            <div class="mt-6 grid grid-cols-3 gap-6">
                <?php for ($i=0;$i<3;$i++): ?>
                <div class="retro-card">
                    <div class="flex items-center gap-4">
                        <img src="/assets/images/pinta/avatar-placeholder.svg" alt="Фото пока не добавлено" class="w-16 h-16 rounded-full placeholder-img" />
                        <div>
                            <strong>Гость <?= $i+1 ?></strong>
                            <div class="text-sm text-stone-700">«Отличная атмосфера, любимое место для просмотра матчей.»</div>
                        </div>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </section>
    </div>
</section>
