<footer class="cea-landing-footer">
    <div class="container">
        <div class="cea-footer-grid">
            <div class="cea-footer-brand">
                @include('layouts.kso-wordmark', ['variant' => 'footer', 'compact' => true])
                <p>Platform mandat kolektif antar CSO untuk menghimpun dan menyalurkan dana kemanusiaan berbasis kebutuhan komunitas dan kepemimpinan lokal.</p>
                <div class="cea-footer-actions mt-3">
                    <a href="/profil/mandat-visi-nilai">Baca Mandat</a>
                    <a href="/regio/simpul">Lihat Simpul</a>
                </div>
            </div>
            <div>
                <h3>Menu</h3>
                <ul>
                    @foreach ($navigation as $item)
                        <li><a href="{{ $item['publicHref'] ?? $item['href'] }}">{{ $item['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h3>Kanal Publik</h3>
                <ul>
                    <li><a href="/profil/mandat-visi-nilai">Mandat, Visi, Misi</a></li>
                    <li><a href="/profil/tujuan-prinsip">Tujuan & Prinsip</a></li>
                    <li><a href="/profil/struktur-gerak">Arsitektur Mandat</a></li>
                    <li><a href="/profil/sumber-daya">Tata Kelola Sumber Daya</a></li>
                    <li><a href="/regio/simpul">Sebaran Simpul</a></li>
                </ul>
            </div>
            <div>
                <h3>Kontak</h3>
                <p>Jl. Patih Singoranu No. 155, Tamanan, Banguntapan, Bantul, DI Yogyakarta.</p>
                <p>sekretariat@simpulpfb.id</p>
                <button class="cea-donation-link mt-2" type="button" data-donation-open>Donasi via QRIS</button>
            </div>
        </div>
        <div class="cea-footer-bottom"><span>2026 SIMPULPFB</span></div>
    </div>
</footer>

<div class="cea-donation-modal" data-donation-modal aria-hidden="true">
    <div class="cea-donation-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="donation-modal-title">
        <button class="cea-donation-modal__close" type="button" data-donation-close aria-label="Tutup modal donasi">&times;</button>
        <h2 id="donation-modal-title">Donasi Pooling Fund - KSO</h2>
        <p>Dukungan Anda membantu memperkuat respon kemanusiaan berbasis komunitas dan kepemimpinan lokal.</p>
        <div class="cea-qris-placeholder">QRIS Donasi<br>segera tersedia</div>
        <div class="cea-donation-modal__note">Tempatkan gambar QRIS resmi di area ini saat sudah tersedia. Pastikan nama penerima dan nominal dicek sebelum transaksi.</div>
    </div>
</div>
