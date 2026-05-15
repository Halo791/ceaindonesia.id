@extends('layouts.app')

@section('title', 'Admin '.$section['label'])

@php
    $isHomepage = $section['key'] === 'beranda';
    $homeMeta = $content['meta'] ?? [];
    $metaValue = function (string $key, string $fallback = '') use ($homeMeta) {
        return old("meta.{$key}", $homeMeta[$key] ?? $fallback);
    };
@endphp

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
            <!-- <a class="admin-source-link" href="{{ $section['sourceHref'] }}" target="_blank" rel="noreferrer">Sumber resmi</a> -->
        </div>

        <div class="admin-stat-strip">
            <div class="admin-stat"><span>Tipe</span><strong>{{ empty($section['children']) ? 'Menu' : 'Dropdown' }}</strong></div>
            <div class="admin-stat"><span>Subhalaman</span><strong>{{ count($section['children'] ?? []) ?: 1 }}</strong></div>
            <div class="admin-stat"><span>Bahasa</span><strong>ID / EN</strong></div>
            <div class="admin-stat"><span>Status</span><strong>Aktif</strong></div>
        </div>

        <div class="admin-form-card admin-section-spacer">
            <h2>{{ $isHomepage ? 'Pengaturan Halaman Beranda' : 'Form Konten Menu '.$section['label'] }}</h2>
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
                    <label>{{ $isHomepage ? 'Judul hero beranda' : 'Judul menu' }}</label>
                    <input name="title" value="{{ old('title', $content['title']) }}" required>
                    @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="admin-field">
                    <label>{{ $isHomepage ? 'Tulisan kecil di atas judul' : 'Subtitle / Ringkasan' }}</label>
                    <input name="subtitle" value="{{ old('subtitle', $content['subtitle']) }}">
                </div>
                <div class="admin-field">
                    <label>{{ $isHomepage ? 'Deskripsi hero beranda' : 'Isi tulisan' }}</label>
                    <textarea name="body">{{ old('body', $content['body']) }}</textarea>
                </div>
                <div class="admin-grid" style="margin-bottom:16px;">
                    <div class="admin-field">
                        <label>{{ $isHomepage ? 'Hero title EN' : 'Judul menu EN' }}</label>
                        <input name="meta[title_en]" value="{{ $metaValue('title_en') }}" placeholder="English title">
                    </div>
                    <div class="admin-field">
                        <label>{{ $isHomepage ? 'Hero eyebrow EN' : 'Subtitle / ringkasan EN' }}</label>
                        <input name="meta[subtitle_en]" value="{{ $metaValue('subtitle_en') }}" placeholder="English subtitle">
                    </div>
                </div>
                <div class="admin-field">
                    <label>{{ $isHomepage ? 'Deskripsi hero EN' : 'Isi tulisan EN' }}</label>
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
                    <label>{{ $isHomepage ? 'Path video background' : 'URL / path gambar' }}</label>
                    @php
                        $previewImagePath = (string) old('image_path', $content['image_path']);
                        $previewFallbackImage = asset('assets/img/lapangan/walhi-sumut-tandon-air-1.jpeg');
                        $previewImageSrc = ($previewImagePath && strpos($previewImagePath, 'assets/img/cea/') !== false) ? $previewFallbackImage : $previewImagePath;
                        $previewVideoSrc = ($previewImagePath && preg_match('/^https?:\/\//', $previewImagePath)) ? $previewImagePath : asset(ltrim($previewImagePath, '/'));
                    @endphp
                    <input name="image_path" value="{{ $previewImagePath }}" placeholder="{{ $isHomepage ? '/assets/img/cea/video.mp4' : 'Kosongkan untuk foto lapangan otomatis atau gunakan https://...' }}">
                    @if ($isHomepage && ! empty($previewImagePath))
                        <video src="{{ $previewVideoSrc }}" autoplay muted loop playsinline style="border-radius:8px;margin-top:12px;max-height:190px;object-fit:cover;width:100%;"></video>
                    @elseif (! empty($previewImageSrc))
                        <img src="{{ $previewImageSrc }}" alt="{{ $content['title'] }}" style="border-radius:8px;margin-top:12px;max-height:180px;object-fit:cover;width:100%;">
                    @endif
                </div>
                @if ($isHomepage)
                    <input type="hidden" name="source_href" value="{{ old('source_href', $content['source_href']) }}">
                    <div class="admin-grid" style="margin-bottom:16px;">
                        <div class="admin-field">
                            <label>Label tombol utama</label>
                            <input name="meta[primary_label]" value="{{ $metaValue('primary_label') }}">
                        </div>
                        <div class="admin-field">
                            <label>Label tombol utama EN</label>
                            <input name="meta[primary_label_en]" value="{{ $metaValue('primary_label_en') }}">
                        </div>
                        <div class="admin-field">
                            <label>URL tombol utama</label>
                            <input name="meta[primary_href]" value="{{ $metaValue('primary_href') }}">
                        </div>
                        <div class="admin-field">
                            <label>Label tombol kedua</label>
                            <input name="meta[secondary_label]" value="{{ $metaValue('secondary_label') }}">
                        </div>
                        <div class="admin-field">
                            <label>Label tombol kedua EN</label>
                            <input name="meta[secondary_label_en]" value="{{ $metaValue('secondary_label_en') }}">
                        </div>
                        <div class="admin-field">
                            <label>URL tombol kedua</label>
                            <input name="meta[secondary_href]" value="{{ $metaValue('secondary_href') }}">
                        </div>
                        <div class="admin-field">
                            <label>Label panel angka</label>
                            <input name="meta[panel_label]" value="{{ $metaValue('panel_label') }}">
                        </div>
                        <div class="admin-field">
                            <label>Label panel angka EN</label>
                            <input name="meta[panel_label_en]" value="{{ $metaValue('panel_label_en') }}">
                        </div>
                        <div class="admin-field">
                            <label>Angka panel</label>
                            <input name="meta[panel_value]" value="{{ $metaValue('panel_value') }}">
                        </div>
                    </div>
                    <div class="admin-field">
                        <label>Deskripsi panel angka</label>
                        <input name="meta[panel_description]" value="{{ $metaValue('panel_description') }}">
                    </div>
                    <div class="admin-field">
                        <label>Deskripsi panel angka EN</label>
                        <input name="meta[panel_description_en]" value="{{ $metaValue('panel_description_en') }}">
                    </div>
                @else
                    <div class="admin-field">
                        <label>URL sumber</label>
                        <input name="source_href" value="{{ old('source_href', $content['source_href']) }}">
                    </div>
                    <div class="admin-field">
                        <label>URL sumber EN (opsional)</label>
                        <input name="meta[source_href_en]" value="{{ $metaValue('source_href_en') }}">
                    </div>
                @endif
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
