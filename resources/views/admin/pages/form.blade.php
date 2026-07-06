@extends('layouts.app')

@section('title', $title)

@section('content')
<section class="cea-admin-panel">
    <div class="admin-shell">
        @include('admin.partials.sidebar', ['activeCustom' => 'pages'])
        <div class="admin-workspace">
            <div class="admin-hero">
                <div>
                    <span class="admin-eyebrow">Halaman Dinamis</span>
                    <h1>{{ $title }}</h1>
                    <p>Atur konten halaman, URL, status publikasi, dan posisinya di navigasi website.</p>
                </div>
                <a class="admin-button secondary" href="{{ route('admin.pages.index') }}">Kembali</a>
            </div>

            @if (! $dbReady)
                <div class="alert alert-warning">Tabel <strong>admin_pages</strong> belum tersedia atau belum punya kolom navigasi/bilingual/link eksternal/media. Jalankan migration atau import <code>database/sql/admin_pages.sql</code>, <code>database/sql/add_bilingual_fields.sql</code>, <code>database/sql/add_external_url_to_admin_pages.sql</code>, dan <code>database/sql/add_dynamic_page_media_fields.sql</code> di phpMyAdmin.</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <div class="admin-form-card">
                <form method="POST" action="{{ $formAction }}">
                    @csrf
                    @if ($method !== 'POST')
                        @method($method)
                    @endif

                    <div class="admin-field">
                        <label>Judul halaman</label>
                        <input name="title" value="{{ old('title', $page->title) }}" required>
                    </div>

                    <div class="admin-field">
                        <label>Judul halaman EN</label>
                        <input name="title_en" value="{{ old('title_en', $page->title_en) }}" placeholder="English title">
                    </div>

                    <div class="admin-field">
                        <label>Slug URL</label>
                        <input name="slug" value="{{ old('slug', $page->slug) }}" placeholder="contoh: tentang-kami">
                        <small>Kosongkan untuk membuat slug otomatis dari judul. URL publik: <code>/halaman/slug</code></small>
                    </div>

                    <div class="admin-field">
                        <label>Label menu</label>
                        <input name="menu_label" value="{{ old('menu_label', $page->menu_label) }}" placeholder="Kosongkan jika sama dengan judul">
                    </div>

                    <div class="admin-field">
                        <label>Label menu EN</label>
                        <input name="menu_label_en" value="{{ old('menu_label_en', $page->menu_label_en) }}" placeholder="Kosongkan jika sama dengan judul EN">
                    </div>

                    <div class="admin-field">
                        <label>Jadikan submenu dari</label>
                        <select name="parent_id">
                            <option value="">Tidak ada - tampil sebagai menu utama</option>
                            @foreach ($parentPages as $parent)
                                <option value="{{ $parent->id }}" @selected((string) old('parent_id', $page->parent_id) === (string) $parent->id)>{{ $parent->title }}</option>
                            @endforeach
                        </select>
                        <small>Gunakan ini untuk membuat submenu di bawah halaman dinamis lain.</small>
                    </div>

                    <div class="admin-field">
                        <label>Tempatkan di menu/submenu website</label>
                        <select name="navigation_parent_key">
                            <option value="">Tidak ada - tampil sebagai menu utama jika tidak punya parent dinamis</option>
                            @foreach ($navigationParents as $parent)
                                <option value="{{ $parent['key'] }}" @selected((string) old('navigation_parent_key', $page->navigation_parent_key) === (string) $parent['key'])>{{ $parent['label'] }}</option>
                            @endforeach
                        </select>
                        <small>Jika dipilih, halaman ini akan muncul sebagai submenu pada menu/submenu tersebut.</small>
                    </div>

                    <div class="admin-field">
                        <label>Subtitle / Ringkasan</label>
                        <input name="subtitle" value="{{ old('subtitle', $page->subtitle) }}">
                    </div>

                    <div class="admin-field">
                        <label>Subtitle / Ringkasan EN</label>
                        <input name="subtitle_en" value="{{ old('subtitle_en', $page->subtitle_en) }}">
                    </div>

                    <div class="admin-field">
                        <label>Isi tulisan</label>
                        <textarea name="body">{{ old('body', $page->body) }}</textarea>
                    </div>

                    <div class="admin-field">
                        <label>Isi tulisan EN</label>
                        <textarea name="body_en">{{ old('body_en', $page->body_en) }}</textarea>
                    </div>

                    <div class="admin-field">
                        <label>URL / path gambar</label>
                        <input name="image_path" value="{{ old('image_path', $page->image_path) }}" placeholder="Kosongkan untuk foto lapangan otomatis, link Google Drive, atau https://...">
                    </div>

                    <div class="admin-grid" style="margin-bottom:16px;">
                        <div class="admin-field">
                            <label>Video background halaman</label>
                            <input name="hero_video_path" value="{{ old('hero_video_path', $page->hero_video_path) }}" placeholder="https://drive.google.com/file/d/.../view, https://youtu.be/VIDEO_ID, atau /assets/img/cea/video.mp4">
                            <small>Opsional. Isi dengan link Google Drive, YouTube, atau path video lokal untuk background hero halaman dinamis ini.</small>
                        </div>
                        <div class="admin-field">
                            <label>Logo header halaman</label>
                            <input name="header_logo_path" value="{{ old('header_logo_path', $page->header_logo_path) }}" placeholder="https://drive.google.com/file/d/.../view atau /assets/img/...">
                            <small>Opsional. Logo ini tampil di header halaman dinamis ini dan artikel miliknya.</small>
                        </div>
                    </div>

                    <div class="admin-field">
                        <label>Link website lain</label>
                        <input name="external_url" type="url" value="{{ old('external_url', $page->external_url) }}" placeholder="https://contoh-website.org/halaman">
                        <small>Opsional. Jika diisi, halaman/menu ini akan membuka link tersebut, bukan halaman konten internal.</small>
                    </div>

                    <div class="admin-field">
                        <label>Status publikasi</label>
                        <select name="status">
                            <option value="draft" @selected(old('status', $page->status) === 'draft')>Draft</option>
                            <option value="active" @selected(old('status', $page->status) === 'active')>Aktif</option>
                            <option value="archived" @selected(old('status', $page->status) === 'archived')>Arsip</option>
                        </select>
                    </div>

                    <div class="admin-field">
                        <label>Urutan menu</label>
                        <input name="sort_order" type="number" min="0" max="9999" value="{{ old('sort_order', $page->sort_order ?? 0) }}">
                    </div>

                    <div class="admin-field admin-check-field">
                        <label>
                            <input name="show_in_navigation" type="hidden" value="0">
                            <input name="show_in_navigation" type="checkbox" value="1" @checked(old('show_in_navigation', $page->show_in_navigation))>
                            Tampilkan halaman ini di navigasi website
                        </label>
                    </div>

                    <div class="admin-form-actions">
                        <button class="admin-button" type="submit">Simpan Halaman</button>
                        <a class="admin-button secondary" href="{{ route('admin.pages.index') }}">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
