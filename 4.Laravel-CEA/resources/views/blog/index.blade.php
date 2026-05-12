@extends('layouts.app')

@section('title', 'Blog CEA Indonesia')

@section('content')
<section class="cea-section">
    <div class="container">
        <span class="cea-kicker">Blog</span>
        <h1 class="mb-4">Artikel dan Publikasi</h1>
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
