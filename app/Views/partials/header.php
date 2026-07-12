<?php

declare(strict_types=1);
?>
<header class="site-header site-header--modern" x-data="{ mobileMenuOpen: false }">
    <div class="container">
        <div class="site-header__bar">
            <a href="/" class="site-header__brand" aria-label="Пинта, главная">
                <img src="/assets/images/pinta/logo.jpg" alt="Пинта" class="site-header__logo" />
                <span class="site-header__brand-text">
                    <strong>Пинта</strong>
                    <small>Ретро-паб и магазин</small>
                </span>
            </a>

            <nav class="site-header__nav" aria-label="Основная навигация">
                <a href="#about">О нас</a>
                <a href="#taps">На кранах</a>
                <a href="#promotions">Акции</a>
                <a href="#events">События</a>
                <a href="#contacts">Контакты</a>
            </nav>

            <div class="site-header__actions">
                <a href="tel:+79533392119" class="site-header__phone">+7 953 339 2119</a>
                <a href="https://vk.com/pinta_mal" class="site-header__social" target="_blank" rel="noopener noreferrer" aria-label="Пинта во ВКонтакте">VK</a>
                <a href="#contacts" class="site-header__cta">Бронь стола</a>
            </div>

            <button
                type="button"
                class="site-header__toggle"
                x-on:click="mobileMenuOpen = !mobileMenuOpen"
                :aria-expanded="mobileMenuOpen.toString()"
                aria-controls="mobile-header-menu"
                aria-label="Открыть меню"
            >
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>

        <div
            id="mobile-header-menu"
            class="site-header__mobile"
            x-cloak
            x-show="mobileMenuOpen"
            x-transition.opacity.duration.200ms
            x-on:click.outside="mobileMenuOpen = false"
        >
            <nav class="site-header__mobile-nav" aria-label="Мобильная навигация">
                <a href="#about" x-on:click="mobileMenuOpen = false">О нас</a>
                <a href="#taps" x-on:click="mobileMenuOpen = false">На кранах</a>
                <a href="#promotions" x-on:click="mobileMenuOpen = false">Акции</a>
                <a href="#events" x-on:click="mobileMenuOpen = false">События</a>
                <a href="#contacts" x-on:click="mobileMenuOpen = false">Контакты</a>
            </nav>

            <div class="site-header__mobile-meta">
                <a href="tel:+79533392119" class="site-header__phone">+7 953 339 2119</a>
                <a href="https://vk.com/pinta_mal" class="site-header__social" target="_blank" rel="noopener noreferrer">ВКонтакте</a>
            </div>
        </div>
    </div>
</header>
