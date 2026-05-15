@extends('layouts.app')

@section('title', $content['title'].' - '.config('app.name'))

@push('styles')
<style>
    .article-detail-hero .cea-video-hero__content {
        max-width: 920px;
    }
    .article-detail-hero h1 {
        max-width: 920px;
    }
    .article-detail-meta {
        align-items: center;
        color: rgba(255,255,255,.78);
        display: flex;
        flex-wrap: wrap;
        font-size: 13px;
        font-weight: 800;
        gap: 10px;
        margin-bottom: 16px;
        text-transform: uppercase;
    }
    .article-detail-meta span {
        background: rgba(255,255,255,.14);
        border: 1px solid rgba(255,255,255,.2);
        border-radius: 999px;
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
        background: #f7f4ee;
        border-radius: 8px;
        color: #10261d;
        display: grid;
        gap: 12px;
        grid-template-columns: 88px minmax(0, 1fr);
        padding: 8px;
    }
    .article-related__item img {
        aspect-ratio: 1 / .82;
        border-radius: 6px;
        display: block;
        height: 76px;
        object-fit: cover;
        width: 88px;
    }
    .article-related__item strong {
        color: #0f7a4a;
        display: -webkit-box;
        font-size: 14px;
        font-weight: 900;
        line-height: 1.25;
        overflow: hidden;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }
    .article-related__item small {
        color: #7b8077;
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
