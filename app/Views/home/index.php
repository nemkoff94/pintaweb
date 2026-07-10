<?php

declare(strict_types=1);
?>
<section class="relative overflow-hidden">
    <div class="absolute inset-0 hero-glow opacity-60"></div>
    <div class="mx-auto grid min-h-[calc(100vh-145px)] max-w-6xl gap-12 px-6 py-16 lg:grid-cols-[1.05fr_0.95fr] lg:items-center">
        <div class="relative z-10 space-y-8">
            <span class="inline-flex rounded-full border border-amber-400/40 bg-amber-400/10 px-4 py-2 text-sm font-medium text-amber-300">
                Добро пожаловать в «Пинта»
            </span>
            <div class="space-y-4">
                <h1 class="text-5xl font-black tracking-tight text-white sm:text-6xl">
                    <?= htmlspecialchars($config['site_name'], ENT_QUOTES, 'UTF-8'); ?>
                </h1>
                <p class="text-xl text-stone-300 sm:text-2xl">
                    <?= htmlspecialchars($config['site_tagline'], ENT_QUOTES, 'UTF-8'); ?>
                </p>
            </div>
            <p class="max-w-2xl text-lg leading-8 text-stone-300">
                Уютное цифровое пространство для магазина-паба с атмосферой хороших встреч, качественных напитков и лёгкого современного сервиса.
                Этот проект уже готов к дальнейшему развитию: здесь удобно добавлять каталог, новости, меню, страницы и админ-функции.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="/admin" class="rounded-full bg-amber-400 px-6 py-3 text-sm font-semibold text-stone-950 transition hover:bg-amber-300">
                    Войти в админ-панель
                </a>
                <span class="rounded-full border border-white/10 px-6 py-3 text-sm text-stone-300">
                    Чистый старт на PHP 8.2+, SQLite, Tailwind и Alpine.js
                </span>
            </div>
        </div>
        <div class="relative z-10">
            <div class="overflow-hidden rounded-[2rem] border border-white/10 bg-white/5 p-3 shadow-2xl shadow-amber-950/30">
                <div class="relative overflow-hidden rounded-[1.6rem] bg-stone-900">
                    <div class="absolute inset-0 bg-gradient-to-br from-amber-300/25 via-transparent to-orange-500/20"></div>
                    <img
                        src="https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?auto=format&fit=crop&w=1400&q=80"
                        alt="Интерьер магазина-паба"
                        class="h-[420px] w-full object-cover opacity-80"
                    >
                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-stone-950 via-stone-950/60 to-transparent p-8">
                        <p class="text-sm uppercase tracking-[0.3em] text-amber-300">Pinta</p>
                        <p class="mt-3 text-2xl font-semibold text-white">Современный сайт для уютного магазина-паба</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
