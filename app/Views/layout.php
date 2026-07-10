<?php

declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(($title ?? 'Страница') . ' — ' . $config['site_name'], ENT_QUOTES, 'UTF-8'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="/assets/css/styles.css">
    <link rel="stylesheet" href="/assets/css/pinta.css">
</head>
<body class="min-h-screen bg-stone-950 text-stone-100 antialiased">
<?php require dirname(__DIR__) . '/Views/partials/header.php'; ?>
<main>
    <?php require $contentView; ?>
</main>
<?php require dirname(__DIR__) . '/Views/partials/footer.php'; ?>
</body>
</html>
