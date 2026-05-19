@extends('layouts.app')

@section('title', 'Nama Menu')

@section('content')
<section class="cea-admin-panel">
    <div class="admin-shell">
        @include('admin.partials.sidebar', ['activeCustom' => 'menu-labels'])
        <div class="admin-workspace">
            <div class="admin-hero">
                <div>
                    <span class="admin-eyebrow">Panel Superadmin</span>
                    <h1>Edit Nama Menu & Submenu</h1>
                    <p>Ubah label menu yang tampil di sidebar panel admin dan navigasi website tanpa mengubah struktur URL.</p>
                </div>
            </div>

            @if (! $dbReady)
                <div class="alert alert-warning">Tabel <strong>admin_contents</strong> belum tersedia. Import <code>database/sql/admin_contents.sql</code> terlebih dulu.</div>
            @endif
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <div class="admin-form-card">
                <form method="POST" action="{{ route('admin.menu-labels.update') }}">
                    @csrf

                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Menu Saat Ini</th>
                                    <th>Nama Baru ID</th>
                                    <th>Nama Baru EN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($menuItems as $index => $item)
                                    <tr>
                                        <td>
                                            <strong style="padding-left:{{ $item['depth'] * 18 }}px;">{{ $item['label'] }}</strong>
                                            @if (! empty($item['item_key']))
                                                <br><small style="padding-left:{{ $item['depth'] * 18 }}px;">{{ $item['section_key'] }}/{{ $item['item_key'] }}</small>
                                            @else
                                                <br><small>{{ $item['section_key'] }}</small>
                                            @endif
                                            <input type="hidden" name="items[{{ $index }}][section_key]" value="{{ $item['section_key'] }}">
                                            <input type="hidden" name="items[{{ $index }}][item_key]" value="{{ $item['item_key'] }}">
                                            <input type="hidden" name="items[{{ $index }}][fallback_label]" value="{{ $item['label'] }}">
                                            <input type="hidden" name="items[{{ $index }}][fallback_description]" value="{{ $item['description'] }}">
                                        </td>
                                        <td>
                                            <input name="items[{{ $index }}][menu_label]" value="{{ old("items.{$index}.menu_label", $item['menu_label']) }}" placeholder="{{ $item['label'] }}">
                                        </td>
                                        <td>
                                            <input name="items[{{ $index }}][menu_label_en]" value="{{ old("items.{$index}.menu_label_en", $item['menu_label_en']) }}" placeholder="English label">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="admin-form-actions">
                        <button class="admin-button" type="submit">Simpan Nama Menu</button>
                        <a class="admin-button secondary" href="{{ route('admin.index') }}">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
