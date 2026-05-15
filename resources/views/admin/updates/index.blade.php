@extends('layouts.app')

@section('title', 'Update Berita')

@section('content')
<section class="cea-admin-panel">
    <div class="admin-shell">
        @include('admin.partials.sidebar', ['activeCustom' => 'updates'])
        <div class="admin-workspace">
            <div class="admin-hero">
                <div>
                    <span class="admin-eyebrow">Update Simpul & Anggota</span>
                    <h1>Update Berita</h1>
                    <p>Kelola kabar, kegiatan, cerita lapangan, dokumen, atau informasi lain yang melekat pada halaman masing-masing.</p>
                </div>
                <a class="admin-button" href="{{ route('admin.updates.create') }}">Tambah Update</a>
            </div>

            @if (! $dbReady)
                <div class="alert alert-warning">Tabel <strong>admin_updates</strong> belum tersedia. Import <code>database/sql/admin_updates.sql</code> di phpMyAdmin.</div>
            @endif
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <div class="admin-table-card">
                <h2>Daftar Update</h2>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead><tr><th>Judul</th><th>Kategori</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr></thead>
                        <tbody>
                            @forelse ($updates as $update)
                                <tr>
                                    <td><strong>{{ $update->title }}</strong><br><small>{{ $update->excerpt }}</small></td>
                                    <td>{{ $update->category }}</td>
                                    <td><span class="admin-status">{{ ucfirst($update->status) }}</span></td>
                                    <td>{{ optional($update->published_at)->format('d M Y') ?: '-' }}</td>
                                    <td>
                                        <div class="admin-inline-actions">
                                            <a href="{{ route('public.update', $update->slug) }}" target="_blank" rel="noreferrer">Lihat</a>
                                            <a href="{{ route('admin.updates.edit', $update) }}">Edit</a>
                                            <form method="POST" action="{{ route('admin.updates.destroy', $update) }}" onsubmit="return confirm('Hapus update ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5">Belum ada update.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
