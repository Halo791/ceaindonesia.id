@foreach ($items as $nav)
    @php
        $currentSection = $sectionKey ?? $nav['key'];
        $currentPath = $sectionKey ? array_merge($path, [$nav['key']]) : [];
        $currentItemKey = implode('/', $currentPath);
        $segments = $currentItemKey === '' ? [] : explode('/', $currentItemKey);
        $isMemberAdmin = ($adminUser['role'] ?? 'super_admin') === 'member';
        $canManageCurrent = ! $isMemberAdmin
            || (($adminUser['section_key'] ?? null) === $currentSection && ($adminUser['item_key'] ?? null) === $currentItemKey);
        $href = null;

        if ($canManageCurrent) {
            if ($currentItemKey === '') {
                $href = route('admin.section', $currentSection);
            } elseif (count($segments) === 1) {
                $href = route('admin.item', [$currentSection, $segments[0]]);
            } elseif (count($segments) === 2) {
                $href = route('admin.nested.item', [$currentSection, $segments[0], $segments[1]]);
            } elseif (count($segments) === 3) {
                $href = route('admin.nested.leaf', [$currentSection, $segments[0], $segments[1], $segments[2]]);
            }
        }

        $isActive = $activeSection === $currentSection
            && (($currentItemKey === '' && ! $activeItemKey) || $activeItemKey === $currentItemKey);
        $isAncestor = $activeSection === $currentSection
            && $currentItemKey !== ''
            && $activeItemKey
            && str_starts_with($activeItemKey.'/', $currentItemKey.'/');
    @endphp

    <div class="admin-sidebar__group">
        @if ($href)
            <a href="{{ $href }}" class="{{ $isActive || $isAncestor ? 'active' : '' }}">{{ $nav['label'] }}</a>
        @else
            <span class="admin-sidebar__nav-label {{ $isActive || $isAncestor ? 'active' : '' }}">{{ $nav['label'] }}</span>
        @endif

        @if (! empty($nav['children']))
            <div class="admin-sidebar__children">
                @include('admin.partials.sidebar-items', [
                    'items' => $nav['children'],
                    'activeSection' => $activeSection,
                    'activeItemKey' => $activeItemKey,
                    'sectionKey' => $currentSection,
                    'path' => $currentPath,
                ])
            </div>
        @endif
    </div>
@endforeach
