<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'CEA Indonesia')</title>
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
        body { background: #fffaf4; color: var(--cea-ink); }
        .cea-header { background: rgba(255, 250, 244, .96); border-bottom: 1px solid rgba(122, 22, 38, .12); position: sticky; top: 0; z-index: 30; }
        .cea-header__inner { align-items: center; display: flex; gap: 28px; justify-content: space-between; min-height: 78px; }
        .cea-logo { align-items: center; color: var(--cea-dark); display: inline-flex; font-weight: 900; gap: 12px; letter-spacing: .02em; text-transform: uppercase; }
        .cea-logo img { height: 44px; width: auto; }
        .cea-nav { align-items: center; display: flex; flex-wrap: wrap; gap: 18px; justify-content: flex-end; }
        .cea-nav a { color: var(--cea-dark); font-size: 13px; font-weight: 800; text-transform: uppercase; }
        .cea-nav a:hover { color: var(--cea-red); }
        .cea-footer { background: var(--cea-dark); color: rgba(255,255,255,.78); padding: 42px 0; }
        .cea-footer strong { color: #fff; display: block; font-size: 22px; margin-bottom: 8px; }
        .cea-btn { align-items: center; background: var(--cea-gold); border: 1px solid var(--cea-gold); border-radius: 8px; color: var(--cea-dark); display: inline-flex; font-weight: 900; min-height: 46px; padding: 0 18px; }
        .cea-btn.secondary { background: transparent; color: #fff; }
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
        .admin-shell { background: #f6f1ea; min-height: 100vh; padding: 36px 0 70px; }
        .admin-hero { background: linear-gradient(135deg, #260711, #7a1626); border-radius: 8px; color: #fff; padding: 34px; }
        .admin-hero h1 { color: #fff; margin-bottom: 10px; }
        .admin-stat-strip { display: grid; gap: 14px; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); margin: 24px 0; }
        .admin-stat { background: #fff; border-radius: 8px; padding: 18px; }
        .admin-stat span { color: var(--cea-muted); display: block; font-size: 13px; }
        .admin-stat strong { color: var(--cea-red); font-size: 30px; }
        .admin-grid { display: grid; gap: 18px; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); }
        .admin-card, .admin-table-card, .admin-form-card { background: #fff; border: 1px solid rgba(122,22,38,.12); border-radius: 8px; padding: 24px; }
        .admin-card__label, .admin-status { color: var(--cea-red); font-size: 12px; font-weight: 900; text-transform: uppercase; }
        .admin-card__actions, .admin-form-actions { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 18px; }
        .admin-button { background: var(--cea-red); border-radius: 8px; color: #fff; display: inline-flex; font-weight: 800; min-height: 42px; padding: 10px 15px; }
        .admin-button.secondary { background: #f6f1ea; color: var(--cea-red); }
        .admin-section-spacer { margin-top: 24px; }
        .admin-table { margin: 0; width: 100%; }
        .admin-table th, .admin-table td { border-bottom: 1px solid #eee2d7; padding: 14px; vertical-align: top; }
        .admin-field { margin-bottom: 16px; }
        .admin-field label { display: block; font-weight: 800; margin-bottom: 8px; }
        .admin-field input, .admin-field textarea, .admin-field select { border: 1px solid #e5d7ca; border-radius: 8px; min-height: 44px; padding: 10px 12px; width: 100%; }
        .admin-field textarea { min-height: 130px; }
        @media (max-width: 767px) {
            .cea-header__inner { align-items: flex-start; flex-direction: column; padding: 18px 0; }
            .cea-nav { justify-content: flex-start; }
            .home-hero__grid { grid-template-columns: 1fr; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <header class="cea-header">
        <div class="container cea-header__inner">
            <a class="cea-logo" href="{{ route('home') }}">
                <img src="{{ asset('assets/img/cea/1.png') }}" alt="CEA Indonesia">
                <span>CEA Indonesia</span>
            </a>
            <nav class="cea-nav" aria-label="Navigasi utama">
                @foreach ($navigation as $nav)
                    <a href="{{ $nav['publicHref'] ?? $nav['href'] }}">{{ $nav['label'] }}</a>
                @endforeach
                <a href="{{ route('blog.index') }}">Blog</a>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="cea-footer">
        <div class="container">
            <strong>CEA Indonesia</strong>
            <p>Merawat ruang sipil, memperkuat gerakan akar rumput.</p>
        </div>
    </footer>
    @stack('scripts')
</body>
</html>
