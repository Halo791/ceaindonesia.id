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
            gap: 14px;
        }
        .cea-news-item {
            align-items: end;
            aspect-ratio: 16 / 9;
            background: #063d2a;
            border-radius: 8px;
            color: #fff;
            display: flex;
            min-height: 0;
            overflow: hidden;
            padding: 0;
            position: relative;
            transition: transform .18s ease, box-shadow .18s ease;
        }
        .cea-news-item::after {
            background: linear-gradient(180deg, rgba(6,61,42,0) 22%, rgba(6,61,42,.58) 58%, rgba(6,61,42,.94) 100%);
            content: "";
            inset: 0;
            position: absolute;
            z-index: 1;
        }
        .cea-news-item:hover {
            box-shadow: 0 14px 28px rgba(0,0,0,.14);
            transform: translateY(-2px);
        }
        .cea-news-item img {
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
        .cea-news-item:hover img {
            transform: scale(1.045);
        }
        .cea-news-item__body {
            display: block;
            min-height: 0;
            padding: 22px 24px;
            position: relative;
            z-index: 2;
        }
        .cea-news-item strong {
            color: #fff;
            display: -webkit-box;
            font-size: 22px;
            font-weight: 900;
            line-height: 1.16;
            margin-bottom: 10px;
            overflow: hidden;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            text-shadow: 0 8px 22px rgba(0,0,0,.36);
        }
        .cea-news-item__excerpt {
            color: rgba(255,255,255,.9);
            display: -webkit-box;
            font-size: 14px;
            line-height: 1.55;
            margin: 0;
            overflow: hidden;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }
        .cea-news-item small {
            color: #f2c94c;
            display: block;
            font-size: 11px;
            font-weight: 800;
            margin-bottom: 8px;
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
            .cea-news-list { gap: 12px; }
            .cea-news-item { aspect-ratio: 4 / 3; }
            .cea-news-item__body { padding: 18px; }
            .cea-news-item strong { font-size: 18px; }
            .cea-news-item__excerpt { font-size: 13px; -webkit-line-clamp: 2; }
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
                        <source src="{{ asset('assets/img/cea/') }}" type="video/mp4">
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
                            <span class="cea-news-item__body">
                                <small>{{ $articleCategory }}</small>
                                <strong>{{ $articleTitle }}</strong>
                                <span class="cea-news-item__excerpt">{{ $articleExcerpt ?: str($articleBody)->limit(112) }}</span>
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
