<?php

declare(strict_types=1);
?>
<footer class="site-footer">
    <div class="container footer-inner">
        <div>
            <strong><?= htmlspecialchars($config['site_name'], ENT_QUOTES, 'UTF-8'); ?></strong>
            <div class="muted">© <?= date('Y'); ?></div>
        </div>
        <div class="text-sm text-stone-400">
            <div>Информация об алкогольной продукции предназначена для лиц старше 18 лет.</div>
            <div><a href="/privacy" class="muted">Политика конфиденциальности</a></div>
        </div>
    </div>
</footer>
