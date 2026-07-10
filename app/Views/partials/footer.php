<?php

declare(strict_types=1);
?>
<footer class="border-t border-white/10 bg-stone-950">
    <div class="mx-auto flex max-w-6xl flex-col gap-3 px-6 py-8 text-sm text-stone-400 md:flex-row md:items-center md:justify-between">
        <p>© <?= date('Y'); ?> <?= htmlspecialchars($config['site_name'], ENT_QUOTES, 'UTF-8'); ?> — современный магазин-паб.</p>
        <p>Лёгкая MVC-lite архитектура на PHP + SQLite.</p>
    </div>
</footer>
