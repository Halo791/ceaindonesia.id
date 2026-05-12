@php
    $variant = $variant ?? 'default';
    $tagline = $tagline ?? null;
    $compact = $compact ?? false;
    $panel = $panel ?? false;
    $classes = trim('kso-wordmark kso-wordmark--'.$variant.' '.($compact ? 'kso-wordmark--compact' : '').' '.($panel ? 'kso-wordmark--panel' : ''));
@endphp

<div class="{{ $classes }}" aria-label="Pooling Fund - KSO">
    <span class="kso-wordmark__grid" aria-hidden="true">
        @for ($i = 0; $i < 44; $i++)
            <i class="kso-wordmark__square"></i>
        @endfor
    </span>
    <span class="kso-wordmark__content">
        <span class="kso-wordmark__eyebrow">Pooling Fund</span>
        <strong>KSO</strong>
        @if ($tagline)
            <span class="kso-wordmark__tagline">{{ $tagline }}</span>
        @endif
    </span>
</div>
