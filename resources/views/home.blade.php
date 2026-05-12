@extends('layouts.app')

@section('title', config('app.name'))

@php
    $images = [
        'header' => asset('assets/img/cea/campur.png'),
        'collective' => asset('assets/img/cea/campur.png'),
        'governance' => asset('assets/img/cea/tatakelola.png'),
        'structure' => asset('assets/img/cea/struktur_gerak.png'),
        'forum' => asset('assets/img/cea/pomelli_bdna_image_0510%20%285%29.png'),
        'action' => asset('assets/img/cea/pomelli_bdna_image_0510%20%286%29.png'),
        'study' => asset('assets/img/cea/pomelli_bdna_image_0510%20%287%29.png'),
    ];
    $focusAreas = [
        ['title' => 'Mandat Kolektif', 'description' => 'Satu mandat bersama untuk memperkuat kepemimpinan lokal dan respon kemanusiaan yang berkeadilan.', 'image' => $images['action'], 'href' => '/profil/mandat-visi-nilai'],
        ['title' => 'Tanpa Badan Hukum Baru', 'description' => 'Platform kerja sama operasional antar CSO yang menjaga kedaulatan organisasi anggota.', 'image' => $images['collective'], 'href' => '/profil/riwayat'],
        ['title' => 'Local First', 'description' => 'Keputusan dan sumber daya diarahkan sedekat mungkin dengan komunitas yang menghadapi krisis.', 'image' => $images['forum'], 'href' => '/profil/tujuan-prinsip'],
    ];
    $governanceItems = [
        ['label' => 'Arsitektur Mandat', 'title' => 'Simpul regional otonom terhubung dalam satu visi kepemimpinan lokal.', 'description' => 'Forum Anggota memegang mandat kolektif dengan prinsip one organization, one vote, sementara fungsi strategis dan operasional dipisahkan untuk menjaga akuntabilitas.', 'image' => $images['structure'], 'href' => '/profil/struktur-gerak'],
        ['label' => 'Tata Kelola Sumber Daya', 'title' => 'Dana dikelola sebagai mandat kolektif, bukan aset lembaga.', 'description' => 'Pengambilan keputusan dilakukan oleh mereka yang paling dekat dengan krisis agar respon cepat, transparan, dan relevan dengan kebutuhan komunitas.', 'image' => $images['governance'], 'href' => '/profil/sumber-daya'],
    ];
    $stats = [
        ['value' => '1', 'label' => 'Mandat kolektif'],
        ['value' => '7', 'label' => 'Simpul regional'],
        ['value' => '33', 'label' => 'Anggota tercatat'],
    ];
    $sectionImage = [
        'profil' => $images['structure'],
        'regio' => $images['collective'],
        'siar' => $images['forum'],
        'aksi' => $images['study'],
        'koneksi' => $images['governance'],
    ];
    $dropdownSections = collect($navigation)->filter(fn ($item) => ! empty($item['children']))->values();
    $principles = ['Satu CSO satu suara', 'Berbasis kebutuhan komunitas', 'Kecepatan sebagai nilai utama', 'Transparansi sebagai aset strategis', 'Akuntabilitas kolektif', 'Local leadership & local first'];
@endphp

