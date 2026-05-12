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
            <h2>Form Konten Database</h2>
            <?php if(! $dbReady): ?>
                <div class="alert alert-warning">Tabel <strong>admin_contents</strong> belum tersedia. Import <code>database/sql/admin_contents.sql</code> di phpMyAdmin.</div>
            <?php endif; ?>
            <?php if(session('status')): ?>
                <div class="alert alert-success"><?php echo e(session('status')); ?></div>
            <?php endif; ?>
            <?php $__errorArgs = ['database'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="alert alert-danger"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <form method="POST" action="<?php echo e(route('admin.item.update', [$section['key'], $item['key']])); ?>">
                <?php echo csrf_field(); ?>
                <div class="admin-field">
                    <label>Judul halaman</label>
                    <input name="title" value="<?php echo e(old('title', $content['title'])); ?>" required>
                    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="admin-field">
                    <label>Subtitle / Ringkasan</label>
                    <input name="subtitle" value="<?php echo e(old('subtitle', $content['subtitle'])); ?>">
                </div>
                <div class="admin-field">
                    <label>Isi tulisan</label>
                    <textarea name="body"><?php echo e(old('body', $content['body'])); ?></textarea>
                </div>
                <div class="admin-field">
                    <label>URL / path gambar</label>
                    <input name="image_path" value="<?php echo e(old('image_path', $content['image_path'])); ?>" placeholder="/assets/img/cea/campur.png atau https://...">
                    <?php if(! empty($content['image_path'])): ?>
                        <img src="<?php echo e($content['image_path']); ?>" alt="<?php echo e($content['title']); ?>" style="border-radius:8px;margin-top:12px;max-height:180px;object-fit:cover;width:100%;">
                    <?php endif; ?>
                </div>
                <div class="admin-field">
                    <label>URL sumber</label>
                    <input name="source_href" value="<?php echo e(old('source_href', $content['source_href'])); ?>">
                </div>
                <div class="admin-field">
                    <label>Status publikasi</label>
                    <select name="status">
                        <option value="draft" <?php if(old('status', $content['status']) === 'draft'): echo 'selected'; endif; ?>>Draft</option>
                        <option value="active" <?php if(old('status', $content['status']) === 'active'): echo 'selected'; endif; ?>>Aktif</option>
                        <option value="archived" <?php if(old('status', $content['status']) === 'archived'): echo 'selected'; endif; ?>>Arsip</option>
                    </select>
                </div>
                <div class="admin-form-actions">
                    <button class="admin-button" type="submit">Simpan ke database</button>
                    <a class="admin-button secondary" href="<?php echo e($content['source_href'] ?: $item['sourceHref']); ?>" target="_blank" rel="noreferrer">Lihat sumber</a>
                </div>
            </form>
        </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/labfti/Documents/ceaindonesia.id/resources/views/admin/item.blade.php ENDPATH**/ ?>