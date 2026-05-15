@extends('layouts.app')

@section('title', $title)

@section('content')
<section class="cea-admin-panel">
    <div class="admin-shell">
        @include('admin.partials.sidebar', ['activeCustom' => 'updates'])
        <div class="admin-workspace">
            <div class="admin-hero">
                <div>
                    <span class="admin-eyebrow">Update Simpul & Anggota</span>
                    <h1>{{ $title }}</h1>
                    <p>Update ini akan tampil pada halaman simpul atau anggota yang dipilih.</p>
                </div>
                <a class="admin-button secondary" href="{{ route('admin.updates.index') }}">Kembali</a>
            </div>

            @if (! $dbReady)
                <div class="alert alert-warning">Tabel <strong>admin_updates</strong> belum tersedia atau belum punya kolom bilingual. Import <code>database/sql/admin_updates.sql</code> dan <code>database/sql/add_bilingual_fields.sql</code> di phpMyAdmin.</div>
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
                        <label>Halaman pemilik</label>
                        <select name="target" @disabled(($adminUser['role'] ?? null) === 'member')>
                            @foreach ($targets as $target)
                                <option value="{{ $target['value'] }}" @selected(old('target', $update->owner_section_key.'|'.$update->owner_item_key) === $target['value'])>{{ $target['label'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="admin-field">
                        <label>Judul update</label>
                        <input name="title" value="{{ old('title', $update->title) }}" required>
                    </div>

                    <div class="admin-field">
                        <label>Judul update EN</label>
                        <input name="title_en" value="{{ old('title_en', $update->title_en) }}" placeholder="English title">
                    </div>

                    <div class="admin-field">
                        <label>Slug URL</label>
                        <input name="slug" value="{{ old('slug', $update->slug) }}" placeholder="Kosongkan untuk otomatis">
                        <small>URL publik akan menjadi <code>/artikel/detail/slug</code>.</small>
                    </div>

                    <div class="admin-field">
                        <label>Kategori</label>
                        <select name="category">
                            @foreach (['Berita', 'Kegiatan', 'Cerita Lapangan', 'Dokumen', 'Pengumuman'] as $category)
                                <option value="{{ $category }}" @selected(old('category', $update->category) === $category)>{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="admin-field">
                        <label>Kategori EN</label>
                        <input name="category_en" value="{{ old('category_en', $update->category_en) }}" placeholder="News, Activity, Field Story...">
                    </div>

                    <div class="admin-field">
                        <label>Ringkasan</label>
                        <input name="excerpt" value="{{ old('excerpt', $update->excerpt) }}">
                    </div>

                    <div class="admin-field">
                        <label>Ringkasan EN</label>
                        <input name="excerpt_en" value="{{ old('excerpt_en', $update->excerpt_en) }}">
                    </div>

                    <div class="admin-field">
                        <label>Isi update</label>
                        <textarea name="body">{{ old('body', $update->body) }}</textarea>
                    </div>

                    <div class="admin-field">
                        <label>Isi update EN</label>
                        <textarea name="body_en">{{ old('body_en', $update->body_en) }}</textarea>
                    </div>

                    <div class="admin-field">
                        <label>URL / path gambar</label>
                        <input name="image_path" value="{{ old('image_path', $update->image_path) }}">
                    </div>

                    <div class="admin-field">
                        <label>Status</label>
                        <select name="status">
                            <option value="draft" @selected(old('status', $update->status) === 'draft')>Draft</option>
                            <option value="active" @selected(old('status', $update->status) === 'active')>Aktif</option>
                            <option value="archived" @selected(old('status', $update->status) === 'archived')>Arsip</option>
                        </select>
                    </div>

                    <div class="admin-field">
                        <label>Tanggal publikasi</label>
                        <input name="published_at" type="datetime-local" value="{{ old('published_at', optional($update->published_at)->format('Y-m-d\\TH:i')) }}">
                    </div>

                    <div class="admin-form-actions">
                        <button class="admin-button" type="submit">Simpan Update</button>
                        <a class="admin-button secondary" href="{{ route('admin.updates.index') }}">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
