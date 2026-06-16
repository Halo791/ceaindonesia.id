@foreach ($items as $sibling)
    @php
        $href = $sibling['publicHref'] ?? $sibling['href'];
        $isExternal = $sibling['isExternal'] ?? preg_match('/^https?:\/\//i', $href);
    @endphp
    <li>
        <a href="{{ $href }}" @if ($isExternal) target="_blank" rel="noopener noreferrer" @endif>{{ $sibling['label'] }}</a>
        @if (! empty($sibling['children']))
            <ul>
                @include('layouts.public-sidebar-items', ['items' => $sibling['children']])
            </ul>
        @endif
    </li>
@endforeach
