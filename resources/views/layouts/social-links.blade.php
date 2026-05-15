@php
    $links = collect($links ?? $socialLinks ?? []);
    $variant = $variant ?? 'default';
@endphp

@if ($links->isNotEmpty())
    <div class="cea-social-links cea-social-links--{{ $variant }}" aria-label="Social media">
        @foreach ($links as $link)
            <a href="{{ $link['url'] }}" target="_blank" rel="noreferrer" aria-label="{{ $link['label'] }}">
                @if (($link['icon'] ?? '') === 'threads')
                    <span>Th</span>
                @else
                    <i class="{{ $link['icon'] }}" aria-hidden="true"></i>
                @endif
            </a>
        @endforeach
    </div>
@endif
