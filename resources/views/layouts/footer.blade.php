@php
    $publicChannelLinks = [
        ['href' => '/profil/mandat-visi-nilai', 'id' => 'Mandat, Visi, Misi', 'en' => 'Mandate, Vision, Mission'],
        ['href' => '/profil/tujuan-prinsip', 'id' => 'Tujuan & Prinsip', 'en' => 'Goals & Principles'],
        ['href' => '/profil/struktur-gerak', 'id' => 'Arsitektur Mandat', 'en' => 'Mandate Architecture'],
        ['href' => '/profil/sumber-daya', 'id' => 'Tata Kelola Sumber Daya', 'en' => 'Resource Governance'],
        ['href' => '/regio/simpul', 'id' => 'Sebaran Simpul', 'en' => 'Hub Distribution'],
    ];
    $donation = $donationSettings ?? [];
    $qrisImagePath = trim((string) ($donation['qris_image_path'] ?? ''));
    $qrisImageSrc = $qrisImagePath && preg_match('/^https?:\/\//', $qrisImagePath) ? $qrisImagePath : ($qrisImagePath ? asset(ltrim($qrisImagePath, '/')) : '');
    $donationTitle = $donation['qris_title'] ?? '';
    $donationBody = $donation['qris_body'] ?? '';
    $donationNote = $donation['qris_note'] ?? '';
    $donationRecipient = $donation['qris_recipient'] ?? '';
    $qrisImageAlt = ($donation['qris_image_alt'] ?? '') ?: ($donationRecipient ? 'QRIS '.$donationRecipient : ($ui['donate_qris'] ?? 'Donasi via QRIS'));
@endphp

<footer class="cea-landing-footer">
    <div class="container">
        <div class="cea-footer-grid">
            <div class="cea-footer-brand">
                @include('layouts.kso-wordmark', ['variant' => 'footer', 'compact' => true])
                <p>{{ $ui['footer_description'] ?? 'Platform mandat kolektif antar CSO untuk menghimpun dan menyalurkan dana kemanusiaan berbasis kebutuhan komunitas dan kepemimpinan lokal.' }}</p>
                <div class="mt-3">
                    @include('layouts.social-links', ['links' => $socialLinks ?? [], 'variant' => 'footer'])
                </div>
            </div>
            <div>
                <h3>{{ $ui['menu'] ?? 'Menu' }}</h3>
                <ul>
                    @foreach ($navigation as $item)
                        <li><a href="{{ $item['publicHref'] ?? $item['href'] }}">{{ $item['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h3>{{ $ui['public_channels'] ?? 'Kanal Publik' }}</h3>
                <ul>
                    @foreach ($publicChannelLinks as $link)
                        <li><a href="{{ $link['href'] }}">{{ $link[$currentLocale ?? 'id'] ?? $link['id'] }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h3>{{ $ui['contact'] ?? 'Kontak' }}</h3>
                <p>Jl. Patih Singoranu No. 155, Tamanan, Banguntapan, Bantul, DI Yogyakarta.</p>
                <p>sekretariat@simpulpfb.id</p>
                <button class="cea-donation-link mt-2" type="button" data-donation-open>{{ $ui['donate_qris'] ?? 'Donasi via QRIS' }}</button>
            </div>
        </div>
        <div class="cea-footer-bottom"><span>2026 SIMPULPFB</span></div>
    </div>
</footer>

<div class="cea-donation-modal" data-donation-modal aria-hidden="true">
    <div class="cea-donation-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="donation-modal-title">
        <button class="cea-donation-modal__close" type="button" data-donation-close aria-label="{{ $ui['close_donation'] ?? 'Tutup modal donasi' }}">&times;</button>
        <h2 id="donation-modal-title">{{ $donationTitle ?: ($ui['donation_title'] ?? 'Donasi Pooling Fund - KSO') }}</h2>
        <p>{{ $donationBody ?: ($ui['donation_body'] ?? 'Dukungan Anda membantu memperkuat respon kemanusiaan berbasis komunitas dan kepemimpinan lokal.') }}</p>
        @if ($donationRecipient)
            <div class="cea-donation-modal__recipient">
                <span>{{ $ui['donation_recipient'] ?? 'Penerima donasi' }}</span>
                <strong>{{ $donationRecipient }}</strong>
            </div>
        @endif
        @if ($qrisImageSrc)
            <div class="cea-qris-image-wrap">
                <img class="cea-qris-image" src="{{ $qrisImageSrc }}" alt="{{ $qrisImageAlt }}">
            </div>
        @else
            <div class="cea-qris-placeholder">{!! $ui['qris_placeholder'] ?? 'QRIS Donasi<br>segera tersedia' !!}</div>
        @endif
        <div class="cea-donation-modal__note">{{ $donationNote ?: ($ui['donation_note'] ?? 'Tempatkan gambar QRIS resmi di area ini saat sudah tersedia. Pastikan nama penerima dan nominal dicek sebelum transaksi.') }}</div>
    </div>
</div>
