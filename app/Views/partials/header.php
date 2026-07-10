<?php

declare(strict_types=1);

$isAdmin = str_starts_with($_SERVER['REQUEST_URI'] ?? '/', '/admin');
?>
<header class="border-b border-white/10 bg-stone-950/95 backdrop-blur">
    <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
        <a href="/" class="flex items-center gap-3 text-white">
            <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-amber-400 text-lg font-black text-stone-950">П</span>
            <span>
                <span class="block text-lg font-semibold tracking-wide"><?= htmlspecialchars($config['site_name'], ENT_QUOTES, 'UTF-8'); ?></span>
                <span class="block text-xs uppercase tracking-[0.3em] text-stone-400"><?= htmlspecialchars($config['site_tagline'], ENT_QUOTES, 'UTF-8'); ?></span>
            </span>
        </a>
        <nav class="flex items-center gap-3 text-sm text-stone-300">
            <a href="/" class="rounded-full px-4 py-2 transition hover:bg-white/5 hover:text-white">Главная</a>
            <a href="/admin" class="rounded-full border border-white/10 px-4 py-2 transition hover:border-amber-400 hover:text-white"><?= $isAdmin ? 'Панель' : 'Админ'; ?></a>
        </nav>
    </div>
</header>
