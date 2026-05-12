<footer class="cea-landing-footer">
    <div class="container">
        <div class="cea-footer-grid">
            <div class="cea-footer-brand">
                <img src="{{ asset('assets/img/cea/1.png') }}" alt="{{ config('app.name') }}">
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
            </div>
        </div>
        <div class="cea-footer-bottom"><span>2026 {{ config('app.name') }}</span></div>
    </div>
</footer>
