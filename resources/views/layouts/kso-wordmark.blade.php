@php
    $variant = $variant ?? 'default';
    $tagline = $tagline ?? null;
    $compact = $compact ?? false;
    $panel = $panel ?? false;
    $src = $src ?? asset('assets/img/cea/video.mp4');
    $alt = $alt ?? 'PF KSO Pooling Fund Kemanusiaan';
    $classes = trim('kso-wordmark kso-wordmark--'.$variant.' '.($compact ? 'kso-wordmark--compact' : '').' '.($panel ? 'kso-wordmark--panel' : ''));
@endphp

<div class="{{ $classes }}" aria-label="Pooling Fund - KSO">
    <img class="kso-wordmark__image" src="{{ $src }}" alt="{{ $alt }}">
</div>
