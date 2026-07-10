<?php

declare(strict_types=1);
?>
<section class="mx-auto flex min-h-[calc(100vh-145px)] max-w-6xl items-center px-6 py-16">
    <div class="grid w-full gap-10 lg:grid-cols-[0.95fr_1.05fr]">
        <div class="space-y-6">
            <span class="inline-flex rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm text-stone-300">
                Доступ для администратора
            </span>
            <h1 class="text-4xl font-black tracking-tight text-white sm:text-5xl">Управление сайтом «Пинта»</h1>
            <p class="max-w-xl text-lg leading-8 text-stone-300">
                Войдите в административную панель, чтобы в будущем управлять каталогом, новостями, страницами и настройками сайта.
            </p>
        </div>
        <div class="rounded-[2rem] border border-white/10 bg-white/5 p-8 shadow-2xl shadow-black/30">
            <?php if (is_string($error) && $error !== ''): ?>
                <div class="mb-6 rounded-2xl border border-red-400/30 bg-red-400/10 px-4 py-3 text-sm text-red-200">
                    <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>
            <form action="/admin/login" method="post" class="space-y-5">
                <input type="hidden" name="_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                <div class="space-y-2">
                    <label for="login" class="text-sm font-medium text-stone-200">Логин</label>
                    <input
                        id="login"
                        name="login"
                        type="text"
                        value="<?= htmlspecialchars((string) $oldLogin, ENT_QUOTES, 'UTF-8'); ?>"
                        required
                        autocomplete="username"
                        class="w-full rounded-2xl border border-white/10 bg-stone-900 px-4 py-3 text-white outline-none transition focus:border-amber-400"
                    >
                </div>
                <div class="space-y-2">
                    <label for="password" class="text-sm font-medium text-stone-200">Пароль</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        autocomplete="current-password"
                        class="w-full rounded-2xl border border-white/10 bg-stone-900 px-4 py-3 text-white outline-none transition focus:border-amber-400"
                    >
                </div>
                <button
                    type="submit"
                    class="w-full rounded-2xl bg-amber-400 px-5 py-3 text-sm font-semibold text-stone-950 transition hover:bg-amber-300"
                >
                    Войти
                </button>
            </form>
            <div class="mt-6 rounded-2xl border border-white/10 bg-stone-900/70 px-4 py-3 text-sm text-stone-400">
                При первом запуске автоматически создаётся пользователь <strong class="text-stone-200">admin</strong>.
            </div>
        </div>
    </div>
</section>
