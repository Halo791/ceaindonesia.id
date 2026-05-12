@extends('layouts.app')

@section('title', $post['title'])

@section('content')
<section class="cea-section">
    <div class="container" style="max-width:920px">
        <span class="cea-kicker">{{ $post['category'] }}</span>
        <h1>{{ $post['title'] }}</h1>
        <p class="mb-4">{{ $post['date'] }} oleh {{ $post['author'] }}</p>
        <img src="{{ asset('assets/img/'.$post['group'].'/'.$post['img']) }}" alt="{{ $post['title'] }}" style="border-radius:8px;margin-bottom:28px;width:100%">
        <p>Konten artikel ini berasal dari data template awal. Di Laravel, bagian ini sudah siap diganti menjadi konten dari database, CMS, atau editor admin.</p>
        <p>Struktur route, layout, dan asset publik sudah berjalan sebagai Blade sehingga lebih mudah dipasang di cPanel berbasis PHP.</p>
    </div>
</section>
@endsection
