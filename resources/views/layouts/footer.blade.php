<footer class="cea-landing-footer">
    <div class="container">
        <div class="cea-footer-grid">
            <div class="cea-footer-brand">
                <img src="{{ asset('assets/img/cea/1.png') }}" alt="{{ config('app.name') }}">
                <p>Platform mandat kolektif antar CSO untuk menghimpun dan menyalurkan dana kemanusiaan berbasis kebutuhan komunitas dan kepemimpinan lokal.</p>
                <div class="cea-footer-actions mt-3">
                    <a href="https://ceaindonesia.id/" target="_blank" rel="noreferrer">Situs Resmi</a>
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
                    <li><a href="/profil/struktur-gerak">Struktur Gerak</a></li>
                    <li><a href="/profil/sumber-daya">Tata Kelola</a></li>
                    <li><a href="/siar/kabar">Siar Kabar</a></li>
                    <li><a href="/koneksi">Koneksi</a></li>
                </ul>
            </div>
            <div>
                <h3>Kontak</h3>
                <p>Jl. Patih Singoranu No. 155, Tamanan, Banguntapan, Bantul, DI Yogyakarta.</p>
                <p>sekretariat@ceaindonesia.id</p>
            </div>
        </div>
        <div class="cea-footer-bottom"><span>2026 {{ config('app.name') }}</span></div>
    </div>
</footer>
