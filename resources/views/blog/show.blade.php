@extends('layouts.app')

@section('title', $post['title'])

@section('content')
<section class="cea-video-hero">
    <video class="cea-video-hero__video" autoplay muted loop playsinline preload="metadata">
        <source src="{{ asset('assets/img/cea/video.mp4') }}" type="video/mp4">
    </video>
    <div class="container">
        <div class="cea-video-hero__content">
            <span class="cea-video-hero__eyebrow">{{ $post['category'] }}</span>
            <h1 class="cea-scramble-title"><span>{{ $post['title'] }}</span></h1>
            <p>{{ $post['date'] }} oleh {{ $post['author'] }}</p>
        </div>
    </div>
</section>

<section class="cea-section">
    <div class="container" style="max-width:920px">
        <img src="{{ asset('assets/img/'.$post['group'].'/'.$post['img']) }}" alt="{{ $post['title'] }}" style="border-radius:8px;margin-bottom:28px;width:100%">
        <p>Konten artikel ini berasal dari data template awal. Di Laravel, bagian ini sudah siap diganti menjadi konten dari database, CMS, atau editor admin.</p>
        <p>Struktur route, layout, dan asset publik sudah berjalan sebagai Blade sehingga lebih mudah dipasang di cPanel berbasis PHP.</p>
    </div>
</section>
@endsection
