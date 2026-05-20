@extends('layouts.app')

@section('title', filled($searchQuery ?? '') ? 'Pencarian: '.$searchQuery : 'Blog Pooling Fund - KSO')

@section('content')
<section class="cea-video-hero">
    <video class="cea-video-hero__video" autoplay muted loop playsinline preload="metadata">
        <source src="{{ asset('assets/img/cea/video.mp4') }}" type="video/mp4">
    </video>
    <div class="container">
        <div class="cea-video-hero__content">
            <span class="cea-video-hero__eyebrow">{{ filled($searchQuery ?? '') ? 'Pencarian' : 'Blog' }}</span>
            <h1 class="cea-scramble-title"><span>{{ filled($searchQuery ?? '') ? 'Hasil Pencarian' : 'Artikel dan Publikasi' }}</span></h1>
            <p>
                @if (filled($searchQuery ?? ''))
                    Hasil untuk "{{ $searchQuery }}". Nama kanal seperti Kabar, Rilis, dan Referensi akan langsung membuka halaman yang sesuai.
                @else
                    Kumpulan kabar, rilis, referensi, dan pembaruan dari ekosistem Pooling Fund - KSO.
                @endif
            </p>
        </div>
    </div>
</section>

<section class="cea-section">
    <div class="container">
        @if (filled($searchQuery ?? ''))
            <div class="cea-card-grid">
                @forelse ($searchResults as $result)
                    <article class="cea-card">
                        <span class="cea-kicker mt-3">{{ $result['type'] }}</span>
                        <h2>{{ $result['title'] }}</h2>
                        <p>{{ $result['description'] ?: 'Buka halaman ini untuk melihat informasi selengkapnya.' }}</p>
                        <a class="admin-button" href="{{ $result['href'] }}">{{ $ui['open_page'] ?? 'Buka halaman' }}</a>
                    </article>
                @empty
                    <article class="cea-card">
                        <span class="cea-kicker mt-3">Pencarian</span>
                        <h2>Tidak ada hasil</h2>
                        <p>Coba cari berdasarkan nama menu atau kanal di website, misalnya Kabar, Rilis, Referensi, Simpul, atau Kontak.</p>
                    </article>
                @endforelse
            </div>
        @else
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
        @endif
    </div>
</section>
@endsection
