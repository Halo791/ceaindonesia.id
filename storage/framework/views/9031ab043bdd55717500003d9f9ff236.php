<footer class="cea-landing-footer">
    <div class="container">
        <div class="cea-footer-grid">
            <div class="cea-footer-brand">
                <img src="<?php echo e(asset('assets/img/cea/1.png')); ?>" alt="CEA Indonesia">
                <p>Aliansi keterlibatan sipil untuk merawat demokrasi, memperkuat ruang sipil, dan menghubungkan kerja kolektif lintas wilayah.</p>
                <div class="cea-footer-actions mt-3">
                    <a href="<?php echo e(route('admin.index')); ?>">Panel Admin</a>
                    <a href="https://ceaindonesia.id/" target="_blank" rel="noreferrer">Situs Resmi</a>
                </div>
            </div>
            <div>
                <h3>Menu</h3>
                <ul>
                    <?php $__currentLoopData = $navigation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><a href="<?php echo e($item['publicHref'] ?? $item['href']); ?>"><?php echo e($item['label']); ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <div>
                <h3>Kanal Admin</h3>
                <ul>
                    <li><a href="/admin/profil/struktur-gerak">Struktur Gerak</a></li>
                    <li><a href="/admin/profil/sumber-daya">Tata Kelola</a></li>
                    <li><a href="/admin/siar/kabar">Siar Kabar</a></li>
                    <li><a href="/admin/koneksi">Koneksi</a></li>
                </ul>
            </div>
            <div>
                <h3>Kontak</h3>
                <p>Jl. Patih Singoranu No. 155, Tamanan, Banguntapan, Bantul, DI Yogyakarta.</p>
                <p>sekretariat@ceaindonesia.id</p>
            </div>
        </div>
        <div class="cea-footer-bottom"><span>2026 CEA Indonesia</span></div>
    </div>
</footer>
<?php /**PATH /home/labfti/Documents/ceaindonesia.id/resources/views/layouts/footer.blade.php ENDPATH**/ ?>