<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <link rel="icon" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/spacing.css') }}">
    <style>
        :root {
            --cea-red: #7a1626;
            --cea-dark: #240710;
            --cea-gold: #f2b66d;
            --cea-ink: #161616;
            --cea-muted: #686868;
        }
        body { background: #fff; color: var(--cea-ink); }
        header, main, footer { position: relative; z-index: 2; }
        header { z-index: 50; }
        @unless (request()->is('admin*'))
            .kso-cube-field { color: rgba(242, 182, 109, .74); inset: 0; opacity: .22; pointer-events: none; position: fixed; z-index: 3; }
            .kso-cube-field canvas { display: block; height: 100%; width: 100%; }
        @else
            header, main, footer { position: static; z-index: auto; }
        @endunless
        .tg-header__area { position: relative; z-index: 80; }
        .tgmenu__navbar-wrap { position: relative; z-index: 90; }
        .tgmenu__navbar-wrap ul.navigation { align-items: center; display: flex; margin: 0; padding: 0; }
        .tgmenu__navbar-wrap ul.navigation > li { list-style: none; position: relative; }
        .tgmenu__navbar-wrap ul.navigation > li > a { display: block; }
        .tgmenu__navbar-wrap ul.navigation li .sub-menu { display: block; left: 0; min-width: 240px; opacity: 0; pointer-events: none; position: absolute; top: 100%; transform: translateY(12px); visibility: hidden; z-index: 999; }
        .tgmenu__navbar-wrap ul.navigation li:hover > .sub-menu,
        .tgmenu__navbar-wrap ul.navigation li:focus-within > .sub-menu,
        .tgmenu__navbar-wrap ul.navigation li.is-open > .sub-menu { opacity: 1; pointer-events: auto; transform: translateY(0); visibility: visible; }
        .tgmenu__navbar-wrap ul.navigation li .sub-menu li { position: relative; }
        .tgmenu__navbar-wrap ul.navigation li .sub-menu .sub-menu { left: 100%; top: 0; transform: translateX(12px); }
        .tgmenu__navbar-wrap ul.navigation li .sub-menu li:hover > .sub-menu,
        .tgmenu__navbar-wrap ul.navigation li .sub-menu li:focus-within > .sub-menu,
        .tgmenu__navbar-wrap ul.navigation li .sub-menu li.is-open > .sub-menu { opacity: 1; pointer-events: auto; transform: translateX(0); visibility: visible; }
        .tgmenu__navbar-wrap ul.navigation li .sub-menu a { max-width: 320px; white-space: normal; }
        .tgmenu__navbar-wrap ul.navigation > li.active > a,
        .tgmenu__navbar-wrap ul.navigation > li:hover > a,
        .tgmenu__navbar-wrap ul.navigation > li.is-open > a { color: var(--tg-theme-primary); }
        .tgmenu__action .header-search-form { background: #fff; border: 1px solid #e8e8e8; border-radius: 8px; box-shadow: 0 14px 28px rgba(0,0,0,.08); display: none; padding: 10px; position: absolute; right: 0; top: 42px; width: min(320px, 80vw); z-index: 20; }
        .tgmenu__action li.header-search { position: relative; }
        .tgmenu__action li.header-search:hover .header-search-form,
        .tgmenu__action li.header-search:focus-within .header-search-form { display: block; }
        .tgmenu__action .header-search-form input { border: 0; min-height: 44px; outline: none; padding: 0 14px; width: 100%; }
        .mobile-nav-toggler { cursor: pointer; }
        .cea-mobile-menu { background: #fff; border-top: 1px solid #eee; display: none; padding: 18px 0; }
        .cea-mobile-menu.is-open { display: block; }
        .cea-mobile-menu ul { display: grid; gap: 8px; list-style: none; margin: 0; padding: 0; }
        .cea-mobile-menu li { position: relative; }
        .cea-mobile-menu .sub-menu { display: none; margin-top: 8px; padding: 8px 0 8px 14px; }
        .cea-mobile-menu li.is-open > .sub-menu { display: grid; }
        .cea-mobile-menu a { color: var(--cea-dark); font-weight: 800; }
        .cea-btn { align-items: center; background: var(--cea-gold); border: 1px solid var(--cea-gold); border-radius: 8px; color: var(--cea-dark); display: inline-flex; font-weight: 900; min-height: 46px; padding: 0 18px; }
        .cea-btn.secondary { background: transparent; color: #fff; }
        .kso-wordmark { --kso-bg: #fff8f2; --kso-ink: #3a0710; --kso-accent: #f2b66d; --kso-line: rgba(122,22,38,.16); align-items: center; background: radial-gradient(circle at 78% 22%, rgba(242,182,109,.36), transparent 28%), linear-gradient(135deg, var(--kso-bg), #fff); border: 1px solid var(--kso-line); border-radius: 8px; color: var(--kso-ink); display: grid; isolation: isolate; min-height: 76px; min-width: 210px; overflow: hidden; padding: 16px 18px; position: relative; width: max-content; }
        .kso-wordmark__grid { display: grid; gap: 8px; grid-template-columns: repeat(11, minmax(9px, 1fr)); inset: -18% -8%; opacity: .38; position: absolute; transform: rotate(-7deg) scale(1.1); z-index: -1; }
        .kso-wordmark__square { aspect-ratio: 1 / 1; background: linear-gradient(135deg, rgba(122,22,38,.86), rgba(242,182,109,.82)); border-radius: 3px; box-shadow: 0 8px 18px rgba(122,22,38,.14); display: block; opacity: .82; }
        .kso-wordmark__content { display: grid; gap: 1px; position: relative; z-index: 1; }
        .kso-wordmark__eyebrow, .kso-wordmark__tagline { color: #a64034; display: block; font-size: 11px; font-weight: 900; letter-spacing: 0; line-height: 1; text-transform: uppercase; }
        .kso-wordmark strong { color: var(--kso-ink); display: block; font-size: 32px; font-weight: 950; letter-spacing: 0; line-height: .92; text-transform: uppercase; }
        .kso-wordmark__tagline { color: #5d343a; font-size: 12px; line-height: 1.3; margin-top: 8px; max-width: 420px; text-transform: none; }
        .kso-wordmark--header { min-height: 52px; min-width: 182px; padding: 8px 12px; }
        .kso-wordmark--header .kso-wordmark__grid, .kso-wordmark--compact .kso-wordmark__grid { gap: 5px; inset: -26% -12%; }
        .kso-wordmark--header .kso-wordmark__eyebrow, .kso-wordmark--compact .kso-wordmark__eyebrow { font-size: 9px; }
        .kso-wordmark--header strong { font-size: 25px; }
        .kso-wordmark--compact { min-height: 46px; min-width: 156px; padding: 7px 10px; }
        .kso-wordmark--compact strong { font-size: 22px; }
        .kso-wordmark--footer, .kso-wordmark--login { margin-bottom: 18px; }
        .kso-wordmark--hero, .kso-wordmark--card, .kso-wordmark--content { height: 100%; min-height: 300px; width: 100%; }
        .kso-wordmark--panel { min-height: inherit; width: 100%; }
        .kso-wordmark--hero { --kso-bg: #fffaf7; min-height: 330px; padding: 34px; }
        .kso-wordmark--hero .kso-wordmark__grid, .kso-wordmark--card .kso-wordmark__grid, .kso-wordmark--content .kso-wordmark__grid { gap: 10px; inset: -12% -6%; }
        .kso-wordmark--hero .kso-wordmark__eyebrow { font-size: 15px; }
        .kso-wordmark--hero strong { font-size: clamp(76px, 9vw, 150px); }
        .kso-wordmark--hero .kso-wordmark__tagline { font-size: 17px; }
        .kso-wordmark--card { min-height: 100%; padding: 22px; }
        .kso-wordmark--card strong { font-size: clamp(42px, 5vw, 72px); }
        .kso-wordmark--content { min-height: 380px; padding: 28px; }
        .kso-wordmark--content strong { font-size: clamp(62px, 8vw, 120px); }
        .cea-footer-actions { display: flex; flex-wrap: wrap; gap: 12px; }
        .cea-footer-actions a { align-items: center; background: #f2b66d; border: 1px solid #f2b66d; border-radius: 8px; color: #2a0710; display: inline-flex; font-size: 14px; font-weight: 800; min-height: 46px; padding: 12px 18px; }
        .cea-footer-actions a:hover { background: #fff; border-color: #fff; color: #4b0b17; }
        .cea-landing-footer { background: #2a0710; padding: 56px 0 24px; }
        .cea-footer-grid { display: grid; gap: 30px; grid-template-columns: 1.4fr repeat(3, 1fr); }
        .cea-footer-brand .kso-wordmark { display: grid; margin-bottom: 16px; max-width: 210px; }
        .cea-landing-footer h3 { color: #fff; font-size: 18px; margin-bottom: 14px; }
        .cea-landing-footer p { color: #c9b3b7; font-size: 15px; line-height: 1.75; margin: 0 0 10px; }
        .cea-landing-footer ul { display: grid; gap: 8px; list-style: none; margin: 0; padding: 0; }
        .cea-landing-footer a { color: rgba(255,255,255,.78); }
        .cea-landing-footer a:hover { color: #f2b66d; }
        .cea-footer-bottom { border-top: 1px solid rgba(255,255,255,.12); color: rgba(255,255,255,.54); margin-top: 32px; padding-top: 18px; }
        .cea-section { padding: 86px 0; }
        .cea-kicker { color: var(--cea-red); display: block; font-size: 13px; font-weight: 900; margin-bottom: 12px; text-transform: uppercase; }
        .cea-card-grid { display: grid; gap: 22px; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); }
        .cea-card { background: #fff; border: 1px solid rgba(122, 22, 38, .12); border-radius: 8px; padding: 26px; }
        .cea-card h3, .cea-card h2 { color: var(--cea-dark); margin-bottom: 12px; }
        .cea-card p { color: var(--cea-muted); line-height: 1.7; }
        .home-hero { background: linear-gradient(135deg, #2a0710 0%, #7a1626 64%, #a64034 100%); color: #fff; padding: 92px 0 76px; }
        .home-hero__grid { align-items: center; display: grid; gap: 48px; grid-template-columns: minmax(0, .88fr) minmax(340px, 1fr); }
        .home-hero h1 { color: #fff; font-size: clamp(46px, 7vw, 92px); font-weight: 900; line-height: .98; margin-bottom: 24px; }
        .home-hero p { color: rgba(255,255,255,.84); font-size: 18px; line-height: 1.75; margin-bottom: 28px; }
        .home-hero__wordmark { border-radius: 8px; box-shadow: 0 24px 70px rgba(0,0,0,.22); min-height: 320px; width: 100%; }
        @if (request()->is('admin*'))
            .cea-admin-panel { background: #f4f7f4; min-height: 100vh; padding: 34px 0 54px; }
            .admin-shell { display: grid; gap: 24px; grid-template-columns: 280px minmax(0, 1fr); margin: 0 auto; max-width: 1320px; padding: 0 20px; }
            .admin-sidebar { align-self: start; background: #102f22; border: 1px solid rgba(255,255,255,.08); border-radius: 8px; color: #fff; overflow: hidden; position: sticky; top: 92px; }
            .admin-sidebar__brand { border-bottom: 1px solid rgba(255,255,255,.1); padding: 20px; }
            .admin-sidebar__brand span, .admin-eyebrow { display: block; font-size: 12px; font-weight: 700; letter-spacing: 0; text-transform: uppercase; }
            .admin-sidebar__brand strong { display: block; font-size: 14px; font-weight: 600; margin-top: 6px; opacity: .72; }
            .admin-sidebar__nav { display: flex; flex-direction: column; padding: 12px; }
            .admin-sidebar__nav a { border-radius: 8px; color: rgba(255,255,255,.78); display: block; font-size: 13px; font-weight: 700; line-height: 1.25; padding: 10px 12px; text-transform: uppercase; }
            .admin-sidebar__nav a:hover, .admin-sidebar__nav a.active { background: #f3aa3d; color: #102f22; }
            .admin-sidebar__children { border-left: 1px solid rgba(255,255,255,.12); display: grid; gap: 2px; margin: 2px 0 8px 12px; padding-left: 8px; }
            .admin-sidebar__children a { font-size: 12px; font-weight: 600; text-transform: none; }
            .admin-workspace { min-width: 0; }
            .admin-hero { align-items: flex-start; background: #fff; border: 1px solid #dfe7df; border-radius: 8px; box-shadow: 0 14px 36px rgba(16,47,34,.06); color: #102f22; display: flex; gap: 20px; justify-content: space-between; margin-bottom: 24px; padding: 28px; }
            .admin-hero h1 { color: #102f22; font-size: 32px; line-height: 1.12; margin-bottom: 10px; }
            .admin-hero p { color: #59675e; font-size: 15px; line-height: 1.7; margin: 0; max-width: 760px; }
            .admin-eyebrow { color: #1b5e3b; margin-bottom: 8px; }
            .admin-stat-strip { display: grid; gap: 14px; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); margin: 24px 0; }
            .admin-stat { background: #fff; border-radius: 8px; padding: 18px; }
            .admin-stat span { color: var(--cea-muted); display: block; font-size: 13px; }
            .admin-stat strong { color: var(--cea-red); font-size: 30px; }
            .admin-grid { display: grid; gap: 18px; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); }
            .admin-card, .admin-table-card, .admin-form-card { background: #fff; border: 1px solid rgba(122,22,38,.12); border-radius: 8px; padding: 24px; }
            .admin-card__label, .admin-status { color: var(--cea-red); font-size: 12px; font-weight: 900; text-transform: uppercase; }
            .admin-card__actions, .admin-form-actions { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 18px; }
            .admin-button, .admin-source-link { align-items: center; background: #1b5e3b; border: 1px solid #1b5e3b; border-radius: 8px; color: #fff; display: inline-flex; font-size: 13px; font-weight: 700; justify-content: center; min-height: 40px; padding: 10px 14px; text-align: center; white-space: nowrap; }
            .admin-button.secondary { background: #fff; border-color: #cfdacf; color: #102f22; }
            .admin-source-link:hover, .admin-button:hover { background: #123f29; border-color: #123f29; color: #fff; }
            .admin-section-spacer { margin-top: 24px; }
            .admin-table { margin: 0; width: 100%; }
            .admin-table th, .admin-table td { border-bottom: 1px solid #eee2d7; padding: 14px; vertical-align: top; }
            .admin-field { margin-bottom: 16px; }
            .admin-field label { display: block; font-weight: 800; margin-bottom: 8px; }
            .admin-field input, .admin-field textarea, .admin-field select { border: 1px solid #e5d7ca; border-radius: 8px; min-height: 44px; padding: 10px 12px; width: 100%; }
            .admin-field textarea { min-height: 130px; }
        @endif
        @media (max-width: 767px) {
            .home-hero__grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 991px) {
            .tgmenu__action { margin-left: auto; }
            .cea-footer-grid { grid-template-columns: 1fr; }
        }
        @if (request()->is('admin*'))
            @media (max-width: 991px) {
                .admin-shell { grid-template-columns: 1fr; }
                .admin-sidebar { position: static; }
            }
        @endif
    </style>
    @stack('styles')
</head>
<body>
    @unless (request()->is('admin*'))
        <div class="kso-cube-field" aria-hidden="true"></div>
    @endunless

    <header>
        <div class="header__top">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-md-6 col-sm-6 order-2 order-lg-0">
                        <div class="header__top-search">
                            <form action="{{ route('blog.index') }}">
                                <input type="text" name="q" placeholder="Cari kabar, rilis, dan referensi...">
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-3 order-0 order-lg-2 d-none d-md-block">
                        <div class="header__top-logo logo text-lg-center">
                            <a href="{{ route('home') }}" class="cea-logo-image-link">
                                @include('layouts.kso-wordmark', ['variant' => 'header', 'compact' => true])
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-3 col-sm-6 order-3 d-none d-sm-block">
                        <div class="header__top-right">
                            <ul class="list-wrap">
                                <li class="news-btn"><a href="/regio/simpul" class="btn"><span class="btn-text">lihat simpul</span></a></li>
                                <li class="lang">
                                    <div class="dropdown">
                                        <button class="dropdown-toggle" type="button">ID</button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">EN</a></li>
                                            <li><a class="dropdown-item" href="#">ID</a></li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="header-fixed-height"></div>
        <div id="sticky-header" class="tg-header__area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="tgmenu__wrap">
                            <nav class="tgmenu__nav">
                                <div class="logo d-block d-lg-none">
                                    <a href="{{ route('home') }}" class="cea-logo-image-link cea-logo-image-link--mobile">
                                        @include('layouts.kso-wordmark', ['variant' => 'header', 'compact' => true])
                                    </a>
                                </div>
                                <div class="offcanvas-toggle d-none d-lg-block">
                                    <a href="{{ route('home') }}"><i class="flaticon-menu-bar"></i></a>
                                </div>
                                <div class="tgmenu__navbar-wrap tgmenu__main-menu d-none d-lg-flex">
                                    <ul class="navigation">
                                        @include('layouts.nav-items', ['items' => $navigation])
                                    </ul>
                                </div>
                                <div class="tgmenu__action">
                                    <ul class="list-wrap">
                                        <li class="header-search">
                                            <a href="#"><i class="far fa-search"></i></a>
                                            <div class="header-search-form">
                                                <form action="{{ route('blog.index') }}">
                                                    <input type="text" name="q" placeholder="Cari konten Pooling Fund - KSO...">
                                                </form>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                            <button class="mobile-nav-toggler" type="button" aria-label="Buka menu" aria-controls="mobile-menu" aria-expanded="false"><i class="fas fa-bars"></i></button>
                        </div>
                        <nav class="cea-mobile-menu d-lg-none" id="mobile-menu" aria-label="Menu mobile">
                            <ul>
                                @include('layouts.nav-items', ['items' => $navigation])
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    @include('layouts.footer')
    <script src="https://cdn.jsdelivr.net/npm/animejs@3.2.2/lib/anime.min.js"></script>
    @unless (request()->is('admin*'))
        <script type="module">
            import * as THREE from 'https://cdn.jsdelivr.net/npm/three@0.164.1/build/three.module.js';
            import { engine, createTimeline, utils } from 'https://cdn.jsdelivr.net/npm/animejs@4.0.2/+esm';

            const [$container] = utils.$('.kso-cube-field');
            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            if ($container && !reduceMotion) {
                engine.useDefaultMainLoop = false;

                const color = utils.get($container, 'color') || '#f2b66d';
                let { width, height } = $container.getBoundingClientRect();
                const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
                const scene = new THREE.Scene();
                const camera = new THREE.PerspectiveCamera(65, width / height, 0.1, 20);
                const geometry = new THREE.BoxGeometry(1, 1, 1);
                const material = new THREE.MeshBasicMaterial({ color, wireframe: true });

                renderer.setSize(width, height);
                renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
                $container.appendChild(renderer.domElement);
                camera.position.z = 5;

                function createAnimatedCube() {
                    const cube = new THREE.Mesh(geometry, material);
                    const x = utils.random(-10, 10, 2);
                    const y = utils.random(-5, 5, 2);
                    const z = [-10, 7];
                    const r = () => utils.random(-Math.PI * 2, Math.PI * 2, 3);
                    const duration = 4000;

                    createTimeline({
                        delay: utils.random(0, duration),
                        defaults: { loop: true, duration, ease: 'inSine' },
                    })
                        .add(cube.position, { x, y, z }, 0)
                        .add(cube.rotation, { x: r, y: r, z: r }, 0)
                        .init();

                    scene.add(cube);
                }

                for (let i = 0; i < 40; i++) {
                    createAnimatedCube();
                }

                function resizeRenderer() {
                    const bounds = $container.getBoundingClientRect();
                    width = Math.max(bounds.width, 1);
                    height = Math.max(bounds.height, 1);
                    camera.aspect = width / height;
                    camera.updateProjectionMatrix();
                    renderer.setSize(width, height);
                }

                window.addEventListener('resize', resizeRenderer);

                function render() {
                    engine.update();
                    renderer.render(scene, camera);
                }

                renderer.setAnimationLoop(render);
            }
        </script>
    @endunless
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var desktopMenu = document.querySelector('.tgmenu__navbar-wrap .navigation');
            var mobileToggle = document.querySelector('.mobile-nav-toggler');
            var mobileMenu = document.querySelector('.cea-mobile-menu');

            function closeDropdowns(scope) {
                (scope || document).querySelectorAll('.menu-item-has-children.is-open').forEach(function (item) {
                    item.classList.remove('is-open');
                    var trigger = item.querySelector(':scope > a[aria-expanded]');
                    if (trigger) trigger.setAttribute('aria-expanded', 'false');
                });
            }

            function bindDropdown(scope) {
                if (!scope) return;

                scope.querySelectorAll('.menu-item-has-children > a').forEach(function (trigger) {
                    trigger.addEventListener('click', function (event) {
                        var item = trigger.parentElement;
                        if (!item) return;

                        event.preventDefault();

                        var parentList = item.parentElement;
                        if (parentList) {
                            parentList.querySelectorAll(':scope > .menu-item-has-children.is-open').forEach(function (sibling) {
                                if (sibling !== item) {
                                    sibling.classList.remove('is-open');
                                    var siblingTrigger = sibling.querySelector(':scope > a[aria-expanded]');
                                    if (siblingTrigger) siblingTrigger.setAttribute('aria-expanded', 'false');
                                }
                            });
                        }

                        var isOpen = item.classList.toggle('is-open');
                        trigger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                    });
                });
            }

            bindDropdown(desktopMenu);
            bindDropdown(mobileMenu);

            if (mobileToggle && mobileMenu) {
                mobileToggle.addEventListener('click', function () {
                    var isOpen = mobileMenu.classList.toggle('is-open');
                    mobileToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                    mobileToggle.setAttribute('aria-label', isOpen ? 'Tutup menu' : 'Buka menu');
                });
            }

            document.addEventListener('click', function (event) {
                if (desktopMenu && !desktopMenu.contains(event.target)) {
                    closeDropdowns(desktopMenu);
                }
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeDropdowns(document);
                    if (mobileMenu && mobileMenu.classList.contains('is-open')) {
                        mobileMenu.classList.remove('is-open');
                        if (mobileToggle) {
                            mobileToggle.setAttribute('aria-expanded', 'false');
                            mobileToggle.setAttribute('aria-label', 'Buka menu');
                        }
                    }
                }
            });

            var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            var animeGlobal = window.anime;
            if (prefersReducedMotion || !animeGlobal) return;

            function runAnime(options) {
                if (typeof animeGlobal === 'function') {
                    animeGlobal(options);
                    return;
                }

                if (typeof animeGlobal.animate === 'function') {
                    animeGlobal.animate(options.targets, options);
                }
            }

            function animateKsoWordmarks() {
                var wordmarks = Array.prototype.slice.call(document.querySelectorAll('.kso-wordmark'));
                if (!wordmarks.length || typeof animeGlobal.stagger !== 'function') return;

                var started = new WeakSet();

                function startWordmark(wordmark, index) {
                    if (started.has(wordmark)) return;
                    started.add(wordmark);

                    var squares = wordmark.querySelectorAll('.kso-wordmark__square');
                    var textParts = wordmark.querySelectorAll('.kso-wordmark__eyebrow, .kso-wordmark strong, .kso-wordmark__tagline');
                    var grid = [11, 4];

                    if (textParts.length) {
                        runAnime({
                            targets: textParts,
                            opacity: [0, 1],
                            translateY: [12, 0],
                            delay: animeGlobal.stagger(95),
                            duration: 720,
                            easing: 'easeOutCubic'
                        });
                    }

                    function animateGrid() {
                        var from = Math.floor(Math.random() * Math.max(squares.length, 1));

                        runAnime({
                            targets: squares,
                            translateX: [
                                { value: animeGlobal.stagger('-.75rem', { grid: grid, from: from, axis: 'x' }), duration: 520, easing: 'easeOutQuad' },
                                { value: 0, duration: 820, easing: 'easeInOutQuad' }
                            ],
                            translateY: [
                                { value: animeGlobal.stagger('-.75rem', { grid: grid, from: from, axis: 'y' }), duration: 520, easing: 'easeOutQuad' },
                                { value: 0, duration: 820, easing: 'easeInOutQuad' }
                            ],
                            opacity: [
                                { value: .42, duration: 520 },
                                { value: .92, duration: 820 }
                            ],
                            scale: [
                                { value: .86, duration: 520 },
                                { value: 1, duration: 820 }
                            ],
                            delay: animeGlobal.stagger(55, { grid: grid, from: from }),
                            complete: function () {
                                window.setTimeout(animateGrid, 950 + (index % 4) * 140);
                            }
                        });
                    }

                    animateGrid();
                }

                if ('IntersectionObserver' in window) {
                    var observer = new IntersectionObserver(function (entries) {
                        entries.forEach(function (entry) {
                            if (entry.isIntersecting) {
                                startWordmark(entry.target, wordmarks.indexOf(entry.target));
                                observer.unobserve(entry.target);
                            }
                        });
                    }, { threshold: .16 });

                    wordmarks.forEach(function (wordmark) {
                        observer.observe(wordmark);
                    });
                    return;
                }

                wordmarks.forEach(startWordmark);
            }

            animateKsoWordmarks();

            document.querySelectorAll('.cea-scramble-title').forEach(function (element) {
                var text = element.textContent.trim();
                if (!text) return;

                element.dataset.text = text;
                element.style.display = 'inline-block';

                runAnime({
                    targets: element,
                    opacity: [0, 1],
                    translateY: [18, 0],
                    duration: 760,
                    easing: 'easeOutQuad'
                });
            });

            var animatedCardSelector = '.cea-focus-card, .cea-governance-card, .cea-menu-card';
            @if (request()->is('admin*'))
                animatedCardSelector += ', .admin-card';
            @endif

            document.querySelectorAll(animatedCardSelector).forEach(function (element, index) {
                runAnime({
                    targets: element,
                    opacity: [0, 1],
                    translateY: [22, 0],
                    delay: Math.min(index * 70, 420),
                    duration: 680,
                    easing: 'easeOutQuad'
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
