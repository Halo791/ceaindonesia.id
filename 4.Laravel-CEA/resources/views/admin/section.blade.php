@extends('layouts.app')

@section('title', 'Admin '.$section['label'])

@section('content')
<section class="admin-shell">
    <div class="container">
        <div class="admin-hero">
            <span class="cea-kicker">Admin Section</span>
            <h1>Kelola {{ $section['label'] }}</h1>
            <p>{{ $section['description'] }}</p>
        </div>

        <div class="admin-stat-strip">
            <div class="admin-stat"><span>Tipe</span><strong>{{ empty($section['children']) ? 'Menu' : 'Dropdown' }}</strong></div>
            <div class="admin-stat"><span>Subhalaman</span><strong>{{ count($section['children'] ?? []) ?: 1 }}</strong></div>
            <div class="admin-stat"><span>Bahasa</span><strong>ID</strong></div>
            <div class="admin-stat"><span>Status</span><strong>Aktif</strong></div>
        </div>

        @if (! empty($section['children']))
            <div class="admin-grid">
                @foreach ($section['children'] as $item)
                    <article class="admin-card">
                        <span class="admin-card__label">{{ $section['label'] }}</span>
                        <h2>{{ $item['label'] }}</h2>
                        <p>{{ $item['description'] }}</p>
                        <div class="admin-card__actions">
                            <a class="admin-button" href="{{ route('admin.item', [$section['key'], $item['key']]) }}">Kelola halaman</a>
                            <a class="admin-button secondary" href="{{ $item['sourceHref'] }}" target="_blank" rel="noreferrer">Sumber</a>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="admin-form-card">
                <h2>Form Kelola Menu {{ $section['label'] }}</h2>
                <p>Halaman ini disiapkan untuk konten menu utama yang tidak memiliki dropdown.</p>
            </div>
        @endif
    </div>
</section>
@endsection
