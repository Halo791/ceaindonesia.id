@extends('layouts.app')

@section('title', $title.' - Pooling Fund - KSO')

@section('content')
<section class="cea-video-hero">
    <video class="cea-video-hero__video" autoplay muted loop playsinline preload="metadata">
        <source src="{{ asset('assets/img/cea/video.mp4') }}" type="video/mp4">
    </video>
    <div class="container">
        <div class="cea-video-hero__content">
            <span class="cea-video-hero__eyebrow">Halaman</span>
            <h1 class="cea-scramble-title"><span>{{ $title }}</span></h1>
            <p>Halaman ini sudah disiapkan di Laravel dan bisa diisi sesuai konten final.</p>
            <div class="cea-video-hero__actions">
                <a class="cea-btn" href="{{ route('home') }}">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</section>

<section class="cea-section">
    <div class="container">
        <div class="cea-card">
            <span class="cea-kicker">Konten</span>
            <h2>{{ $title }}</h2>
            <p>Area konten lanjutan untuk halaman ini dapat dikembangkan melalui struktur Blade atau panel admin.</p>
        </div>
    </div>
</section>
@endsection
