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
        .tgmenu__navbar-wrap ul.navigation { align-items: center; display: flex; margin: 0; padding: 0; }
        .tgmenu__navbar-wrap ul.navigation > li { list-style: none; position: relative; }
        .tgmenu__navbar-wrap ul.navigation > li > a { display: block; }
        .tgmenu__navbar-wrap ul.navigation li .sub-menu { display: block; left: 0; opacity: 0; pointer-events: none; top: 100%; transform: translateY(12px); visibility: hidden; }
        .tgmenu__navbar-wrap ul.navigation li:hover > .sub-menu,
        .tgmenu__navbar-wrap ul.navigation li:focus-within > .sub-menu { opacity: 1; pointer-events: auto; transform: translateY(0); visibility: visible; }
        .tgmenu__navbar-wrap ul.navigation > li.active > a,
        .tgmenu__navbar-wrap ul.navigation > li:hover > a { color: var(--tg-theme-primary); }
        .tgmenu__action .header-search-form { background: #fff; border: 1px solid #e8e8e8; border-radius: 8px; box-shadow: 0 14px 28px rgba(0,0,0,.08); display: none; padding: 10px; position: absolute; right: 0; top: 42px; width: min(320px, 80vw); z-index: 20; }
        .tgmenu__action li.header-search { position: relative; }
        .tgmenu__action li.header-search:hover .header-search-form,
        .tgmenu__action li.header-search:focus-within .header-search-form { display: block; }
        .tgmenu__action .header-search-form input { border: 0; min-height: 44px; outline: none; padding: 0 14px; width: 100%; }
        .mobile-nav-toggler { cursor: pointer; }
        .cea-mobile-menu { background: #fff; border-top: 1px solid #eee; display: none; padding: 18px 0; }
        .cea-mobile-menu ul { display: grid; gap: 8px; list-style: none; margin: 0; padding: 0; }
        .cea-mobile-menu a { color: var(--cea-dark); font-weight: 800; }
        .cea-btn { align-items: center; background: var(--cea-gold); border: 1px solid var(--cea-gold); border-radius: 8px; color: var(--cea-dark); display: inline-flex; font-weight: 900; min-height: 46px; padding: 0 18px; }
        .cea-btn.secondary { background: transparent; color: #fff; }
        .cea-footer-actions { display: flex; flex-wrap: wrap; gap: 12px; }
        .cea-footer-actions a { align-items: center; background: #f2b66d; border: 1px solid #f2b66d; border-radius: 8px; color: #2a0710; display: inline-flex; font-size: 14px; font-weight: 800; min-height: 46px; padding: 12px 18px; }
        .cea-footer-actions a:hover { background: #fff; border-color: #fff; color: #4b0b17; }
        .cea-landing-footer { background: #2a0710; padding: 56px 0 24px; }
        .cea-footer-grid { display: grid; gap: 30px; grid-template-columns: 1.4fr repeat(3, 1fr); }
        .cea-footer-brand img { display: block; margin-bottom: 16px; max-width: 180px; }
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
        .home-hero img { border-radius: 8px; box-shadow: 0 24px 70px rgba(0,0,0,.22); width: 100%; }
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
            .cea-mobile-menu { display: block; }
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
                                <img src="{{ asset('assets/img/cea/1.png') }}" alt="{{ config('app.name') }}">
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
                                        <img src="{{ asset('assets/img/cea/1.png') }}" alt="{{ config('app.name') }}">
                                    </a>
                                </div>
                                <div class="offcanvas-toggle d-none d-lg-block">
                                    <a href="{{ route('home') }}"><i class="flaticon-menu-bar"></i></a>
                                </div>
                                <div class="tgmenu__navbar-wrap tgmenu__main-menu d-none d-lg-flex">
                                    <ul class="navigation">
                                        @foreach ($navigation as $nav)
                                            @php
                                                $href = $nav['publicHref'] ?? $nav['href'];
                                                $path = trim($href, '/');
                                                $active = $href === '/' ? request()->is('/') : request()->is($path) || request()->is($path.'/*');
                                            @endphp
                                            <li class="{{ ! empty($nav['children']) ? 'menu-item-has-children' : '' }} {{ $active ? 'active' : '' }}">
                                                <a href="{{ $href }}">{{ $nav['label'] }}</a>
                                                @if (! empty($nav['children']))
                                                    <ul class="sub-menu">
                                                        @foreach ($nav['children'] as $child)
                                                            @php
                                                                $childHref = $child['publicHref'] ?? $child['href'];
                                                                $childPath = trim($childHref, '/');
                                                            @endphp
                                                            <li class="{{ request()->is($childPath) || request()->is($childPath.'/*') ? 'active' : '' }}">
                                                                <a href="{{ $childHref }}">{{ $child['label'] }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
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
                            <div class="mobile-nav-toggler"><i class="fas fa-bars"></i></div>
                        </div>
                        <nav class="cea-mobile-menu d-lg-none" aria-label="Menu mobile">
                            <ul>
                                @foreach ($navigation as $nav)
                                    <li><a href="{{ $nav['publicHref'] ?? $nav['href'] }}">{{ $nav['label'] }}</a></li>
                                @endforeach
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
