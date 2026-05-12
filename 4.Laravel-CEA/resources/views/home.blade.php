@extends('layouts.app')

@section('title', 'CEA Indonesia')

@push('styles')
<style>
    .home-stats { background: #fff; border-bottom: 1px solid rgba(122,22,38,.12); padding: 30px 0; }
    .home-stats__grid { display: grid; gap: 16px; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); }
    .home-stat strong { color: var(--cea-red); display: block; font-size: 42px; }
    .home-feature img { border-radius: 8px; height: 210px; object-fit: cover; width: 100%; }
</style>
@endpush

@section('content')
<section class="home-hero">
    <div class="container">
        <div class="home-hero__grid">
            <div>
                <span class="cea-kicker">Civic Engagement Alliance</span>
                <h1>Merawat ruang sipil, memperkuat gerakan akar rumput.</h1>
                <p>CEA lahir sebagai platform koordinasi dan konsolidasi organisasi masyarakat sipil di Indonesia.</p>
                <div class="d-flex flex-wrap gap-2">
                    <a class="cea-btn" href="{{ route('profil.riwayat') }}">Baca Riwayat</a>
                    <a class="cea-btn secondary" href="{{ route('admin.index') }}">Panel Admin</a>
                </div>
            </div>
            <img src="{{ asset('assets/img/cea/campur.png') }}" alt="CEA Indonesia">
        </div>
    </div>
</section>

<section class="home-stats">
    <div class="container home-stats__grid">
        <div class="home-stat"><strong>78</strong><span>Organisasi masyarakat sipil</span></div>
        <div class="home-stat"><strong>19</strong><span>Provinsi jejaring</span></div>
        <div class="home-stat"><strong>6</strong><span>Simpul regional</span></div>
    </div>
</section>

<section class="cea-section">
    <div class="container">
        <span class="cea-kicker">Fokus Gerak</span>
        <h2 class="mb-4">Kanal utama CEA Indonesia</h2>
        <div class="cea-card-grid">
            @foreach (['Ruang Sipil', 'Gerakan Kolektif', 'Diskursus Publik'] as $title)
                <article class="cea-card home-feature">
                    <img src="{{ asset('assets/img/cea/pomelli_bdna_image_0510%20%285%29.png') }}" alt="{{ $title }}">
                    <h3 class="mt-3">{{ $title }}</h3>
                    <p>Menghubungkan simpul, gagasan, dan aksi lintas wilayah agar gerakan masyarakat sipil tetap relevan.</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endsection
