@extends('layouts.app')

@section('title', 'Admin '.$item['label'])

@section('content')
<section class="cea-admin-panel">
    <div class="admin-shell">
        @include('admin.partials.sidebar', ['activeSection' => $section['key'], 'activeItem' => $item['key']])
        <div class="admin-workspace">
        <div class="admin-hero">
            <div>
                <span class="admin-eyebrow">{{ $section['label'] }}</span>
                <h1>Kelola {{ $item['label'] }}</h1>
                <p>{{ $item['description'] }}</p>
            </div>
            <a class="admin-source-link" href="{{ $item['sourceHref'] }}" target="_blank" rel="noreferrer">Sumber resmi</a>
        </div>

        <div class="admin-form-card admin-section-spacer">
            <h2>Form Konten</h2>
            <div class="admin-field">
                <label>Judul halaman</label>
                <input value="{{ $item['label'] }}">
            </div>
            <div class="admin-field">
                <label>Slug</label>
                <input value="{{ $item['key'] }}">
            </div>
            <div class="admin-field">
                <label>Deskripsi</label>
                <textarea>{{ $item['description'] }}</textarea>
            </div>
            <div class="admin-form-actions">
                <button class="admin-button" type="button">Simpan draft</button>
                <a class="admin-button secondary" href="{{ $item['sourceHref'] }}" target="_blank" rel="noreferrer">Lihat sumber</a>
            </div>
        </div>
        </div>
    </div>
</section>
@endsection
