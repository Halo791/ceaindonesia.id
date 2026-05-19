@extends('layouts.app')

@section('title', 'Tambah KSO')

@section('content')
<section class="cea-admin-panel">
    <div class="admin-shell">
        @include('admin.partials.sidebar', ['activeCustom' => 'ksos'])
        <div class="admin-workspace">
            <div class="admin-hero">
                <div>
                    <span class="admin-eyebrow">Register KSO</span>
                    <h1>Tambah KSO Baru</h1>
                    <p>Buat akun anggota simpul dan halaman KSO yang dapat dikelola setelah login.</p>
                </div>
                <a class="admin-button secondary" href="{{ route('admin.ksos.index') }}">Kembali</a>
            </div>

            @if (! $dbReady)
                <div class="alert alert-warning">Tabel <strong>admin_users</strong> belum tersedia. Jalankan migration atau import <code>database/sql/admin_users.sql</code> terlebih dulu.</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <div class="admin-form-card">
                <form method="POST" action="{{ route('admin.ksos.store') }}">
                    @csrf

                    <div class="admin-field">
                        <label>Nama KSO / organisasi</label>
                        <input name="name" value="{{ old('name') }}" required>
                    </div>

                    <div class="admin-field">
                        <label>Simpul region</label>
                        <select name="region_key" required>
                            <option value="">Pilih simpul region</option>
                            @foreach ($regions as $region)
                                <option value="{{ $region['key'] }}" @selected(old('region_key') === $region['key'])>{{ $region['label'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="admin-field">
                        <label>Username login</label>
                        <input name="username" value="{{ old('username') }}" placeholder="Kosongkan untuk dibuat otomatis">
                    </div>

                    <div class="admin-field">
                        <label>Password login</label>
                        <input name="password" type="password" required>
                        <small>Minimal 8 karakter. Password ini dipakai KSO baru untuk login ke panel admin.</small>
                    </div>

                    <div class="admin-field admin-check-field">
                        <label>
                            <input name="is_active" type="hidden" value="0">
                            <input name="is_active" type="checkbox" value="1" @checked(old('is_active', true))>
                            Aktifkan akun setelah disimpan
                        </label>
                    </div>

                    <div class="admin-form-actions">
                        <button class="admin-button" type="submit">Register KSO</button>
                        <a class="admin-button secondary" href="{{ route('admin.ksos.index') }}">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
