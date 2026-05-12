<?php $__env->startSection('title', 'CEA Indonesia'); ?>

<?php
    $images = [
        'header' => asset('assets/img/cea/campur.png'),
        'collective' => asset('assets/img/cea/campur.png'),
        'governance' => asset('assets/img/cea/tatakelola.png'),
        'structure' => asset('assets/img/cea/struktur_gerak.png'),
        'forum' => asset('assets/img/cea/pomelli_bdna_image_0510%20%285%29.png'),
        'action' => asset('assets/img/cea/pomelli_bdna_image_0510%20%286%29.png'),
        'study' => asset('assets/img/cea/pomelli_bdna_image_0510%20%287%29.png'),
    ];
    $focusAreas = [
        ['title' => 'Ruang Sipil', 'description' => 'Mengawal ruang aman bagi organisasi masyarakat sipil, komunitas, dan warga.', 'image' => $images['action']],
        ['title' => 'Gerakan Kolektif', 'description' => 'Menghubungkan simpul, gagasan, dan aksi lintas wilayah agar gerakan tetap relevan.', 'image' => $images['collective']],
        ['title' => 'Diskursus Publik', 'description' => 'Membuka ruang belajar, refleksi, dan pertukaran strategi antaraktor masyarakat sipil.', 'image' => $images['forum']],
    ];
    $governanceItems = [
        ['label' => 'Struktur Gerak', 'title' => 'Simpul, gugus tugas, dan kaukus isu yang saling terhubung.', 'description' => 'Struktur CEA bergerak sebagai jejaring regional dan nasional yang bekerja otonom namun tetap terikat tujuan bersama.', 'image' => $images['structure'], 'href' => '/admin/profil/struktur-gerak'],
        ['label' => 'Tata Kelola', 'title' => 'Mobilisasi sumber daya dikelola lewat simpul dan platform penyaluran dana.', 'description' => 'Bagian tata kelola pada landing page memakai gambar tatakelola.png sesuai aset yang tersedia di direktori CEA.', 'image' => $images['governance'], 'href' => '/admin/profil/sumber-daya'],
    ];
    $stats = [
        ['value' => '78', 'label' => 'Organisasi masyarakat sipil'],
        ['value' => '19', 'label' => 'Provinsi jejaring'],
        ['value' => '6', 'label' => 'Simpul regional'],
    ];
    $sectionImage = [
        'profil' => $images['structure'],
        'regio' => $images['collective'],
        'siar' => $images['forum'],
        'aksi' => $images['study'],
        'koneksi' => $images['governance'],
    ];
    $dropdownSections = collect($navigation)->filter(fn ($item) => ! empty($item['children']))->values();
?>

