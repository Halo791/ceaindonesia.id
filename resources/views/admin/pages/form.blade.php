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
                <div class="alert alert-warning">Tabel <strong>admin_pages</strong> belum tersedia. Jalankan migration atau import <code>database/sql/admin_pages.sql</code> di phpMyAdmin.</div>
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
                        <label>Slug URL</label>
                        <input name="slug" value="{{ old('slug', $page->slug) }}" placeholder="contoh: tentang-kami">
                        <small>Kosongkan untuk membuat slug otomatis dari judul. URL publik: <code>/halaman/slug</code></small>
                    </div>

                    <div class="admin-field">
                        <label>Label menu</label>
                        <input name="menu_label" value="{{ old('menu_label', $page->menu_label) }}" placeholder="Kosongkan jika sama dengan judul">
                    </div>

                    <div class="admin-field">
                        <label>Jadikan submenu dari</label>
                        <select name="parent_id">
                            <option value="">Tidak ada - tampil sebagai menu utama</option>
                            @foreach ($parentPages as $parent)
                                <option value="{{ $parent->id }}" @selected((string) old('parent_id', $page->parent_id) === (string) $parent->id)>{{ $parent->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="admin-field">
                        <label>Subtitle / Ringkasan</label>
                        <input name="subtitle" value="{{ old('subtitle', $page->subtitle) }}">
                    </div>

                    <div class="admin-field">
                        <label>Isi tulisan</label>
                        <textarea name="body">{{ old('body', $page->body) }}</textarea>
                    </div>

                    <div class="admin-field">
                        <label>URL / path gambar</label>
                        <input name="image_path" value="{{ old('image_path', $page->image_path) }}" placeholder="Kosongkan untuk foto lapangan otomatis atau gunakan https://...">
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
