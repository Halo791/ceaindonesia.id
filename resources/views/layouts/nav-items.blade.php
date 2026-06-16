@foreach ($items as $nav)
    @php
        $href = $nav['publicHref'] ?? $nav['href'];
        $isExternal = $nav['isExternal'] ?? preg_match('/^https?:\/\//i', $href);
        $path = $isExternal ? '' : trim($href, '/');
        $active = ! $isExternal && ($href === '/' ? request()->is('/') : request()->is($path) || request()->is($path.'/*'));
    @endphp
    <li class="{{ ! empty($nav['children']) ? 'menu-item-has-children' : '' }} {{ $active ? 'active' : '' }}">
        <a
            href="{{ $href }}"
            @if ($isExternal)
                target="_blank"
                rel="noopener noreferrer"
            @endif
            @if (! empty($nav['children']))
                aria-haspopup="true"
                aria-expanded="false"
            @endif
        >{{ $nav['label'] }}</a>
        @if (! empty($nav['children']))
            <ul class="sub-menu">
                @include('layouts.nav-items', ['items' => $nav['children']])
            </ul>
        @endif
    </li>
@endforeach
