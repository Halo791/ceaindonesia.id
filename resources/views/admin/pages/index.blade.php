@extends('layouts.app')

@section('title', 'Halaman Dinamis')

@section('content')
<section class="cea-admin-panel">
    <div class="admin-shell">
        @include('admin.partials.sidebar', ['activeCustom' => 'pages'])
        <div class="admin-workspace">
            <div class="admin-hero">
                <div>
                    <span class="admin-eyebrow">Panel Admin Pooling Fund - KSO</span>
                    <h1>Halaman Dinamis</h1>
                    <p>Buat halaman baru dan tampilkan sebagai menu utama atau submenu di navigasi website.</p>
                </div>
                <a class="admin-button" href="{{ route('admin.pages.create') }}">Tambah Halaman</a>
            </div>

            @if (! $dbReady)
                <div class="alert alert-warning">Tabel <strong>admin_pages</strong> belum tersedia. Jalankan migration atau import <code>database/sql/admin_pages.sql</code> di phpMyAdmin.</div>
            @endif
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <div class="admin-table-card">
                <h2>Daftar Halaman</h2>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>URL</th>
                                <th>Parent</th>
                                <th>Navigasi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pages as $page)
                                <tr>
                                    <td><strong>{{ $page->title }}</strong><br><small>{{ $page->menu_label ?: 'Label mengikuti judul' }}</small></td>
                                    <td><a href="{{ route('dynamic.page', $page->slug) }}" target="_blank" rel="noreferrer">/halaman/{{ $page->slug }}</a></td>
                                    <td>{{ $page->parent?->title ?: 'Menu utama' }}</td>
                                    <td><span class="admin-status">{{ $page->show_in_navigation ? 'Tampil' : 'Sembunyi' }}</span></td>
                                    <td>{{ ucfirst($page->status) }}</td>
                                    <td>
                                        <div class="admin-inline-actions">
                                            <a href="{{ route('admin.pages.edit', $page) }}">Edit</a>
                                            <form method="POST" action="{{ route('admin.pages.destroy', $page) }}" onsubmit="return confirm('Hapus halaman ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">Belum ada halaman dinamis.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
