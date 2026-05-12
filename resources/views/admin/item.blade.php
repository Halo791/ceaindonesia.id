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
            <h2>Form Konten Database</h2>
            @if (! $dbReady)
                <div class="alert alert-warning">Tabel <strong>admin_contents</strong> belum tersedia. Import <code>database/sql/admin_contents.sql</code> di phpMyAdmin.</div>
            @endif
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            @error('database')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <form method="POST" action="{{ route('admin.item.update', [$section['key'], $item['key']]) }}">
                @csrf
                <div class="admin-field">
                    <label>Judul halaman</label>
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
                        $previewAsWordmark = $previewImagePath && strpos($previewImagePath, 'assets/img/cea/') !== false;
                    @endphp
                    <input name="image_path" value="{{ $previewImagePath }}" placeholder="Kosongkan untuk wordmark Pooling Fund - KSO atau gunakan https://...">
                    @if (! empty($previewImagePath))
                        @if ($previewAsWordmark)
                            <div style="border-radius:8px;margin-top:12px;max-height:180px;overflow:hidden;">
                                @include('layouts.kso-wordmark', ['variant' => 'card', 'tagline' => $content['title'], 'panel' => true])
                            </div>
                        @else
                            <img src="{{ $previewImagePath }}" alt="{{ $content['title'] }}" style="border-radius:8px;margin-top:12px;max-height:180px;object-fit:cover;width:100%;">
                        @endif
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
                    <a class="admin-button secondary" href="{{ $content['source_href'] ?: $item['sourceHref'] }}" target="_blank" rel="noreferrer">Lihat sumber</a>
                </div>
            </form>
        </div>
        </div>
    </div>
</section>
@endsection