@push('styles')
<style>
    .cea-landing-hero { background: radial-gradient(circle at 80% 10%, rgba(232,93,74,.34), transparent 32%), linear-gradient(135deg, #2a0710 0%, #5b0f1a 54%, #7a1626 100%); color: #fff; overflow: hidden; padding: 78px 0 86px; }
    .cea-landing-hero__grid { align-items: center; display: grid; gap: 48px; grid-template-columns: minmax(0, .82fr) minmax(420px, 1fr); }
    .cea-landing-hero__eyebrow, .cea-section__head span, .cea-governance-card__body span { color: #f2b66d; display: block; font-size: 13px; font-weight: 900; margin-bottom: 18px; text-transform: uppercase; }
    .cea-landing-hero h1 { color: #fff; font-family: var(--tg-heading-font-family); font-size: clamp(52px, 6.8vw, 96px); font-weight: 900; letter-spacing: 0; line-height: .94; margin-bottom: 22px; max-width: 860px; text-transform: none; text-wrap: balance; }
    .cea-landing-hero p { color: rgba(255,255,255,.82); font-size: 18px; line-height: 1.75; margin-bottom: 30px; max-width: 640px; }
    .cea-landing-hero__actions { display: flex; flex-wrap: wrap; gap: 12px; }
    .cea-landing-hero__visual { align-items: center; background: #fff8f5; border-radius: 8px; box-shadow: 0 34px 80px rgba(42,7,16,.36); display: flex; min-height: 330px; overflow: hidden; padding: 28px; }
    .cea-landing-hero__visual img, .cea-focus-card__image img, .cea-governance-card__media img, .cea-menu-card__image img { display: block; height: auto; width: 100%; }
    .cea-section { background: #fff; padding: 76px 0; }
    .cea-section--soft { background: #fff4f2; }
    .cea-section__head { margin-bottom: 32px; max-width: 820px; }
    .cea-section__head span { color: #b91c31; margin-bottom: 9px; }
    .cea-section__head h2 { color: #3a0710; font-size: clamp(28px, 3.4vw, 46px); line-height: 1.12; margin: 0; }
    .cea-focus-grid, .cea-menu-grid { display: grid; gap: 22px; grid-template-columns: repeat(3, minmax(0, 1fr)); }
    .cea-focus-card, .cea-governance-card, .cea-menu-card { background: #fff; border: 1px solid #efd0d0; border-radius: 8px; box-shadow: 0 18px 44px rgba(75,11,23,.08); overflow: hidden; }
    .cea-focus-card__image, .cea-menu-card__image { aspect-ratio: 16 / 10; background: #fff4f2; overflow: hidden; }
    .cea-focus-card__image img, .cea-menu-card__image img { height: 100%; object-fit: cover; }
    .cea-focus-card__body, .cea-menu-card__body, .cea-governance-card__body { padding: 24px; }
    .cea-focus-card h3, .cea-governance-card h3, .cea-menu-card h3 { color: #3a0710; font-size: 24px; font-weight: 900; line-height: 1.15; margin-bottom: 12px; }
    .cea-focus-card p, .cea-governance-card p, .cea-menu-card p { color: #67464b; font-size: 15px; line-height: 1.75; margin: 0; }
    .cea-focus-card__body a { color: #b91c31; display: inline-flex; font-weight: 900; margin-top: 16px; }
    .cea-principles { background: #fff; padding: 72px 0; }
    .cea-principles__grid { display: grid; gap: 14px; grid-template-columns: repeat(3, minmax(0, 1fr)); }
    .cea-principle { background: #fff4f2; border: 1px solid #efd0d0; border-radius: 8px; color: #3a0710; font-weight: 900; padding: 18px; }
    .cea-stats { background: #4b0b17; padding: 40px 0; }
    .cea-stats__grid { display: grid; gap: 18px; grid-template-columns: repeat(3, minmax(0, 1fr)); }
    .cea-stat { border: 1px solid rgba(255,255,255,.16); border-radius: 8px; color: #fff; padding: 22px; }
    .cea-stat strong { color: #f2b66d; display: block; font-size: 48px; font-weight: 900; line-height: 1; margin-bottom: 8px; }
    .cea-stat span { color: rgba(255,255,255,.78); font-size: 14px; font-weight: 800; }
    .cea-governance-grid { display: grid; gap: 24px; grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .cea-governance-card__media { background: #fff; padding: 18px; }
    .cea-governance-card__body span { color: #b91c31; margin-bottom: 10px; }
    .cea-governance-card__body a, .cea-menu-card__body a { color: #b91c31; font-weight: 900; }
    .cea-menu-card__body ul { display: grid; gap: 8px; list-style: none; margin: 18px 0 0; padding: 0; }
    @media (max-width: 991px) {
        .cea-landing-hero__grid, .cea-governance-grid { grid-template-columns: 1fr; }
        .cea-focus-grid, .cea-menu-grid, .cea-stats__grid, .cea-principles__grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<section class="cea-landing-hero">
    <div class="container">
        <div class="cea-landing-hero__grid">
            <div class="cea-landing-hero__content">
                <span class="cea-landing-hero__eyebrow">Menguatkan Lokal, Memperluas Dampak</span>
                <h1 class="cea-scramble-title">Pooling Fund - KSO.</h1>
                <p>Perubahan besar tidak lahir dari satu lembaga, tapi dari ekosistem yang terhubung. Pooling Fund - KSO menghimpun dan menyalurkan dana kemanusiaan secara bersama, berbasis kebutuhan komunitas dan kepemimpinan lokal, tanpa membentuk badan hukum baru.</p>
                <div class="cea-landing-hero__actions">
                    <a class="cea-btn" href="/profil/mandat-visi-nilai">Baca Mandat</a>
                    <a class="cea-btn secondary" href="/regio/simpul">Lihat Simpul</a>
                </div>
            </div>
            <div class="cea-landing-hero__visual" aria-label="Gambar header {{ config('app.name') }}">
                <img src="{{ $images['header'] }}" alt="{{ config('app.name') }}">
            </div>
        </div>
    </div>
</section>

<section class="cea-section">
    <div class="container">
        <div class="cea-section__head">
            <span>Platform Mandat Kolektif</span>
            <h2>Ekosistem yang menghubungkan sumber daya, komunitas, dan respon kemanusiaan.</h2>
        </div>
        <div class="cea-focus-grid">
            @foreach ($focusAreas as $item)
                <article class="cea-focus-card">
                    <div class="cea-focus-card__image"><img src="{{ $item['image'] }}" alt="{{ $item['title'] }}"></div>
                    <div class="cea-focus-card__body">
                        <h3>{{ $item['title'] }}</h3>
                        <p>{{ $item['description'] }}</p>
                        <a href="{{ $item['href'] }}">Pelajari</a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="cea-stats">
    <div class="container">
        <div class="cea-stats__grid">
            @foreach ($stats as $item)
                <div class="cea-stat"><strong>{{ $item['value'] }}</strong><span>{{ $item['label'] }}</span></div>
            @endforeach
        </div>
    </div>
</section>

<section class="cea-principles">
    <div class="container">
        <div class="cea-section__head">
            <span>Prinsip & Karakter</span>
            <h2>Kepercayaan dibangun lewat kesetaraan, transparansi, dan akuntabilitas kolektif.</h2>
        </div>
        <div class="cea-principles__grid">
            @foreach ($principles as $principle)
                <div class="cea-principle">{{ $principle }}</div>
            @endforeach
        </div>
    </div>
</section>

<section class="cea-section cea-section--soft">
    <div class="container">
        <div class="cea-section__head">
            <span>Struktur & Tata Kelola</span>
            <h2>Gerak kolektif ditopang oleh arsitektur mandat dan tata kelola sumber daya.</h2>
        </div>
        <div class="cea-governance-grid">
            @foreach ($governanceItems as $item)
                <article class="cea-governance-card">
                    <div class="cea-governance-card__media"><img src="{{ $item['image'] }}" alt="{{ $item['label'] }}"></div>
                    <div class="cea-governance-card__body">
                        <span>{{ $item['label'] }}</span>
                        <h3>{{ $item['title'] }}</h3>
                        <p>{{ $item['description'] }}</p>
                        <a href="{{ $item['href'] }}">Baca selengkapnya</a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="cea-section">
    <div class="container">
        <div class="cea-section__head">
            <span>Navigasi Utama</span>
            <h2>Konten website diringkas sesuai mandat Pooling Fund - KSO.</h2>
        </div>
        <div class="cea-menu-grid">
            @foreach ($dropdownSections as $section)
                <article class="cea-menu-card">
                    <div class="cea-menu-card__image">
                        <img src="{{ $sectionImage[$section['key']] ?? $images['collective'] }}" alt="{{ $section['label'] }}">
                    </div>
                    <div class="cea-menu-card__body">
                        <h3>{{ $section['label'] }}</h3>
                        <p>{{ $section['description'] }}</p>
                        <ul>
                            @foreach (array_slice($section['children'], 0, 5) as $item)
                                <li><a href="{{ $item['publicHref'] ?? $item['href'] }}">{{ $item['label'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

@endsection
