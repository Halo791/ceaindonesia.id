@extends('layouts.app')

@section('title', $content['title'] === config('app.name') ? config('app.name') : $content['title'].' - '.config('app.name'))

@push('styles')
<style>
    .public-hero {}
    .public-hero__grid {
        align-items: center;
        display: grid;
        gap: 44px;
        grid-template-columns: minmax(0, .9fr) minmax(340px, 1fr);
    }
    .public-hero__eyebrow,
    .public-section__head span,
    .public-card span {
        color: #f2c94c;
        display: block;
        font-size: 13px;
        font-weight: 900;
        margin-bottom: 14px;
        text-transform: uppercase;
    }
    .public-hero h1 {
        color: #fff;
        font-size: clamp(48px, 7vw, 92px);
        font-weight: 900;
        letter-spacing: 0;
        line-height: .96;
        margin-bottom: 22px;
    }
    .public-hero p {
        color: rgba(255,255,255,.84);
        font-size: 18px;
        line-height: 1.75;
        margin-bottom: 28px;
        max-width: 720px;
    }
    .public-hero__visual { display: none; }
    .public-section {
        background: #fff;
        padding: 76px 0;
    }
    .public-layout {
        display: grid;
        gap: 30px;
        grid-template-columns: minmax(0, 1fr) 320px;
    }
    .public-body {
        color: #405d4a;
        font-size: 17px;
        line-height: 1.85;
    }
    .public-body p { margin-bottom: 18px; }
    .public-card-grid {
        display: grid;
        gap: 18px;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        margin-top: 34px;
    }
    .public-card,
    .public-sidebar {
        background: #fff;
        border: 1px solid #dfe9c9;
        border-radius: 8px;
        box-shadow: 0 18px 44px rgba(6,61,42,.08);
        padding: 22px;
    }
    .public-card h3 {
        color: #063d2a;
        font-size: 21px;
        margin: 0;
    }
    .public-update-grid {
        display: grid;
        gap: 18px;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        margin-top: 36px;
    }
    .public-update-card {
        background: #fff;
        border: 1px solid #dfe9c9;
        border-radius: 8px;
        box-shadow: 0 18px 44px rgba(6,61,42,.08);
        overflow: hidden;
    }
    .public-update-card__image {
        display: block;
    }
    .public-update-card img {
        aspect-ratio: 16 / 9;
        display: block;
        object-fit: cover;
        width: 100%;
    }
    .public-update-card__body { padding: 18px; }
    .public-update-card__body span {
        color: #1f7a43;
        display: block;
        font-size: 12px;
        font-weight: 900;
        margin-bottom: 8px;
        text-transform: uppercase;
    }
    .public-update-card__body h3 {
        color: #063d2a;
        font-size: 19px;
        line-height: 1.25;
        margin-bottom: 10px;
    }
    .public-update-card__body p {
        color: #4f6759;
        font-size: 14px;
        line-height: 1.65;
        margin-bottom: 14px;
    }
    .public-update-card__body a {
        color: #b85f14;
        font-weight: 900;
    }
    .public-sidebar {
        align-self: start;
        position: sticky;
        top: 100px;
    }
    .public-sidebar h2 {
        color: #063d2a;
        font-size: 20px;
        margin-bottom: 14px;
    }
    .public-sidebar ul {
        display: grid;
        gap: 8px;
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .public-sidebar li ul {
        border-left: 1px solid #dfe9c9;
        margin: 8px 0 2px 10px;
        padding-left: 10px;
    }
    .public-sidebar a {
        background: #f6f9e8;
        border-radius: 8px;
        color: #1f7a43;
        display: block;
        font-weight: 800;
        padding: 10px 12px;
    }
    .public-sidebar a:hover { background: #f2c94c; color: #063d2a; }
    .member-network {
        margin-top: 34px;
    }
    .member-network__overview {
        display: grid;
        gap: 14px;
        grid-template-columns: minmax(0, 1.15fr) repeat(3, minmax(150px, .7fr));
        margin-bottom: 22px;
    }
    .member-network__hub,
    .member-network__stat {
        border-radius: 8px;
        padding: 22px;
    }
    .member-network__hub {
        background: linear-gradient(135deg, #063d2a, #1f7a43);
        color: #fff;
        overflow: hidden;
        position: relative;
    }
    .member-network__hub::after {
        background: radial-gradient(circle, rgba(242,201,76,.35), transparent 62%);
        content: "";
        height: 180px;
        position: absolute;
        right: -48px;
        top: -64px;
        width: 180px;
    }
    .member-network__hub span,
    .member-network__stat span,
    .region-node__meta {
        display: block;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: 0;
        text-transform: uppercase;
    }
    .member-network__hub span {
        color: #f2c94c;
        margin-bottom: 8px;
        position: relative;
        z-index: 1;
    }
    .member-network__hub strong {
        display: block;
        font-size: clamp(28px, 4vw, 42px);
        font-weight: 900;
        line-height: 1;
        position: relative;
        z-index: 1;
    }
    .member-network__hub p {
        color: rgba(255,255,255,.78);
        line-height: 1.65;
        margin: 12px 0 0;
        position: relative;
        z-index: 1;
    }
    .member-network__stat {
        background: #f6f9e8;
        border: 1px solid #dfe9c9;
    }
    .member-network__stat span {
        color: #1f7a43;
        margin-bottom: 10px;
    }
    .member-network__stat strong {
        color: #063d2a;
        display: block;
        font-size: 38px;
        font-weight: 900;
        line-height: 1;
    }
    .member-network__map {
        background:
            radial-gradient(circle at 50% 18%, rgba(242,201,76,.18), transparent 28%),
            linear-gradient(180deg, #fbfff3 0%, #fff 100%);
        border: 1px solid #dfe9c9;
        border-radius: 8px;
        box-shadow: 0 22px 60px rgba(6,61,42,.08);
        overflow: hidden;
        padding: 28px;
        position: relative;
    }
    .member-network__map::before {
        background:
            linear-gradient(90deg, transparent 49.75%, rgba(31,122,67,.18) 49.75%, rgba(31,122,67,.18) 50.25%, transparent 50.25%),
            linear-gradient(0deg, transparent 49.75%, rgba(31,122,67,.14) 49.75%, rgba(31,122,67,.14) 50.25%, transparent 50.25%);
        content: "";
        inset: 38px;
        opacity: .55;
        position: absolute;
    }
    .member-network__center {
        background: #063d2a;
        border: 4px solid #f2c94c;
        border-radius: 8px;
        color: #fff;
        margin: 0 auto 24px;
        max-width: 330px;
        padding: 20px;
        position: relative;
        text-align: center;
        z-index: 1;
    }
    .member-network__center span {
        color: #f2c94c;
        display: block;
        font-size: 12px;
        font-weight: 900;
        margin-bottom: 8px;
        text-transform: uppercase;
    }
    .member-network__center strong {
        display: block;
        font-size: 28px;
        font-weight: 900;
        line-height: 1.08;
    }
    .member-network__regions {
        display: grid;
        gap: 16px;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        position: relative;
        z-index: 1;
    }
    .region-node {
        background: rgba(255,255,255,.94);
        border: 1px solid rgba(31,122,67,.18);
        border-radius: 8px;
        box-shadow: 0 14px 34px rgba(6,61,42,.08);
        display: flex;
        flex-direction: column;
        min-height: 100%;
        padding: 18px;
    }
    .region-node__top {
        align-items: flex-start;
        display: flex;
        gap: 12px;
        margin-bottom: 14px;
    }
    .region-node__badge {
        align-items: center;
        background: #f2c94c;
        border-radius: 8px;
        color: #063d2a;
        display: inline-flex;
        flex: 0 0 46px;
        font-size: 22px;
        font-weight: 900;
        height: 46px;
        justify-content: center;
        line-height: 1;
    }
    .region-node__meta {
        color: #1f7a43;
        margin-bottom: 6px;
    }
    .region-node h3 {
        color: #063d2a;
        font-size: 18px;
        font-weight: 900;
        line-height: 1.22;
        margin: 0;
    }
    .region-node p {
        color: #4f6759;
        font-size: 14px;
        line-height: 1.65;
        margin-bottom: 14px;
    }
    .region-node__members {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: auto;
    }
    .region-node__member {
        background: #f6f9e8;
        border: 1px solid #dfe9c9;
        border-radius: 999px;
        color: #063d2a;
        font-size: 12px;
        font-weight: 800;
        line-height: 1.35;
        padding: 7px 10px;
    }
    .region-node--pending {
        background: rgba(246,249,232,.86);
        border-style: dashed;
    }
    .region-node--pending .region-node__badge {
        background: #dfe9c9;
    }
    @media (max-width: 991px) {
        .public-hero__grid,
        .public-layout { grid-template-columns: 1fr; }
        .public-sidebar { position: static; }
        .member-network__overview { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 575px) {
        .member-network__overview,
        .member-network__regions { grid-template-columns: 1fr; }
        .member-network__map { padding: 18px; }
        .member-network__map::before { inset: 22px; }
    }
</style>
@endpush

@php
    $contentImagePath = $content['image_path'] ?? '';
    $fallbackImages = [
        asset('assets/img/lapangan/pkbi-aceh-dukungan-psikososial.jpeg'),
        asset('assets/img/lapangan/pkbi-aceh-karya-anak.jpeg'),
        asset('assets/img/lapangan/walhi-sumut-tandon-air-1.jpeg'),
        asset('assets/img/lapangan/walhi-sumut-tandon-air-2.jpeg'),
        asset('assets/img/lapangan/walhi-sumbar-distribusi-logistik.jpeg'),
    ];
    $fallbackIndex = abs(crc32($content['title'] ?? config('app.name'))) % count($fallbackImages);
    $heroImagePath = ($contentImagePath === '' || strpos($contentImagePath, 'assets/img/cea/') !== false)
        ? $fallbackImages[$fallbackIndex]
        : $contentImagePath;
    $showMemberDiagram = ($section['key'] ?? null) === 'regio' && ($item['key'] ?? null) === 'anggota';
    $simpulRegions = collect(config('cea.simpul_regions', []));
    $totalMembers = $simpulRegions->sum(fn ($region) => count($region['members'] ?? []));
    $activeRegions = $simpulRegions->filter(fn ($region) => ! empty($region['members'] ?? []))->count();
    $pendingRegions = max($simpulRegions->count() - $activeRegions, 0);
@endphp

@section('content')
<section class="public-hero cea-video-hero">
    <video class="cea-video-hero__video" autoplay muted loop playsinline preload="metadata">
        <source src="{{ asset('assets/img/cea/video.mp4') }}" type="video/mp4">
    </video>
    <div class="container">
        <div class="public-hero__grid">
            <div class="cea-video-hero__content">
                <span class="public-hero__eyebrow cea-video-hero__eyebrow">{{ $content['eyebrow'] ?? $section['label'] }}</span>
                <h1 class="cea-scramble-title"><span>{{ $content['title'] }}</span></h1>
                <p>{{ $content['subtitle'] }}</p>
                <!-- <div class="cea-footer-actions">
                    @if (! empty($content['source_href']))
                        <a href="{{ $content['source_href'] }}" target="_blank" rel="noreferrer">Sumber Resmi</a>
                    @endif
                </div> -->
            </div>
        </div>
    </div>
</section>

<section class="public-section">
    <div class="container public-layout">
        <article>
            <div class="public-section__head">
                <span>{{ $item ? $section['label'] : 'Ringkasan' }}</span>
                <h2>{{ $content['title'] }}</h2>
            </div>
            <div class="public-body">
                @foreach (preg_split("/\r\n|\n|\r/", $content['body']) as $paragraph)
                    @if (trim($paragraph) !== '')
                        <p>{{ $paragraph }}</p>
                    @endif
                @endforeach
            </div>

            @if ($showMemberDiagram)
                <div class="member-network" aria-label="Diagram simpul dan anggota Pooling Fund KSO">
                    <div class="member-network__overview">
                        <div class="member-network__hub">
                            <span>Diagram Relasi</span>
                            <strong>Simpul & Anggota PF KSO</strong>
                            <p>Setiap simpul bekerja otonom sesuai konteks wilayah, dengan {{ $activeRegions }} simpul aktif dan {{ $pendingRegions }} simpul yang datanya dapat terus dilengkapi.</p>
                        </div>
                        <div class="member-network__stat">
                            <span>Simpul</span>
                            <strong>{{ $simpulRegions->count() }}</strong>
                        </div>
                        <div class="member-network__stat">
                            <span>Aktif</span>
                            <strong>{{ $activeRegions }}</strong>
                        </div>
                        <div class="member-network__stat">
                            <span>Anggota</span>
                            <strong>{{ $totalMembers }}</strong>
                        </div>
                    </div>

                    <div class="member-network__map">
                        <div class="member-network__center">
                            <span>Mandat Kolektif</span>
                            <strong>Pooling Fund Kemanusiaan</strong>
                        </div>
                        <div class="member-network__regions">
                            @foreach ($simpulRegions as $region)
                                @php
                                    $members = $region['members'] ?? [];
                                    $memberCount = count($members);
                                @endphp
                                <article class="region-node {{ $memberCount === 0 ? 'region-node--pending' : '' }}">
                                    <div class="region-node__top">
                                        <div class="region-node__badge">{{ $memberCount ?: '-' }}</div>
                                        <div>
                                            <span class="region-node__meta">{{ $region['shortLabel'] }}</span>
                                            <h3>{{ $region['label'] }}</h3>
                                        </div>
                                    </div>
                                    <p>{{ $region['description'] }}</p>
                                    <div class="region-node__members">
                                        @forelse ($members as $member)
                                            <span class="region-node__member">{{ $member }}</span>
                                        @empty
                                            <span class="region-node__member">Data anggota menyusul</span>
                                        @endforelse
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            @if (! empty($content['cards']))
                <div class="public-card-grid">
                    @foreach ($content['cards'] as $card)
                        <div class="public-card">
                            <span>{{ $section['label'] }}</span>
                            <h3>{{ $card }}</h3>
                        </div>
                    @endforeach
                </div>
            @endif

        </article>

        <aside class="public-sidebar">
            <h2>{{ $section['label'] }}</h2>
            <ul>
                <li><a href="{{ $section['publicHref'] ?? '#' }}">Ringkasan {{ $section['label'] }}</a></li>
                @include('layouts.public-sidebar-items', ['items' => $siblings])
            </ul>
        </aside>
    </div>
</section>

@include('partials.news-columns', ['newsArticles' => $updates ?? collect(), 'newsFallbackImages' => $fallbackImages])
@endsection
