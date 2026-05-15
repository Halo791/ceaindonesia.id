@extends('layouts.app')

@section('title', 'Admin '.$item['label'])

@php
    $contentMeta = $content['meta'] ?? [];
    $metaValue = function (string $key, string $fallback = '') use ($contentMeta) {
        return old("meta.{$key}", $contentMeta[$key] ?? $fallback);
    };
@endphp

@section('content')
<section class="cea-admin-panel">
    <div class="admin-shell">
        @include('admin.partials.sidebar', ['activeSection' => $section['key'], 'activeItemKey' => $contentKey])
        <div class="admin-workspace">
        <div class="admin-hero">
            <div>
                <span class="admin-eyebrow">{{ $section['label'] }}</span>
                <h1>Kelola {{ $item['label'] }}</h1>
                <p>{{ $item['description'] }}</p>
            </div>
            {{-- <a class="admin-source-link" href="{{ $item['sourceHref'] ?? $item['publicHref'] ?? '#' }}" target="_blank" rel="noreferrer">Sumber resmi</a> --}}
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
            <form method="POST" action="{{ $formAction }}">
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
                <div class="admin-grid" style="margin-bottom:16px;">
                    <div class="admin-field">
                        <label>Judul halaman EN</label>
                        <input name="meta[title_en]" value="{{ $metaValue('title_en') }}" placeholder="English title">
                    </div>
                    <div class="admin-field">
                        <label>Subtitle / ringkasan EN</label>
                        <input name="meta[subtitle_en]" value="{{ $metaValue('subtitle_en') }}" placeholder="English subtitle">
                    </div>
                </div>
                <div class="admin-field">
                    <label>Isi tulisan EN</label>
                    <textarea name="meta[body_en]" placeholder="English content">{{ $metaValue('body_en') }}</textarea>
                </div>
                <div class="admin-grid" style="margin-bottom:16px;">
                    <div class="admin-field">
                        <label>Instagram</label>
                        <input name="meta[social_instagram]" value="{{ $metaValue('social_instagram') }}" placeholder="https://instagram.com/...">
                    </div>
                    <div class="admin-field">
                        <label>Facebook</label>
                        <input name="meta[social_facebook]" value="{{ $metaValue('social_facebook') }}" placeholder="https://facebook.com/...">
                    </div>
                    <div class="admin-field">
                        <label>YouTube</label>
                        <input name="meta[social_youtube]" value="{{ $metaValue('social_youtube') }}" placeholder="https://youtube.com/...">
                    </div>
                    <div class="admin-field">
                        <label>Threads</label>
                        <input name="meta[social_threads]" value="{{ $metaValue('social_threads') }}" placeholder="https://threads.net/@...">
                    </div>
                </div>
                <div class="admin-field">
                    <label>URL / path gambar</label>
                    @php
                        $previewImagePath = old('image_path', $content['image_path']);
                        $previewFallbackImage = asset('assets/img/lapangan/walhi-sumbar-distribusi-logistik.jpeg');
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
                    <label>URL sumber EN (opsional)</label>
                    <input name="meta[source_href_en]" value="{{ $metaValue('source_href_en') }}">
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
                    <a class="admin-button secondary" href="{{ $content['source_href'] ?: ($item['sourceHref'] ?? $item['publicHref'] ?? '#') }}" target="_blank" rel="noreferrer">Lihat sumber</a>
                </div>
            </form>
        </div>
        @if (! empty($item['children']))
            <div class="admin-grid admin-section-spacer">
                @foreach ($item['children'] as $child)
                    <article class="admin-card">
                        <span class="admin-card__label">{{ $item['label'] }}</span>
                        <h2>{{ $child['label'] }}</h2>
                        <p>{{ $child['description'] }}</p>
                        <div class="admin-card__actions">
                            <a class="admin-button" href="{{ $child['href'] ?? '#' }}">Kelola halaman</a>
                            @if (! empty($child['sourceHref']))
                                <a class="admin-button secondary" href="{{ $child['sourceHref'] }}" target="_blank" rel="noreferrer">Sumber</a>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
        </div>
    </div>
</section>
@endsection