<?php $__env->startPush('styles'); ?>
<style>
    .cea-landing-hero { background: radial-gradient(circle at 80% 10%, rgba(232,93,74,.34), transparent 32%), linear-gradient(135deg, #2a0710 0%, #5b0f1a 54%, #7a1626 100%); color: #fff; overflow: hidden; padding: 78px 0 86px; }
    .cea-landing-hero__grid { align-items: center; display: grid; gap: 48px; grid-template-columns: minmax(0, .82fr) minmax(420px, 1fr); }
    .cea-landing-hero__eyebrow, .cea-section__head span, .cea-governance-card__body span { color: #f2b66d; display: block; font-size: 13px; font-weight: 900; margin-bottom: 18px; text-transform: uppercase; }
    .cea-landing-hero h1 { color: #fff; font-family: var(--tg-heading-font-family); font-size: clamp(52px, 6.8vw, 96px); font-weight: 900; letter-spacing: 0; line-height: .94; margin-bottom: 22px; max-width: 860px; text-transform: none; text-wrap: balance; }
    .cea-landing-hero p { color: rgba(255,255,255,.82); font-size: 18px; line-height: 1.75; margin-bottom: 30px; max-width: 640px; }
    .cea-landing-hero__actions { display: flex; flex-wrap: wrap; gap: 12px; }
    .cea-landing-hero__visual { align-items: center; background: #fff8f5; border-radius: 8px; box-shadow: 0 34px 80px rgba(42,7,16,.36); display: flex; min-height: 330px; overflow: hidden; padding: 28px; }
    .cea-landing-hero__visual img, .cea-focus-card__image img, .cea-governance-card__media img, .cea-menu-card__image img { display: block; height: auto; width: 100%; }
    .cea-section { background: #fff; padding: 76px 0; }
    .cea-section--soft { background: #fff4f2; }
    .cea-section__head { margin-bottom: 32px; max-width: 820px; }
    .cea-section__head span { color: #b91c31; margin-bottom: 9px; }
    .cea-section__head h2 { color: #3a0710; font-size: clamp(28px, 3.4vw, 46px); line-height: 1.12; margin: 0; }
    .cea-focus-grid, .cea-menu-grid { display: grid; gap: 22px; grid-template-columns: repeat(3, minmax(0, 1fr)); }
    .cea-focus-card, .cea-governance-card, .cea-menu-card { background: #fff; border: 1px solid #efd0d0; border-radius: 8px; box-shadow: 0 18px 44px rgba(75,11,23,.08); overflow: hidden; }
    .cea-focus-card__image, .cea-menu-card__image { aspect-ratio: 16 / 10; background: #fff4f2; overflow: hidden; }
    .cea-focus-card__image img, .cea-menu-card__image img { height: 100%; object-fit: cover; }
    .cea-focus-card__body, .cea-menu-card__body, .cea-governance-card__body { padding: 24px; }
    .cea-focus-card h3, .cea-governance-card h3, .cea-menu-card h3 { color: #3a0710; font-size: 24px; font-weight: 900; line-height: 1.15; margin-bottom: 12px; }
    .cea-focus-card p, .cea-governance-card p, .cea-menu-card p { color: #67464b; font-size: 15px; line-height: 1.75; margin: 0; }
    .cea-stats { background: #4b0b17; padding: 40px 0; }
    .cea-stats__grid { display: grid; gap: 18px; grid-template-columns: repeat(3, minmax(0, 1fr)); }
    .cea-stat { border: 1px solid rgba(255,255,255,.16); border-radius: 8px; color: #fff; padding: 22px; }
    .cea-stat strong { color: #f2b66d; display: block; font-size: 48px; font-weight: 900; line-height: 1; margin-bottom: 8px; }
    .cea-stat span { color: rgba(255,255,255,.78); font-size: 14px; font-weight: 800; }
    .cea-governance-grid { display: grid; gap: 24px; grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .cea-governance-card__media { background: #fff; padding: 18px; }
    .cea-governance-card__body span { color: #b91c31; margin-bottom: 10px; }
    .cea-governance-card__body a, .cea-menu-card__body a { color: #b91c31; font-weight: 900; }
    .cea-menu-card__body ul { display: grid; gap: 8px; list-style: none; margin: 18px 0 0; padding: 0; }
    @media (max-width: 991px) {
        .cea-landing-hero__grid, .cea-governance-grid { grid-template-columns: 1fr; }
        .cea-focus-grid, .cea-menu-grid, .cea-stats__grid { grid-template-columns: 1fr; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="cea-landing-hero">
    <div class="container">
        <div class="cea-landing-hero__grid">
            <div class="cea-landing-hero__content">
                <span class="cea-landing-hero__eyebrow">Civic Engagement Alliance</span>
                <h1 class="cea-scramble-title">Merawat ruang sipil, memperkuat gerakan akar rumput.</h1>
                <p>CEA Indonesia adalah aliansi organisasi masyarakat sipil yang bekerja bersama untuk demokrasi, ruang sipil, keadilan sosial, dan kelestarian alam.</p>
                <div class="cea-landing-hero__actions">
                    <a class="cea-btn" href="<?php echo e(route('admin.index')); ?>">Buka Panel Admin</a>
                    <a class="cea-btn secondary" href="https://ceaindonesia.id/" target="_blank" rel="noreferrer">Lihat Situs Resmi</a>
                </div>
            </div>
            <div class="cea-landing-hero__visual" aria-label="Gambar header CEA Indonesia">
                <img src="<?php echo e($images['header']); ?>" alt="CEA Indonesia">
            </div>
        </div>
    </div>
</section>

<section class="cea-section">
    <div class="container">
        <div class="cea-section__head">
            <span>Fokus Gerakan</span>
            <h2>Aliansi yang menghubungkan simpul, gagasan, dan aksi.</h2>
        </div>
        <div class="cea-focus-grid">
            <?php $__currentLoopData = $focusAreas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="cea-focus-card">
                    <div class="cea-focus-card__image"><img src="<?php echo e($item['image']); ?>" alt="<?php echo e($item['title']); ?>"></div>
                    <div class="cea-focus-card__body">
                        <h3><?php echo e($item['title']); ?></h3>
                        <p><?php echo e($item['description']); ?></p>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<section class="cea-stats">
    <div class="container">
        <div class="cea-stats__grid">
            <?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="cea-stat"><strong><?php echo e($item['value']); ?></strong><span><?php echo e($item['label']); ?></span></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<section class="cea-section cea-section--soft">
    <div class="container">
        <div class="cea-section__head">
            <span>Struktur & Tata Kelola</span>
            <h2>Gerak kolektif ditopang oleh struktur dan tata kelola sumber daya.</h2>
        </div>
        <div class="cea-governance-grid">
            <?php $__currentLoopData = $governanceItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="cea-governance-card">
                    <div class="cea-governance-card__media"><img src="<?php echo e($item['image']); ?>" alt="<?php echo e($item['label']); ?>"></div>
                    <div class="cea-governance-card__body">
                        <span><?php echo e($item['label']); ?></span>
                        <h3><?php echo e($item['title']); ?></h3>
                        <p><?php echo e($item['description']); ?></p>
                        <a href="<?php echo e($item['href']); ?>">Kelola di admin</a>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<section class="cea-section">
    <div class="container">
        <div class="cea-section__head">
            <span>Menu & Dropdown</span>
            <h2>CEA Repositori</h2>
        </div>
        <div class="cea-menu-grid">
            <?php $__currentLoopData = $dropdownSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="cea-menu-card">
                    <div class="cea-menu-card__image">
                        <img src="<?php echo e($sectionImage[$section['key']] ?? $images['collective']); ?>" alt="<?php echo e($section['label']); ?>">
                    </div>
                    <div class="cea-menu-card__body">
                        <h3><?php echo e($section['label']); ?></h3>
                        <p><?php echo e($section['description']); ?></p>
                        <ul>
                            <?php $__currentLoopData = array_slice($section['children'], 0, 5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a href="<?php echo e($item['publicHref'] ?? $item['href']); ?>"><?php echo e($item['label']); ?></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/labfti/Documents/ceaindonesia.id/resources/views/home.blade.php ENDPATH**/ ?>