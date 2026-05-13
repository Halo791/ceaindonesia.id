@extends('layouts.app')

@section('title', 'Admin '.$section['label'])

@section('content')
<section class="cea-admin-panel">
    <div class="admin-shell">
        @include('admin.partials.sidebar', ['activeSection' => $section['key']])
        <div class="admin-workspace">
        <div class="admin-hero">
            <div>
                <span class="admin-eyebrow">Panel Admin Pooling Fund - KSO</span>
                <h1>Kelola {{ $section['label'] }}</h1>
                <p>{{ $section['description'] }}</p>
            </div>
            <a class="admin-source-link" href="{{ $section['sourceHref'] }}" target="_blank" rel="noreferrer">Sumber resmi</a>
        </div>

        <div class="admin-stat-strip">
            <div class="admin-stat"><span>Tipe</span><strong>{{ empty($section['children']) ? 'Menu' : 'Dropdown' }}</strong></div>
            <div class="admin-stat"><span>Subhalaman</span><strong>{{ count($section['children'] ?? []) ?: 1 }}</strong></div>
            <div class="admin-stat"><span>Bahasa</span><strong>ID</strong></div>
            <div class="admin-stat"><span>Status</span><strong>Aktif</strong></div>
        </div>

        <div class="admin-form-card admin-section-spacer">
            <h2>Form Konten Menu {{ $section['label'] }}</h2>
            @if (! $dbReady)
                <div class="alert alert-warning">Tabel <strong>admin_contents</strong> belum tersedia. Import <code>database/sql/admin_contents.sql</code> di phpMyAdmin.</div>
            @endif
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            @error('database')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <form method="POST" action="{{ route('admin.section.update', $section['key']) }}">
                @csrf
                <div class="admin-field">
                    <label>Judul menu</label>
                    <input name="title" value="{{ old('title', $content['title']) }}" required>
                    @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="admin-field">
                    <label>Subtitle / Ringkasan</label>
                    <input name="subtitle" value="{{ old('subtitle', $content['subtitle']) }}">
                </div>
                <div class="admin-field">
                    <label>Isi tulisan</label>
                    <textarea name="body">{{ old('body', $content['body']) }}</textarea>
                </div>
                <div class="admin-field">
                    <label>URL / path gambar</label>
                    @php
                        $previewImagePath = old('image_path', $content['image_path']);
                        $previewFallbackImage = asset('assets/img/lapangan/walhi-sumut-tandon-air-1.jpeg');
                        $previewImageSrc = ($previewImagePath && strpos($previewImagePath, 'assets/img/cea/') !== false) ? $previewFallbackImage : $previewImagePath;
                    @endphp
                    <input name="image_path" value="{{ $previewImagePath }}" placeholder="Kosongkan untuk foto lapangan otomatis atau gunakan https://...">
                    @if (! empty($previewImageSrc))
                        <img src="{{ $previewImageSrc }}" alt="{{ $content['title'] }}" style="border-radius:8px;margin-top:12px;max-height:180px;object-fit:cover;width:100%;">
                    @endif
                </div>
                <div class="admin-field">
                    <label>URL sumber</label>
                    <input name="source_href" value="{{ old('source_href', $content['source_href']) }}">
                </div>
                <div class="admin-field">
                    <label>Status publikasi</label>
                    <select name="status">
                        <option value="draft" @selected(old('status', $content['status']) === 'draft')>Draft</option>
                        <option value="active" @selected(old('status', $content['status']) === 'active')>Aktif</option>
                        <option value="archived" @selected(old('status', $content['status']) === 'archived')>Arsip</option>
                    </select>
                </div>
                <div class="admin-form-actions">
                    <button class="admin-button" type="submit">Simpan ke database</button>
                    <a class="admin-button secondary" href="{{ $content['source_href'] ?: $section['sourceHref'] }}" target="_blank" rel="noreferrer">Lihat sumber</a>
                </div>
            </form>
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
        @endif
        </div>
    </div>
</section>
@endsection
