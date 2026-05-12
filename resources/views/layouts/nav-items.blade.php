@foreach ($items as $nav)
    @php
        $href = $nav['publicHref'] ?? $nav['href'];
        $path = trim($href, '/');
        $active = $href === '/' ? request()->is('/') : request()->is($path) || request()->is($path.'/*');
    @endphp
    <li class="{{ ! empty($nav['children']) ? 'menu-item-has-children' : '' }} {{ $active ? 'active' : '' }}">
        <a href="{{ $href }}">{{ $nav['label'] }}</a>
        @if (! empty($nav['children']))
            <ul class="sub-menu">
                @include('layouts.nav-items', ['items' => $nav['children']])
            </ul>
        @endif
    </li>
@endforeach
