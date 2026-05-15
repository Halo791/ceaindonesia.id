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
            align-items: center;
            background: rgba(255,255,255,.94);
            border-radius: 8px;
            color: #063d2a;
            display: grid;
            gap: 14px;
            grid-template-columns: 96px minmax(0, 1fr);
            padding: 10px;
        }
        .cea-news-item img {
            aspect-ratio: 4 / 3;
            border-radius: 6px;
            display: block;
            object-fit: cover;
            width: 100%;
        }
        .cea-news-item strong {
            color: #04724d;
            display: block;
            font-size: 14px;
            font-weight: 900;
            line-height: 1.25;
            margin-bottom: 4px;
        }
        .cea-news-item small {
            color: #6a746c;
            display: block;
            font-size: 11px;
            margin-top: 5px;
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
    </style>
    @endpush
@endonce

@php
    $newsArticles = collect($newsArticles ?? []);
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
                <span class="cea-news-columns__label">YouTube video</span>
                <h2>Latest Video</h2>
                <div class="cea-news-video">
                    <video controls muted preload="metadata">
                        <source src="{{ asset('assets/img/cea/video.mp4') }}" type="video/mp4">
                    </video>
                </div>
                <p>Ikuti cerita, aktivitas, dan pembelajaran dari simpul lokal. Ruang ini menampilkan dokumentasi video dan narasi kerja bersama dalam ekosistem Pooling Fund - KSO.</p>
            </div>

            <div>
                <h2>New Article</h2>
                <div class="cea-news-list">
                    @forelse ($newsArticles->take(4) as $article)
                        @php
                            $articleImage = $article->image_path ?: $newsFallbackImages[abs(crc32($article->title)) % count($newsFallbackImages)];
                        @endphp
                        <a class="cea-news-item" href="{{ route('public.update', $article->slug) }}">
                            <img src="{{ $articleImage }}" alt="{{ $article->title }}">
                            <span>
                                <strong>{{ $article->title }}</strong>
                                {{ $article->excerpt ?: str($article->body)->limit(105) }}
                                <small>{{ optional($article->published_at)->format('l, j F Y') ?: $article->category }}</small>
                            </span>
                        </a>
                    @empty
                        <div class="cea-news-empty">
                            <h2>New Article</h2>
                            <p>Belum ada berita aktif untuk halaman ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
