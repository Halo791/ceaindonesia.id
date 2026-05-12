@extends('layouts.app')

@section('title', $content['title'].' - CEA Indonesia')

@push('styles')
<style>
    .public-hero {
        background:
            radial-gradient(circle at 82% 12%, rgba(242, 182, 109, .2), transparent 30%),
            linear-gradient(135deg, #2a0710 0%, #5b0f1a 58%, #7a1626 100%);
        color: #fff;
        padding: 82px 0 88px;
    }
    .public-hero__grid {
        align-items: center;
        display: grid;
        gap: 44px;
        grid-template-columns: minmax(0, .9fr) minmax(340px, 1fr);
    }
    .public-hero__eyebrow,
    .public-section__head span,
    .public-card span {
        color: #f2b66d;
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
    .public-hero__visual {
        background: #fff8f5;
        border-radius: 8px;
        box-shadow: 0 34px 80px rgba(42,7,16,.32);
        overflow: hidden;
        padding: 20px;
    }
    .public-hero__visual img {
        border-radius: 6px;
        display: block;
        max-height: 420px;
        object-fit: cover;
        width: 100%;
    }
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
        color: #52353a;
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
        border: 1px solid #efd0d0;
        border-radius: 8px;
        box-shadow: 0 18px 44px rgba(75,11,23,.08);
        padding: 22px;
    }
    .public-card h3 {
        color: #3a0710;
        font-size: 21px;
        margin: 0;
    }
    .public-sidebar {
        align-self: start;
        position: sticky;
        top: 100px;
    }
    .public-sidebar h2 {
        color: #3a0710;
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
    .public-sidebar a {
        background: #fff4f2;
        border-radius: 8px;
        color: #7a1626;
        display: block;
        font-weight: 800;
        padding: 10px 12px;
    }
    .public-sidebar a:hover { background: #f2b66d; color: #2a0710; }
    @media (max-width: 991px) {
        .public-hero__grid,
        .public-layout { grid-template-columns: 1fr; }
        .public-sidebar { position: static; }
    }
</style>
@endpush

@section('content')
<section class="public-hero">
    <div class="container">
        <div class="public-hero__grid">
            <div>
                <span class="public-hero__eyebrow">{{ $content['eyebrow'] ?? $section['label'] }}</span>
                <h1 class="cea-scramble-title">{{ $content['title'] }}</h1>
                <p>{{ $content['subtitle'] }}</p>
                <div class="cea-footer-actions">
                    @if (! empty($content['source_href']))
                        <a href="{{ $content['source_href'] }}" target="_blank" rel="noreferrer">Sumber Resmi</a>
                    @endif
                </div>
            </div>
            <div class="public-hero__visual">
                <img src="{{ $content['image_path'] }}" alt="{{ $content['title'] }}">
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
                @foreach ($siblings as $sibling)
                    <li><a href="{{ $sibling['publicHref'] ?? $sibling['href'] }}">{{ $sibling['label'] }}</a></li>
                @endforeach
            </ul>
        </aside>
    </div>
</section>
@endsection
