@php
    $activeSection = $activeSection ?? null;
    $activeItem = $activeItem ?? null;
    $childCount = collect($navigation)->filter(fn ($section) => ! empty($section['children']))->flatMap(fn ($section) => $section['children'])->count();
@endphp

<aside class="admin-sidebar">
    <div class="admin-sidebar__brand">
        <span>Pooling Fund - KSO CMS</span>
        <strong>{{ $childCount }} kanal dropdown</strong>
    </div>
    <form method="POST" action="{{ route('admin.logout') }}" style="padding:12px 12px 0;">
        @csrf
        <button class="admin-button secondary" type="submit" style="width:100%;">Logout</button>
    </form>
    <nav class="admin-sidebar__nav" aria-label="Navigasi panel admin">
        <a href="{{ route('admin.index') }}" class="{{ ! $activeSection ? 'active' : '' }}">Dashboard</a>
        @foreach ($navigation as $section)
            <div class="admin-sidebar__group">
                <a href="{{ route('admin.section', $section['key']) }}" class="{{ $activeSection === $section['key'] && ! $activeItem ? 'active' : '' }}">
                    {{ $section['label'] }}
                </a>
                @if (! empty($section['children']))
                    <div class="admin-sidebar__children">
                        @foreach ($section['children'] as $item)
                            <a href="{{ route('admin.item', [$section['key'], $item['key']]) }}" class="{{ $activeSection === $section['key'] && $activeItem === $item['key'] ? 'active' : '' }}">
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </nav>
</aside>
