@extends('layouts.app')

@section('title', $content['title'].' - '.config('app.name'))

@push('styles')
<style>
    .kso-cube-field {
        display: none !important;
    }
    .article-detail-hero .cea-video-hero__content {
        max-width: 920px;
    }
    .article-detail-hero h1 {
        max-width: 920px;
    }
    .article-detail-meta {
        align-items: center;
        color: #fff;
        display: flex;
        flex-wrap: wrap;
        font-size: 13px;
        font-weight: 800;
        gap: 10px;
        margin-bottom: 16px;
        text-transform: uppercase;
    }
    .article-detail-meta span,
    .article-detail-meta time {
        background: rgba(6,61,42,.72);
        border: 0;
        border-radius: 999px;
        box-shadow: 0 10px 24px rgba(0,0,0,.16);
        display: inline-flex;
        line-height: 1;
        padding: 6px 10px;
    }
    .article-detail {
        background: #f6f9e8;
        padding: 76px 0;
    }
    .article-detail__layout {
        align-items: start;
        display: grid;
        gap: 34px;
        grid-template-columns: minmax(0, 1fr) 340px;
    }
    .article-detail__main,
    .article-detail__side {
        background: #fff;
        border: 1px solid #dfe9c9;
        border-radius: 8px;
        box-shadow: 0 18px 44px rgba(6,61,42,.08);
        overflow: hidden;
    }
    .article-detail__image {
        background: #dfe9c9;
        display: block;
        width: 100%;
    }
    .article-detail__image img {
        aspect-ratio: 16 / 9;
        display: block;
        object-fit: cover;
        width: 100%;
    }
    .article-detail__body {
        color: #405d4a;
        font-size: 17px;
        line-height: 1.9;
        padding: clamp(22px, 4vw, 42px);
    }
    .article-detail__body p {
        margin-bottom: 20px;
    }
    .article-detail__side {
        padding: 18px;
        position: sticky;
        top: 100px;
    }
    .article-detail__side h2 {
        color: #063d2a;
        font-size: 20px;
        font-weight: 900;
        margin-bottom: 14px;
    }
    .article-related {
        display: grid;
        gap: 10px;
    }
    .article-related__item {
        align-items: end;
        aspect-ratio: 16 / 10;
        background: #063d2a;
        border-radius: 8px;
        color: #fff;
        display: flex;
        min-height: 150px;
        overflow: hidden;
        padding: 0;
        position: relative;
    }
    .article-related__item::after {
        background: linear-gradient(180deg, rgba(6,61,42,0) 18%, rgba(6,61,42,.62) 58%, rgba(6,61,42,.96) 100%);
        content: "";
        inset: 0;
        position: absolute;
        z-index: 1;
    }
    .article-related__item img {
        display: block;
        height: 100%;
        inset: 0;
        object-fit: cover;
        position: absolute;
        transform: scale(1.01);
        transition: transform .22s ease;
        width: 100%;
        z-index: 0;
    }
    .article-related__item:hover img {
        transform: scale(1.045);
    }
    .article-related__item span {
        display: block;
        padding: 58px 14px 14px;
        position: relative;
        z-index: 2;
    }
    .article-related__item strong {
        color: #fff;
        display: -webkit-box;
        font-size: 14px;
        font-weight: 900;
        line-height: 1.25;
        overflow: hidden;
        text-shadow: 0 8px 20px rgba(0,0,0,.3);
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }
    .article-related__item small {
        color: #f2c94c;
        display: block;
        font-size: 11px;
        font-weight: 800;
        margin-top: 7px;
    }
    @media (max-width: 991px) {
        .article-detail__layout {
            grid-template-columns: 1fr;
        }
        .article-detail__side {
            position: static;
        }
    }
    @media (max-width: 575px) {
        .article-detail {
            padding: 52px 0;
        }
        .article-detail__body {
            font-size: 15px;
            line-height: 1.8;
        }
    }
</style>
@endpush

@php
    $locale = $currentLocale ?? 'id';
    $relatedUpdates = collect($relatedUpdates ?? []);
    $fallbackImages = [
        asset('assets/img/lapangan/pkbi-aceh-dukungan-psikososial.jpeg'),
        asset('assets/img/lapangan/pkbi-aceh-karya-anak.jpeg'),
        asset('assets/img/lapangan/walhi-sumut-tandon-air-1.jpeg'),
        asset('assets/img/lapangan/walhi-sumut-tandon-air-2.jpeg'),
        asset('assets/img/lapangan/walhi-sumbar-distribusi-logistik.jpeg'),
    ];
    $fallbackIndex = abs(crc32($content['title'] ?? config('app.name'))) % count($fallbackImages);
    $imagePath = $content['image_path'] ?: $fallbackImages[$fallbackIndex];
    $imageSrc = preg_match('/^https?:\/\//', $imagePath) ? $imagePath : asset(ltrim($imagePath, '/'));
    $publishedLabel = optional($content['published_at'] ?? null)->format('l, j F Y');
    $relatedTitle = $locale === 'en' ? 'Related Articles' : 'Artikel Terkait';
@endphp

@section('content')
<section class="article-detail-hero cea-video-hero">
    <video class="cea-video-hero__video" autoplay muted loop playsinline preload="metadata">
        <source src="{{ asset('assets/img/cea/video.mp4') }}" type="video/mp4">
    </video>
    <div class="container">
        <div class="cea-video-hero__content">
            <div class="article-detail-meta">
                <span>{{ $content['eyebrow'] }}</span>
                @if ($publishedLabel)
                    <time datetime="{{ optional($content['published_at'])->toDateString() }}">{{ $publishedLabel }}</time>
                @endif
            </div>
            <h1 class="cea-scramble-title"><span>{{ $content['title'] }}</span></h1>
            @if (! empty($content['subtitle']))
                <p>{{ $content['subtitle'] }}</p>
            @endif
        </div>
    </div>
</section>

<section class="article-detail">
    <div class="container article-detail__layout">
        <article class="article-detail__main">
            <div class="article-detail__image">
                <img src="{{ $imageSrc }}" alt="{{ $content['title'] }}">
            </div>
            <div class="article-detail__body">
                @foreach (preg_split("/\r\n|\n|\r/", $content['body']) as $paragraph)
                    @if (trim($paragraph) !== '')
                        <p>{{ $paragraph }}</p>
                    @endif
                @endforeach
            </div>
        </article>

        <aside class="article-detail__side">
            <h2>{{ $relatedTitle }}</h2>
            <div class="article-related">
                @foreach ($relatedUpdates as $article)
                    @php
                        $articleTitle = $locale === 'en' && filled($article->title_en) ? $article->title_en : $article->title;
                        $articleImagePath = $article->image_path ?: $fallbackImages[abs(crc32($articleTitle)) % count($fallbackImages)];
                        $articleImage = preg_match('/^https?:\/\//', $articleImagePath) ? $articleImagePath : asset(ltrim($articleImagePath, '/'));
                    @endphp
                    <a class="article-related__item" href="{{ route('public.update', $article->slug) }}">
                        <img src="{{ $articleImage }}" alt="{{ $articleTitle }}">
                        <span>
                            <strong>{{ $articleTitle }}</strong>
                            <small>{{ optional($article->published_at)->format('l, j F Y') }}</small>
                        </span>
                    </a>
                @endforeach
            </div>
        </aside>
    </div>
</section>
@endsection
