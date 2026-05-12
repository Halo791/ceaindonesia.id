@extends('layouts.app')

@section('title', 'Panel Admin Pooling Fund - KSO')

@section('content')
<section class="cea-admin-panel">
    <div class="admin-shell">
        @include('admin.partials.sidebar')
        <div class="admin-workspace">
        <div class="admin-hero">
            <div>
                <span class="admin-eyebrow">Panel Admin Pooling Fund - KSO</span>
                <h1>Dashboard Konten Pooling Fund - KSO</h1>
                <p>Panel ini mengadopsi struktur menu dan dropdown KSO, lalu menyiapkan ruang kelola untuk setiap kanal.</p>
            </div>
            <a class="admin-source-link" href="https://simpulpfb.id/" target="_blank" rel="noreferrer">Sumber resmi</a>
        </div>

        <div class="admin-stat-strip">
            <div class="admin-stat"><span>Menu utama</span><strong>{{ count($navigation) }}</strong></div>
            <div class="admin-stat"><span>Dropdown</span><strong>{{ $dropdownSections->count() }}</strong></div>
            <div class="admin-stat"><span>Kanal admin</span><strong>{{ $childItems->count() }}</strong></div>
            <div class="admin-stat"><span>Status</span><strong>Draft</strong></div>
        </div>

        <div class="admin-grid">
            @foreach ($dropdownSections as $section)
                <article class="admin-card">
                    <span class="admin-card__label">{{ count($section['children']) }} dropdown</span>
                    <h2>{{ $section['label'] }}</h2>
                    <p>{{ $section['description'] }}</p>
                    <div class="admin-card__actions">
                        <a class="admin-button" href="{{ route('admin.section', $section['key']) }}">Kelola {{ $section['label'] }}</a>
                        <a class="admin-button secondary" href="{{ $section['sourceHref'] }}" target="_blank" rel="noreferrer">Lihat sumber</a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="admin-table-card admin-section-spacer">
            <h2>Semua Halaman Dropdown</h2>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead><tr><th>Section</th><th>Halaman</th><th>Deskripsi</th><th>Status</th><th>Aksi</th></tr></thead>
                    <tbody>
                        @foreach ($childItems as $item)
                            <tr>
                                <td>{{ $item['section_label'] }}</td>
                                <td><strong>{{ $item['label'] }}</strong></td>
                                <td>{{ $item['description'] }}</td>
                                <td><span class="admin-status">Siap diedit</span></td>
                                <td><a href="{{ route('admin.item', [$item['section_key'], $item['key']]) }}">Kelola</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
</section>
@endsection
