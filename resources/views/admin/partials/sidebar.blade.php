@php
    $activeSection = $activeSection ?? null;
    $activeItemKey = $activeItemKey ?? null;
    $activeCustom = $activeCustom ?? null;
    $countItems = function ($items) use (&$countItems) {
        return collect($items)->sum(fn ($item) => 1 + $countItems($item['children'] ?? []));
    };
    $childCount = $countItems($navigation);
@endphp

<aside class="admin-sidebar">
    <div class="admin-sidebar__brand">
        <span>Pooling Fund - KSO CMS</span>
        <strong>{{ $childCount }} kanal admin</strong>
        @if (! empty($adminUser['username']))
            <small>{{ $adminUser['name'] ?? $adminUser['username'] }} · {{ $adminUser['role'] === 'member' ? 'Anggota Simpul' : 'Super Admin' }}</small>
        @endif
    </div>
    <form method="POST" action="{{ route('admin.logout') }}" style="padding:12px 12px 0;">
        @csrf
        <button class="admin-button secondary" type="submit" style="width:100%;">Logout</button>
    </form>
    <nav class="admin-sidebar__nav" aria-label="Navigasi panel admin">
        @if (($adminUser['role'] ?? 'super_admin') !== 'member')
            <a href="{{ route('admin.index') }}" class="{{ ! $activeSection && ! $activeCustom ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('admin.pages.index') }}" class="{{ $activeCustom === 'pages' ? 'active' : '' }}">Halaman Dinamis</a>
            <a href="{{ route('admin.menu-labels.edit') }}" class="{{ $activeCustom === 'menu-labels' ? 'active' : '' }}">Nama Menu</a>
            <a href="{{ route('admin.ksos.index') }}" class="{{ $activeCustom === 'ksos' ? 'active' : '' }}">Register KSO</a>
        @endif
        <a href="{{ route('admin.updates.index') }}" class="{{ $activeCustom === 'updates' ? 'active' : '' }}">Update Berita</a>
        @include('admin.partials.sidebar-items', [
            'items' => $navigation,
            'activeSection' => $activeSection,
            'activeItemKey' => $activeItemKey,
            'sectionKey' => null,
            'path' => [],
        ])
    </nav>
</aside>
