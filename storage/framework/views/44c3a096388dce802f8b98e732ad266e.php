<?php $__env->startSection('title', 'Panel Admin CEA'); ?>

<?php $__env->startSection('content'); ?>
<section class="cea-admin-panel">
    <div class="admin-shell">
        <?php echo $__env->make('admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <div class="admin-workspace">
        <div class="admin-hero">
            <div>
                <span class="admin-eyebrow">Panel Admin CEA</span>
                <h1>Dashboard Konten CEA</h1>
                <p>Panel ini mengadopsi struktur menu dan dropdown dari ceaindonesia.id, lalu menyiapkan ruang kelola untuk setiap kanal.</p>
            </div>
            <a class="admin-source-link" href="https://ceaindonesia.id/" target="_blank" rel="noreferrer">Sumber resmi</a>
        </div>

        <div class="admin-stat-strip">
            <div class="admin-stat"><span>Menu utama</span><strong><?php echo e(count($navigation)); ?></strong></div>
            <div class="admin-stat"><span>Dropdown</span><strong><?php echo e($dropdownSections->count()); ?></strong></div>
            <div class="admin-stat"><span>Kanal admin</span><strong><?php echo e($childItems->count()); ?></strong></div>
            <div class="admin-stat"><span>Status</span><strong>Draft</strong></div>
        </div>

        <div class="admin-grid">
            <?php $__currentLoopData = $dropdownSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="admin-card">
                    <span class="admin-card__label"><?php echo e(count($section['children'])); ?> dropdown</span>
                    <h2><?php echo e($section['label']); ?></h2>
                    <p><?php echo e($section['description']); ?></p>
                    <div class="admin-card__actions">
                        <a class="admin-button" href="<?php echo e(route('admin.section', $section['key'])); ?>">Kelola <?php echo e($section['label']); ?></a>
                        <a class="admin-button secondary" href="<?php echo e($section['sourceHref']); ?>" target="_blank" rel="noreferrer">Lihat sumber</a>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="admin-table-card admin-section-spacer">
            <h2>Semua Halaman Dropdown</h2>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead><tr><th>Section</th><th>Halaman</th><th>Deskripsi</th><th>Status</th><th>Aksi</th></tr></thead>
                    <tbody>
                        <?php $__currentLoopData = $childItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($item['section_label']); ?></td>
                                <td><strong><?php echo e($item['label']); ?></strong></td>
                                <td><?php echo e($item['description']); ?></td>
                                <td><span class="admin-status">Siap diedit</span></td>
                                <td><a href="<?php echo e(route('admin.item', [$item['section_key'], $item['key']])); ?>">Kelola</a></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/labfti/Documents/ceaindonesia.id/resources/views/admin/index.blade.php ENDPATH**/ ?>