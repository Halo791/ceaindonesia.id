@extends('layouts.app')

@section('title', $title.' - CEA Indonesia')

@section('content')
<section class="cea-section">
    <div class="container">
        <span class="cea-kicker">Halaman</span>
        <h1>{{ $title }}</h1>
        <p>Halaman ini sudah disiapkan di Laravel dan bisa diisi sesuai konten final.</p>
        <a class="admin-button" href="{{ route('home') }}">Kembali ke Beranda</a>
    </div>
</section>
@endsection
