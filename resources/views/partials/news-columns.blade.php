@once
    @push('styles')
    <style>
        .cea-news-columns {
            background: #063d2a;
            color: #fff;
            padding: 78px 0;
        }
        .cea-news-columns__grid {
            align-items: start;
            display: grid;
            gap: 34px;
            grid-template-columns: minmax(0, 1fr) minmax(360px, .95fr);
        }
        .cea-news-columns__label {
            background: #c7e2d4;
            color: #063d2a;
            display: inline-flex;
            font-size: 12px;
            font-weight: 900;
            margin-bottom: 16px;
            padding: 5px 10px;
        }
        .cea-news-columns h2 {
            color: #fff;
            font-size: 24px;
            font-weight: 900;
            margin-bottom: 14px;
        }
        .cea-news-video {
            border-radius: 8px;
            box-shadow: 0 18px 44px rgba(0,0,0,.2);
            display: block;
            overflow: hidden;
            width: 100%;
        }
        .cea-news-video video {
            aspect-ratio: 16 / 9;
            background: #0f5d3e;
            display: block;
            object-fit: cover;
            width: 100%;
        }
        .cea-news-columns p {
            color: rgba(255,255,255,.86);
            font-size: 14px;
            line-height: 1.75;
            margin: 14px 0 0;
        }
        .cea-news-list {
            display: grid;
            gap: 12px;
        }
        .cea-news-item {
            background: #f7f4ee;
            border-radius: 8px;
            color: #10261d;
            display: grid;
            gap: 12px;
            grid-template-columns: 108px minmax(0, 1fr);
            min-height: 0;
            overflow: hidden;
            padding: 8px;
            transition: transform .18s ease, box-shadow .18s ease;
        }
        .cea-news-item:hover {
            box-shadow: 0 14px 28px rgba(0,0,0,.14);
            transform: translateY(-2px);
        }
        .cea-news-item img {
            display: block;
            height: 92px;
            object-fit: cover;
            position: static;
            width: 108px;
            border-radius: 6px;
        }
        .cea-news-item span {
            background: transparent;
            color: #10261d;
            display: block;
            min-height: 0;
            padding: 4px 2px 2px;
        }
        .cea-news-item strong {
            color: #0f7a4a;
            display: -webkit-box;
            font-size: 16px;
            font-weight: 900;
            line-height: 1.18;
            margin-bottom: 6px;
            overflow: hidden;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }
        .cea-news-item span {
            font-size: 13px;
            line-height: 1.45;
        }
        .cea-news-item small {
            color: #7b8077;
            display: block;
            font-size: 11px;
            font-weight: 800;
            margin-top: 8px;
            text-transform: uppercase;
        }
        .cea-news-empty {
            background: rgba(255,255,255,.12);
            border: 1px dashed rgba(255,255,255,.28);
            border-radius: 8px;
            padding: 18px;
        }
        @media (max-width: 991px) {
            .cea-news-columns__grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 575px) {
            .cea-news-item { grid-template-columns: 88px minmax(0, 1fr); }
            .cea-news-item img { height: 76px; width: 88px; }
            .cea-news-item strong { font-size: 14px; }
        }
    </style>
    @endpush
@endonce

@php
    $newsArticles = collect($newsArticles ?? []);
    $locale = $currentLocale ?? 'id';
    $ui = $ui ?? [];
    $newsFallbackImages = $newsFallbackImages ?? [
        asset('assets/img/lapangan/pkbi-aceh-dukungan-psikososial.jpeg'),
        asset('assets/img/lapangan/pkbi-aceh-karya-anak.jpeg'),
        asset('assets/img/lapangan/walhi-sumut-tandon-air-1.jpeg'),
        asset('assets/img/lapangan/walhi-sumbar-distribusi-logistik.jpeg'),
    ];
@endphp

<section class="cea-news-columns">
    <div class="container">
        <div class="cea-news-columns__grid">
            <div>
                <span class="cea-news-columns__label">{{ $ui['youtube_video'] ?? 'YouTube video' }}</span>
                <h2>{{ $ui['latest_video'] ?? 'Latest Video' }}</h2>
                <div class="cea-news-video">
                    <video controls muted preload="metadata">
                        <source src="{{ asset('assets/img/cea/video.mp4') }}" type="video/mp4">
                    </video>
                </div>
                <p>{{ $ui['news_intro'] ?? 'Ikuti cerita, aktivitas, dan pembelajaran dari simpul lokal. Ruang ini menampilkan dokumentasi video dan narasi kerja bersama dalam ekosistem Pooling Fund - KSO.' }}</p>
            </div>

            <div>
                <h2>{{ $ui['new_article'] ?? 'New Article' }}</h2>
                <div class="cea-news-list">
                    @forelse ($newsArticles->take(4) as $article)
                        @php
                            $articleTitle = $locale === 'en' && filled($article->title_en) ? $article->title_en : $article->title;
                            $articleExcerpt = $locale === 'en' && filled($article->excerpt_en) ? $article->excerpt_en : $article->excerpt;
                            $articleBody = $locale === 'en' && filled($article->body_en) ? $article->body_en : $article->body;
                            $articleCategory = $locale === 'en' && filled($article->category_en) ? $article->category_en : $article->category;
                            $articleImagePath = $article->image_path ?: $newsFallbackImages[abs(crc32($articleTitle)) % count($newsFallbackImages)];
                            $articleImage = preg_match('/^https?:\/\//', $articleImagePath) ? $articleImagePath : asset(ltrim($articleImagePath, '/'));
                        @endphp
                        <a class="cea-news-item" href="{{ route('public.update', $article->slug) }}">
                            <img src="{{ $articleImage }}" alt="{{ $articleTitle }}">
                            <span>
                                <strong>{{ $articleTitle }}</strong>
                                {{ $articleExcerpt ?: str($articleBody)->limit(82) }}
                                <small>{{ optional($article->published_at)->format('l, j F Y') ?: $articleCategory }}</small>
                            </span>
                        </a>
                    @empty
                        <div class="cea-news-empty">
                            <h2>{{ $ui['new_article'] ?? 'New Article' }}</h2>
                            <p>{{ $ui['no_active_news'] ?? 'Belum ada berita aktif untuk halaman ini.' }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
