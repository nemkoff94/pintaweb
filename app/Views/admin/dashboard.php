<?php

declare(strict_types=1);

$user = $_SESSION['auth_user'] ?? null;
?>
<section class="mx-auto min-h-[calc(100vh-145px)] max-w-6xl px-6 py-16">
    <div class="rounded-[2rem] border border-white/10 bg-white/5 p-8 shadow-2xl shadow-black/30">
        <div class="flex flex-col gap-6 md:flex-row md:items-start md:justify-between">
            <div class="space-y-4">
                <span class="inline-flex rounded-full border border-emerald-400/30 bg-emerald-400/10 px-4 py-2 text-sm text-emerald-200">
                    Доступ разрешён
                </span>
                <h1 class="text-4xl font-black tracking-tight text-white">Добро пожаловать в административную панель.</h1>
                <p class="text-lg leading-8 text-stone-300">
                    Здесь будет развиваться внутренний раздел управления сайтом магазина-паба «Пинта».
                </p>
                <?php if (is_array($user)): ?>
                    <p class="text-sm text-stone-400">
                        Вы вошли как <strong class="text-stone-200"><?= htmlspecialchars((string) $user['login'], ENT_QUOTES, 'UTF-8'); ?></strong>.
                    </p>
                <?php endif; ?>
            </div>
            <form action="/admin/logout" method="post">
                <input type="hidden" name="_token" value="<?= htmlspecialchars(\App\Core\Csrf::token(), ENT_QUOTES, 'UTF-8'); ?>">
                <button
                    type="submit"
                    class="rounded-2xl border border-white/10 px-5 py-3 text-sm font-semibold text-stone-200 transition hover:border-red-400 hover:text-white"
                >
                    Выйти
                </button>
            </form>
        </div>
    </div>
</section>
