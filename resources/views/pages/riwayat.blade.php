@extends('layouts.app')

@section('title', 'Riwayat Pooling Fund - KSO')

@php
    $riwayatImagePath = $content['image_path'] ?? '';
    $riwayatHeroImage = ($riwayatImagePath && strpos($riwayatImagePath, 'assets/img/cea/') === false)
        ? $riwayatImagePath
        : asset('assets/img/lapangan/pkbi-aceh-karya-anak.jpeg');
@endphp

@section('content')
<section class="home-hero">
    <div class="container">
        <div class="home-hero__grid">
            <div>
                <span class="cea-kicker">Profil Pooling Fund - KSO</span>
                <h1 class="cea-scramble-title">{{ $content['title'] ?: 'Riwayat Proses Pembentukan' }}</h1>
                <p>{{ $content['subtitle'] ?: 'Pooling Fund - KSO lahir dari kebutuhan bersama organisasi masyarakat sipil untuk memperkuat koordinasi, konsolidasi, dan kerja kolektif di tengah penyempitan ruang sipil.' }}</p>
                <a class="cea-btn" href="{{ route('home') }}">Kembali ke Beranda</a>
            </div>
            <img class="home-hero__image" src="{{ $riwayatHeroImage }}" alt="{{ $content['title'] ?: 'Riwayat Pooling Fund - KSO' }}">
        </div>
    </div>
</section>

<section class="cea-section">
    <div class="container">
        <span class="cea-kicker">Linimasa</span>
        <h2 class="mb-4">Dari Sentul menuju rembug nasional di Lembang.</h2>
        @if (! empty($content['body']))
            <div class="cea-card mb-4">
                <p>{!! nl2br(e($content['body'])) !!}</p>
            </div>
        @endif
        <div class="cea-card-grid">
            <article class="cea-card">
                <span class="cea-kicker">Latar</span>
                <h3>Ruang sipil dan demokrasi sedang menghadapi tekanan berlapis.</h3>
                <p>Demokrasi Indonesia tengah menghadapi tantangan serius. Ruang sipil menyempit, indeks demokrasi menurun, dan oligarki makin menguat.</p>
            </article>
            <article class="cea-card">
                <span class="cea-kicker">Februari 2025</span>
                <h3>Proses Pembentukan Pooling Fund - KSO</h3>
                <p>48 organisasi masyarakat sipil bertemu di Sentul dan mengidentifikasi kebutuhan bersama akan platform koordinasi gerakan OMS.</p>
            </article>
            <article class="cea-card">
                <span class="cea-kicker">6-9 Juli 2025</span>
                <h3>Rembug Nasional Pooling Fund - KSO</h3>
                <p>61 organisasi dari 19 provinsi hadir di Lembang dan menjadi tonggak penting lahirnya Pooling Fund - KSO sebagai aliansi nasional.</p>
            </article>
        </div>
    </div>
</section>
@endsection
