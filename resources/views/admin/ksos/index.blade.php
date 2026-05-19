@extends('layouts.app')

@section('title', 'Register KSO')

@section('content')
<section class="cea-admin-panel">
    <div class="admin-shell">
        @include('admin.partials.sidebar', ['activeCustom' => 'ksos'])
        <div class="admin-workspace">
            <div class="admin-hero">
                <div>
                    <span class="admin-eyebrow">Panel Admin Pooling Fund - KSO</span>
                    <h1>Register KSO</h1>
                    <p>Tambahkan akun anggota KSO baru ke simpul regional agar muncul di panel admin dan halaman publik.</p>
                </div>
                <a class="admin-button" href="{{ route('admin.ksos.create') }}">Tambah KSO</a>
            </div>

            @if (! $dbReady)
                <div class="alert alert-warning">Tabel <strong>admin_users</strong> belum tersedia. Jalankan migration atau import <code>database/sql/admin_users.sql</code> terlebih dulu.</div>
            @endif
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <div class="admin-table-card">
                <h2>Daftar KSO Terdaftar</h2>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Nama KSO</th>
                                <th>Region</th>
                                <th>Username</th>
                                <th>Halaman</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ksos as $kso)
                                @php
                                    $segments = explode('/', $kso->item_key);
                                    $regionKey = $segments[1] ?? '';
                                    $memberKey = $segments[2] ?? '';
                                    $region = $regions[$regionKey] ?? null;
                                @endphp
                                <tr>
                                    <td><strong>{{ $kso->name }}</strong></td>
                                    <td>{{ $region['shortLabel'] ?? $regionKey }}</td>
                                    <td>{{ $kso->username }}</td>
                                    <td>
                                        @if ($regionKey && $memberKey)
                                            <a href="{{ route('admin.nested.leaf', ['regio', 'simpul', $regionKey, $memberKey]) }}">Kelola</a>
                                            <span> · </span>
                                            <a href="{{ route('public.nested.leaf', ['regio', 'simpul', $regionKey, $memberKey]) }}" target="_blank" rel="noreferrer">Publik</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td><span class="admin-status">{{ $kso->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">Belum ada KSO terdaftar.</td>
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
