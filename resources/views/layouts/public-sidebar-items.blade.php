@foreach ($items as $sibling)
    <li>
        <a href="{{ $sibling['publicHref'] ?? $sibling['href'] }}">{{ $sibling['label'] }}</a>
        @if (! empty($sibling['children']))
            <ul>
                @include('layouts.public-sidebar-items', ['items' => $sibling['children']])
            </ul>
        @endif
    </li>
@endforeach
