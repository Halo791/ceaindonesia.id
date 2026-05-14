@php
    $activeSection = $activeSection ?? null;
    $activeItemKey = $activeItemKey ?? null;
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
            <a href="{{ route('admin.index') }}" class="{{ ! $activeSection ? 'active' : '' }}">Dashboard</a>
        @endif
        @include('admin.partials.sidebar-items', [
            'items' => $navigation,
            'activeSection' => $activeSection,
            'activeItemKey' => $activeItemKey,
            'sectionKey' => null,
            'path' => [],
        ])
    </nav>
</aside>
