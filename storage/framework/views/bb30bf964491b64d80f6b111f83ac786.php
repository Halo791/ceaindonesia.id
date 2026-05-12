<?php $__env->startSection('title', 'Admin '.$item['label']); ?>

<?php $__env->startSection('content'); ?>
<section class="cea-admin-panel">
    <div class="admin-shell">
        <?php echo $__env->make('admin.partials.sidebar', ['activeSection' => $section['key'], 'activeItem' => $item['key']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <div class="admin-workspace">
        <div class="admin-hero">
            <div>
                <span class="admin-eyebrow"><?php echo e($section['label']); ?></span>
                <h1>Kelola <?php echo e($item['label']); ?></h1>
                <p><?php echo e($item['description']); ?></p>
            </div>
            <a class="admin-source-link" href="<?php echo e($item['sourceHref']); ?>" target="_blank" rel="noreferrer">Sumber resmi</a>
        </div>

        <div class="admin-form-card admin-section-spacer">
            <h2>Form Konten</h2>
            <div class="admin-field">
                <label>Judul halaman</label>
                <input value="<?php echo e($item['label']); ?>">
            </div>
            <div class="admin-field">
                <label>Slug</label>
                <input value="<?php echo e($item['key']); ?>">
            </div>
            <div class="admin-field">
                <label>Deskripsi</label>
                <textarea><?php echo e($item['description']); ?></textarea>
            </div>
            <div class="admin-form-actions">
                <button class="admin-button" type="button">Simpan draft</button>
                <a class="admin-button secondary" href="<?php echo e($item['sourceHref']); ?>" target="_blank" rel="noreferrer">Lihat sumber</a>
            </div>
        </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/labfti/Documents/ceaindonesia.id/resources/views/admin/item.blade.php ENDPATH**/ ?>