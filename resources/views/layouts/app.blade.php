<!doctype html>
<html lang="{{ $currentLocale ?? 'id' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/img/kso/KSO.jpeg') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/spacing.css') }}">
    <style>
        :root {
            --cea-red: #1f7a43;
            --cea-dark: #063d2a;
            --cea-gold: #f2c94c;
            --cea-ink: #10261d;
            --cea-muted: #5b6c61;
        }
        body { background: #fff; color: var(--cea-ink); }
        header, main, footer { position: relative; z-index: 2; }
        header { z-index: 120; }
        @unless (request()->is('admin*'))
            .kso-cube-field { color: rgba(242, 201, 76, .74); inset: 0; opacity: .18; pointer-events: none; position: fixed; z-index: 3; }
            .kso-cube-field canvas { display: block; height: 100%; width: 100%; }
        @else
            header, main, footer { position: static; z-index: auto; }
        @endunless
        @unless (request()->is('admin*'))
            header { left: 0; position: absolute; right: 0; top: 0; }
            #header-fixed-height { display: none !important; }
            .header__top,
            .tg-header__area,
            .tgmenu__wrap { background: transparent !important; box-shadow: none !important; }
            .header__top,
            .tg-header__area { border: 0 !important; }
            .tgmenu__wrap { min-height: 62px; }
            .header__top-search form { background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.22); border-radius: 999px; }
            .header__top-search form::before,
            .header__top-search form input,
            .header__top-right .lang .dropdown-toggle,
            .tgmenu__navbar-wrap ul.navigation > li > a,
            .tgmenu__action ul li a,
            .mobile-nav-toggler { color: #fff !important; }
            .header__top-search form input { background: transparent; }
            .header__top-search form input::placeholder { color: rgba(255,255,255,.72); opacity: 1; }
            .header__top-right .lang .dropdown-toggle { background: rgba(255,255,255,.12); border-color: rgba(255,255,255,.2); }
            .header__top-right .lang .dropdown:hover .dropdown-menu,
            .header__top-right .lang .dropdown:focus-within .dropdown-menu { display: block; }
            .header__top-right .btn { box-shadow: 0 14px 32px rgba(0,0,0,.18); }
            .header__top-logo .kso-wordmark { background: rgba(255,255,255,.9); }
        @endunless
        .tg-header__area { position: relative; z-index: 110; }
        .tgmenu__navbar-wrap { position: relative; z-index: 90; }
        .tgmenu__navbar-wrap ul.navigation { align-items: center; display: flex; margin: 0; padding: 0; }
        .tgmenu__navbar-wrap ul.navigation > li { list-style: none; position: relative; }
        .tgmenu__navbar-wrap ul.navigation > li > a { display: block; }
        .tgmenu__navbar-wrap ul.navigation li .sub-menu { background: #e9e3d8; border: 1px solid rgba(6,61,42,.18); border-top: 5px solid #1b7f55; border-radius: 0 0 8px 8px; box-shadow: 0 18px 44px rgba(6,61,42,.22); display: block; left: 0; max-height: min(72vh, 540px); min-width: 260px; opacity: 0; overflow: visible; padding: 0; pointer-events: none; position: absolute; top: 100%; transform: translateY(12px); visibility: hidden; z-index: 999; }
        .tgmenu__navbar-wrap ul.navigation li:hover > .sub-menu,
        .tgmenu__navbar-wrap ul.navigation li:focus-within > .sub-menu,
        .tgmenu__navbar-wrap ul.navigation li.is-open > .sub-menu { opacity: 1; pointer-events: auto; transform: translateY(0); visibility: visible; }
        .tgmenu__navbar-wrap ul.navigation li .sub-menu li { position: relative; }
        .tgmenu__navbar-wrap ul.navigation li .sub-menu .sub-menu { border-top-color: #f2c94c; left: 100%; max-height: min(74vh, 560px); overflow: visible; top: -5px; transform: translateX(12px); }
        .tgmenu__navbar-wrap ul.navigation li .sub-menu li:hover > .sub-menu,
        .tgmenu__navbar-wrap ul.navigation li .sub-menu li:focus-within > .sub-menu,
        .tgmenu__navbar-wrap ul.navigation li .sub-menu li.is-open > .sub-menu { opacity: 1; pointer-events: auto; transform: translateX(0); visibility: visible; }
        .tgmenu__navbar-wrap ul.navigation li .sub-menu a { border-bottom: 1px solid rgba(6,61,42,.16); color: #1f1f1f; display: block; font-size: 15px; font-weight: 700; line-height: 1.25; max-width: 340px; padding: 8px 18px; text-transform: none; white-space: normal; }
        .tgmenu__navbar-wrap ul.navigation li .sub-menu li:last-child > a { border-bottom: 0; }
        .tgmenu__navbar-wrap ul.navigation li .sub-menu li:hover > a,
        .tgmenu__navbar-wrap ul.navigation li .sub-menu li.is-open > a { background: #99ead9; color: #063d2a; }
        .tgmenu__navbar-wrap ul.navigation > li.active > a,
        .tgmenu__navbar-wrap ul.navigation > li:hover > a,
        .tgmenu__navbar-wrap ul.navigation > li.is-open > a { background: #1b7f55; border-radius: 8px 8px 0 0; color: #fff; }
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
        .cea-social-links { align-items: center; display: flex; flex-wrap: wrap; gap: 10px; }
        .cea-social-links a { align-items: center; background: #f2c94c; border: 1px solid rgba(255,255,255,.2); border-radius: 999px; color: #063d2a; display: inline-flex; font-size: 16px; font-weight: 900; height: 42px; justify-content: center; width: 42px; }
        .cea-social-links a:hover { background: #fff; color: #1f7a43; }
        .cea-social-links--header { flex-wrap: nowrap; }
        .cea-social-links--header a { background: rgba(255,255,255,.14); color: #fff; height: 38px; width: 38px; }
        .cea-social-links--footer a { background: rgba(255,255,255,.1); color: #fff; }
        .cea-social-links--hero { margin-top: 18px; }
        .mobile-language-switch { align-items: center; display: none; gap: 6px; margin-left: auto; }
        .mobile-language-switch a { align-items: center; background: rgba(255,255,255,.14); border: 1px solid rgba(255,255,255,.2); border-radius: 999px; color: #fff; display: inline-flex; font-size: 12px; font-weight: 900; gap: 4px; min-height: 34px; padding: 6px 9px; }
        .mobile-language-switch a.active { background: #f2c94c; color: #063d2a; }
        .cea-video-hero { align-items: center; background: #063d2a; box-sizing: border-box; color: #fff; display: flex; min-height: 100vh; overflow: hidden; padding: clamp(170px, 19vh, 230px) 0 86px; position: relative; }
        .cea-video-hero::after { background: linear-gradient(90deg, rgba(6,61,42,.88) 0%, rgba(6,61,42,.62) 48%, rgba(6,61,42,.18) 100%); content: ""; inset: 0; position: absolute; z-index: 1; }
        .cea-video-hero__video { height: 100%; inset: 0; object-fit: cover; position: absolute; width: 100%; z-index: 0; }
        .cea-video-hero__content { max-width: 780px; position: relative; z-index: 2; }
        .cea-video-hero__eyebrow { color: #f2c94c; display: block; font-size: 12px; font-weight: 900; margin-bottom: 16px; text-transform: uppercase; }
        .cea-video-hero h1 { color: #fff; font-size: clamp(38px, 5.2vw, 76px); font-weight: 900; letter-spacing: 0; line-height: 1.02; margin-bottom: 20px; max-width: 780px; text-shadow: 0 16px 34px rgba(0,0,0,.36); text-wrap: balance; }
        .cea-video-hero h1 span { background: transparent; color: #fff; line-height: 1.08; padding: 0; }
        .cea-video-hero p { color: rgba(255,255,255,.86); font-size: 16px; line-height: 1.75; margin-bottom: 28px; max-width: 660px; }
        .cea-video-hero__actions { display: flex; flex-wrap: wrap; gap: 12px; }
        .kso-wordmark { align-items: center; background: #fff; border: 1px solid rgba(31,122,67,.14); border-radius: 8px; display: flex; justify-content: center; overflow: hidden; padding: 6px; width: max-content; }
        .kso-wordmark .kso-wordmark__image { display: block; height: 100%; max-height: 100%; object-fit: contain; width: 100%; }
        .kso-wordmark--header { height: 54px; width: 178px; }
        .kso-wordmark--header.kso-wordmark--compact { aspect-ratio: 1 / 1; border-radius: 999px; height: 68px; padding: 7px; width: 68px; }
        .kso-wordmark--header.kso-wordmark--compact .kso-wordmark__image { height: 100%; width: 100%; }
        .kso-wordmark--compact { height: 48px; width: 158px; }
        .kso-wordmark--footer, .kso-wordmark--login { margin-bottom: 18px; }
        .kso-wordmark--footer, .kso-wordmark--login { height: 86px; width: 190px; }
        .kso-wordmark--footer.kso-wordmark--compact { aspect-ratio: 1 / 1; border-radius: 999px; height: 92px; padding: 9px; width: 92px; }
        .kso-wordmark--footer.kso-wordmark--compact .kso-wordmark__image { height: 100%; width: 100%; }
        .kso-wordmark--hero { background: #fff; box-shadow: inset 0 0 0 1px rgba(31,122,67,.1); height: 100%; min-height: 330px; padding: 24px; width: 100%; }
        .kso-wordmark--panel { min-height: inherit; width: 100%; }
        .kso-wordmark--hero .kso-wordmark__image { max-height: 460px; }
        .cea-footer-actions { display: flex; flex-wrap: wrap; gap: 12px; }
        .cea-footer-actions a { align-items: center; background: #f2c94c; border: 1px solid #f2c94c; border-radius: 8px; color: #063d2a; display: inline-flex; font-size: 14px; font-weight: 800; min-height: 46px; padding: 12px 18px; }
        .cea-footer-actions a:hover { background: #fff; border-color: #fff; color: #0f5d3e; }
        .cea-landing-footer { background: #063d2a; padding: 56px 0 24px; }
        .cea-footer-grid { display: grid; gap: 30px; grid-template-columns: 1.4fr repeat(3, 1fr); }
        .cea-footer-brand .kso-wordmark { display: grid; margin-bottom: 16px; max-width: 210px; }
        .cea-landing-footer h3 { color: #fff; font-size: 18px; margin-bottom: 14px; }
        .cea-landing-footer p { color: #c9b3b7; font-size: 15px; line-height: 1.75; margin: 0 0 10px; }
        .cea-landing-footer ul { display: grid; gap: 8px; list-style: none; margin: 0; padding: 0; }
        .cea-landing-footer a { color: rgba(255,255,255,.78); }
        .cea-landing-footer a:hover { color: #f2c94c; }
        .cea-footer-bottom { border-top: 1px solid rgba(255,255,255,.12); color: rgba(255,255,255,.54); margin-top: 32px; padding-top: 18px; }
        .cea-donation-link { align-items: center; background: #f2c94c; border: 0; border-radius: 8px; color: #063d2a; cursor: pointer; display: inline-flex; font-size: 14px; font-weight: 900; min-height: 42px; padding: 10px 16px; }
        .cea-donation-link:hover { background: #fff; color: #063d2a; }
        .cea-donation-modal { align-items: center; background: rgba(0,0,0,.58); display: none; inset: 0; justify-content: center; padding: 22px; position: fixed; z-index: 9999; }
        .cea-donation-modal.is-open { display: flex; }
        .cea-donation-modal__dialog { background: #fff; border-radius: 8px; box-shadow: 0 30px 80px rgba(0,0,0,.32); color: #063d2a; max-width: 430px; padding: 24px; position: relative; width: min(100%, 430px); }
        .cea-donation-modal__close { align-items: center; background: #f6f9e8; border: 0; border-radius: 999px; color: #063d2a; cursor: pointer; display: inline-flex; font-size: 24px; height: 38px; justify-content: center; line-height: 1; position: absolute; right: 14px; top: 14px; width: 38px; }
        .cea-donation-modal__dialog h2 { color: #063d2a; font-size: 25px; line-height: 1.2; margin: 0 42px 10px 0; }
        .cea-donation-modal__dialog p { color: #4f6759; margin-bottom: 16px; }
        .cea-donation-modal__recipient { background: #f6f9e8; border: 1px solid rgba(31,122,67,.14); border-radius: 8px; margin: 0 0 14px; padding: 11px 12px; }
        .cea-donation-modal__recipient span { color: #617468; display: block; font-size: 12px; font-weight: 800; margin-bottom: 2px; text-transform: uppercase; }
        .cea-donation-modal__recipient strong { color: #063d2a; display: block; font-size: 16px; line-height: 1.35; }
        .cea-qris-image-wrap { background: #f6f9e8; border: 1px solid rgba(31,122,67,.16); border-radius: 8px; margin-bottom: 14px; padding: 12px; }
        .cea-qris-image { aspect-ratio: 1 / 1; background: #fff; border-radius: 6px; display: block; object-fit: contain; width: 100%; }
        .cea-qris-placeholder { align-items: center; aspect-ratio: 1 / 1; background: repeating-linear-gradient(45deg, #f6f9e8 0 12px, #fff 12px 24px); border: 1px dashed #9ebc91; border-radius: 8px; color: #1f7a43; display: flex; font-weight: 900; justify-content: center; margin-bottom: 14px; text-align: center; }
        .cea-donation-modal__note { background: #f6f9e8; border-radius: 8px; color: #405d4a; font-size: 13px; line-height: 1.55; padding: 12px; }
        .cea-section { padding: 86px 0; }
        .cea-kicker { color: var(--cea-red); display: block; font-size: 13px; font-weight: 900; margin-bottom: 12px; text-transform: uppercase; }
        .cea-card-grid { display: grid; gap: 22px; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); }
        .cea-card { background: #fff; border: 1px solid rgba(31,122,67,.14); border-radius: 8px; padding: 26px; }
        .cea-card h3, .cea-card h2 { color: var(--cea-dark); margin-bottom: 12px; }
        .cea-card p { color: var(--cea-muted); line-height: 1.7; }
        .home-hero { background: linear-gradient(135deg, #063d2a 0%, #1f7a43 64%, #7b8f23 100%); color: #fff; padding: 92px 0 76px; }
        .home-hero__grid { align-items: center; display: grid; gap: 48px; grid-template-columns: minmax(0, .88fr) minmax(340px, 1fr); }
        .home-hero h1 { color: #fff; font-size: clamp(46px, 7vw, 92px); font-weight: 900; line-height: .98; margin-bottom: 24px; }
        .home-hero p { color: rgba(255,255,255,.84); font-size: 18px; line-height: 1.75; margin-bottom: 28px; }
        .home-hero__wordmark, .home-hero__image { border-radius: 8px; box-shadow: 0 24px 70px rgba(0,0,0,.22); min-height: 320px; width: 100%; }
        .home-hero__image { aspect-ratio: 16 / 10; display: block; min-height: 0; object-fit: cover; }
        @if (request()->is('admin*'))
            .cea-admin-panel { background: #f4f7f4; min-height: 100vh; padding: 34px 0 54px; }
            .admin-shell { display: grid; gap: 24px; grid-template-columns: 280px minmax(0, 1fr); margin: 0 auto; max-width: 1320px; padding: 0 20px; }
            .admin-sidebar { align-self: start; background: #102f22; border: 1px solid rgba(255,255,255,.08); border-radius: 8px; color: #fff; overflow: hidden; position: sticky; top: 92px; }
            .admin-sidebar__brand { border-bottom: 1px solid rgba(255,255,255,.1); padding: 20px; }
            .admin-sidebar__brand span, .admin-eyebrow { display: block; font-size: 12px; font-weight: 700; letter-spacing: 0; text-transform: uppercase; }
            .admin-sidebar__brand strong { display: block; font-size: 14px; font-weight: 600; margin-top: 6px; opacity: .72; }
            .admin-sidebar__brand small { color: rgba(255,255,255,.68); display: block; font-size: 12px; line-height: 1.45; margin-top: 8px; }
            .admin-sidebar__nav { display: flex; flex-direction: column; padding: 12px; }
            .admin-sidebar__nav a, .admin-sidebar__nav-label { border-radius: 8px; color: rgba(255,255,255,.78); display: block; font-size: 13px; font-weight: 700; line-height: 1.25; padding: 10px 12px; text-transform: uppercase; }
            .admin-sidebar__nav-label { color: rgba(255,255,255,.54); cursor: default; }
            .admin-sidebar__nav a:hover, .admin-sidebar__nav a.active, .admin-sidebar__nav-label.active { background: #f3aa3d; color: #102f22; }
            .admin-sidebar__row { align-items: stretch; display: grid; gap: 6px; grid-template-columns: minmax(0, 1fr) auto; }
            .admin-sidebar__row > a, .admin-sidebar__row > .admin-sidebar__nav-label { min-width: 0; }
            .admin-sidebar__toggle { align-items: center; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.1); border-radius: 8px; color: rgba(255,255,255,.78); display: inline-flex; justify-content: center; min-height: 38px; padding: 0; width: 38px; }
            .admin-sidebar__toggle:hover { background: rgba(243,170,61,.2); border-color: rgba(243,170,61,.35); color: #fff; }
            .admin-sidebar__toggle span[aria-hidden="true"] { border-bottom: 2px solid currentColor; border-right: 2px solid currentColor; display: block; height: 8px; transform: rotate(45deg) translateY(-2px); transition: transform .18s ease; width: 8px; }
            .admin-sidebar__group.is-open > .admin-sidebar__row .admin-sidebar__toggle span[aria-hidden="true"] { transform: rotate(225deg) translateY(-2px); }
            .admin-sidebar__children { border-left: 1px solid rgba(255,255,255,.12); display: grid; gap: 2px; margin: 2px 0 8px 12px; padding-left: 8px; }
            .admin-sidebar__children[hidden] { display: none; }
            .admin-sidebar__children a, .admin-sidebar__children .admin-sidebar__nav-label { font-size: 12px; font-weight: 600; text-transform: none; }
            .sr-only { border: 0; clip: rect(0,0,0,0); height: 1px; margin: -1px; overflow: hidden; padding: 0; position: absolute; white-space: nowrap; width: 1px; }
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
            .admin-card, .admin-table-card, .admin-form-card { background: #fff; border: 1px solid rgba(31,122,67,.14); border-radius: 8px; padding: 24px; }
            .admin-card__label, .admin-status { color: var(--cea-red); font-size: 12px; font-weight: 900; text-transform: uppercase; }
            .admin-card__actions, .admin-form-actions { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 18px; }
            .admin-button, .admin-source-link { align-items: center; background: #1b5e3b; border: 1px solid #1b5e3b; border-radius: 8px; color: #fff; display: inline-flex; font-size: 13px; font-weight: 700; justify-content: center; min-height: 40px; padding: 10px 14px; text-align: center; white-space: nowrap; }
            .admin-button.secondary { background: #fff; border-color: #cfdacf; color: #102f22; }
            .admin-source-link:hover, .admin-button:hover { background: #123f29; border-color: #123f29; color: #fff; }
            .admin-section-spacer { margin-top: 24px; }
            .admin-table { margin: 0; width: 100%; }
            .admin-table th, .admin-table td { border-bottom: 1px solid #eee2d7; padding: 14px; vertical-align: top; }
            .admin-inline-actions { align-items: center; display: flex; flex-wrap: wrap; gap: 10px; }
            .admin-inline-actions form { margin: 0; }
            .admin-inline-actions button { background: transparent; border: 0; color: #b23b27; font-weight: 800; padding: 0; }
            .admin-field { margin-bottom: 16px; }
            .admin-field label { display: block; font-weight: 800; margin-bottom: 8px; }
            .admin-field input, .admin-field textarea, .admin-field select { border: 1px solid #e5d7ca; border-radius: 8px; min-height: 44px; padding: 10px 12px; width: 100%; }
            .admin-field textarea { min-height: 130px; }
            .admin-check-field label { align-items: center; display: flex; gap: 10px; }
            .admin-check-field input { min-height: 0; width: auto; }
        @endif
        @media (max-width: 767px) {
            .home-hero__grid { grid-template-columns: 1fr; }
            .cea-video-hero { align-items: end; min-height: 100svh; padding: 150px 0 54px; }
            .cea-video-hero__content { max-width: 100%; }
            .cea-video-hero__eyebrow { display: none; }
            .cea-video-hero h1 { font-size: clamp(30px, 11vw, 46px); line-height: 1.08; margin-bottom: 16px; }
            .cea-video-hero h1 span { line-height: 1.12; padding: 0; }
            .cea-video-hero p { font-size: 14px; line-height: 1.65; margin-bottom: 20px; max-width: 100%; }
            .cea-video-hero__actions { gap: 10px; }
            .cea-video-hero__actions .cea-btn { font-size: 13px; min-height: 42px; padding: 0 14px; }
        }
        @media (max-width: 991px) {
            .tgmenu__action { margin-left: auto; }
            .header__top-logo { display: none !important; }
            .mobile-language-switch { display: inline-flex; }
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
                            <form action="{{ route('blog.index') }}" method="GET">
                                <input type="search" name="q" value="{{ request('q') }}" placeholder="{{ $ui['search_placeholder'] ?? 'Cari kabar, rilis, dan referensi...' }}">
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-4 order-0 order-lg-2 d-none d-lg-block">
                        <div class="header__top-logo logo text-lg-center">
                            <a href="{{ route('home') }}" class="cea-logo-image-link">
                                @include('layouts.kso-wordmark', ['variant' => 'header', 'compact' => true])
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-3 col-sm-6 order-3 d-none d-sm-block">
                        <div class="header__top-right">
                            <ul class="list-wrap">
                                @if (! empty($socialLinks ?? []))
                                    <li>@include('layouts.social-links', ['links' => $socialLinks, 'variant' => 'header'])</li>
                                @endif
                                <li class="lang">
                                    <div class="dropdown">
                                        <button class="dropdown-toggle" type="button">{{ strtoupper($currentLocale ?? 'id') }}</button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item {{ ($currentLocale ?? 'id') === 'en' ? 'active' : '' }}" href="{{ route('language.switch', 'en') }}">EN</a></li>
                                            <li><a class="dropdown-item {{ ($currentLocale ?? 'id') === 'id' ? 'active' : '' }}" href="{{ route('language.switch', 'id') }}">ID</a></li>
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
                                <div class="mobile-language-switch" aria-label="Language">
                                    <a class="{{ ($currentLocale ?? 'id') === 'id' ? 'active' : '' }}" href="{{ route('language.switch', 'id') }}"><span aria-hidden="true">🇮🇩</span>ID</a>
                                    <a class="{{ ($currentLocale ?? 'id') === 'en' ? 'active' : '' }}" href="{{ route('language.switch', 'en') }}"><span aria-hidden="true">🇬🇧</span>EN</a>
                                </div>
                                <div class="tgmenu__action">
                                    <ul class="list-wrap">
                                        <li class="header-search">
                                            <a href="#"><i class="far fa-search"></i></a>
                                            <div class="header-search-form">
                                                <form action="{{ route('blog.index') }}" method="GET">
                                                    <input type="search" name="q" value="{{ request('q') }}" placeholder="{{ $ui['search_content_placeholder'] ?? 'Cari konten Pooling Fund - KSO...' }}">
                                                </form>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                            <button class="mobile-nav-toggler" type="button" aria-label="{{ $ui['open_menu'] ?? 'Buka menu' }}" aria-controls="mobile-menu" aria-expanded="false"><i class="fas fa-bars"></i></button>
                        </div>
                        <nav class="cea-mobile-menu d-lg-none" id="mobile-menu" aria-label="{{ $ui['mobile_menu'] ?? 'Menu mobile' }}">
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

                const color = utils.get($container, 'color') || '#f2c94c';
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
            var openMenuLabel = @json($ui['open_menu'] ?? 'Buka menu');
            var closeMenuLabel = @json($ui['close_menu'] ?? 'Tutup menu');

            function closeDropdowns(scope) {
                (scope || document).querySelectorAll('.menu-item-has-children.is-open').forEach(function (item) {
                    item.classList.remove('is-open');
                    var trigger = item.querySelector(':scope > a[aria-expanded]');
                    if (trigger) trigger.setAttribute('aria-expanded', 'false');
                });
            }

            function bindDropdown(scope) {
                if (!scope) return;

                var isMobileMenu = scope.classList.contains('cea-mobile-menu');

                scope.querySelectorAll('.menu-item-has-children > a').forEach(function (trigger) {
                    trigger.addEventListener('click', function (event) {
                        var item = trigger.parentElement;
                        if (!item) return;

                        var href = trigger.getAttribute('href') || '';
                        var hasRealHref = href && href !== '#';
                        if (!isMobileMenu && item.classList.contains('is-open') && hasRealHref) {
                            return;
                        }

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
                    mobileToggle.setAttribute('aria-label', isOpen ? closeMenuLabel : openMenuLabel);
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
                            mobileToggle.setAttribute('aria-label', openMenuLabel);
                        }
                    }
                }
            });

            var donationModal = document.querySelector('[data-donation-modal]');
            var donationOpenButtons = document.querySelectorAll('[data-donation-open]');
            var donationClose = document.querySelector('[data-donation-close]');

            function closeDonationModal() {
                if (!donationModal) return;
                donationModal.classList.remove('is-open');
                donationModal.setAttribute('aria-hidden', 'true');
            }

            if (donationModal && donationOpenButtons.length) {
                donationOpenButtons.forEach(function (donationOpen) {
                    donationOpen.addEventListener('click', function () {
                        donationModal.classList.add('is-open');
                        donationModal.setAttribute('aria-hidden', 'false');
                        if (donationClose) donationClose.focus();
                    });
                });

                donationModal.addEventListener('click', function (event) {
                    if (event.target === donationModal) {
                        closeDonationModal();
                    }
                });
            }

            if (donationClose) {
                donationClose.addEventListener('click', closeDonationModal);
            }

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeDonationModal();
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
                var wordmarks = Array.prototype.slice.call(document.querySelectorAll('.cea-landing-hero__visual .kso-wordmark--hero'));
                if (!wordmarks.length || typeof animeGlobal.stagger !== 'function') return;

                var started = new WeakSet();

                function startWordmark(wordmark, index) {
                    if (started.has(wordmark)) return;
                    started.add(wordmark);

                    var squares = wordmark.querySelectorAll('.kso-wordmark__square');
                    var textParts = wordmark.querySelectorAll('.kso-wordmark__eyebrow, .kso-wordmark strong, .kso-wordmark__tagline');
                    var grid = [11, 4];
                    if (!squares.length && !textParts.length) return;

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
    @if (request()->is('admin*'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('[data-admin-sidebar-toggle]').forEach(function (button) {
                    button.addEventListener('click', function () {
                        var panelId = button.getAttribute('aria-controls');
                        var panel = panelId ? document.getElementById(panelId) : null;
                        var group = button.closest('.admin-sidebar__group');
                        var isOpen = button.getAttribute('aria-expanded') === 'true';

                        button.setAttribute('aria-expanded', isOpen ? 'false' : 'true');

                        if (panel) {
                            panel.hidden = isOpen;
                        }

                        if (group) {
                            group.classList.toggle('is-open', !isOpen);
                        }
                    });
                });
            });
        </script>
    @endif
    @stack('scripts')
</body>
</html>
