@extends('layouts.app')

@section('title', 'Blog Pooling Fund - KSO')

@section('content')
<section class="cea-video-hero">
    <video class="cea-video-hero__video" autoplay muted loop playsinline preload="metadata">
        <source src="{{ asset('assets/img/cea/video.mp4') }}" type="video/mp4">
    </video>
    <div class="container">
        <div class="cea-video-hero__content">
            <span class="cea-video-hero__eyebrow">Blog</span>
            <h1 class="cea-scramble-title"><span>Artikel dan Publikasi</span></h1>
            <p>Kumpulan kabar, rilis, referensi, dan pembaruan dari ekosistem Pooling Fund - KSO.</p>
        </div>
    </div>
</section>

<section class="cea-section">
    <div class="container">
        <div class="cea-card-grid">
            @foreach ($posts as $post)
                <article class="cea-card">
                    <img src="{{ asset('assets/img/'.$post['group'].'/'.$post['img']) }}" alt="{{ $post['title'] }}" style="border-radius:8px;height:190px;object-fit:cover;width:100%">
                    <span class="cea-kicker mt-3">{{ $post['category'] }}</span>
                    <h2>{{ $post['title'] }}</h2>
                    <p>{{ $post['date'] }} oleh {{ $post['author'] }}</p>
                    <a class="admin-button" href="{{ route('blog.show', $post['id']) }}">Baca</a>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endsection
