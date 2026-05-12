<?php
    $activeSection = $activeSection ?? null;
    $activeItem = $activeItem ?? null;
    $childCount = collect($navigation)->filter(fn ($section) => ! empty($section['children']))->flatMap(fn ($section) => $section['children'])->count();
?>

<aside class="admin-sidebar">
    <div class="admin-sidebar__brand">
        <span>CEA CMS</span>
        <strong><?php echo e($childCount); ?> kanal dropdown</strong>
    </div>
    <nav class="admin-sidebar__nav" aria-label="Navigasi panel admin">
        <a href="<?php echo e(route('admin.index')); ?>" class="<?php echo e(! $activeSection ? 'active' : ''); ?>">Dashboard</a>
        <?php $__currentLoopData = $navigation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="admin-sidebar__group">
                <a href="<?php echo e(route('admin.section', $section['key'])); ?>" class="<?php echo e($activeSection === $section['key'] && ! $activeItem ? 'active' : ''); ?>">
                    <?php echo e($section['label']); ?>

                </a>
                <?php if(! empty($section['children'])): ?>
                    <div class="admin-sidebar__children">
                        <?php $__currentLoopData = $section['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('admin.item', [$section['key'], $item['key']])); ?>" class="<?php echo e($activeSection === $section['key'] && $activeItem === $item['key'] ? 'active' : ''); ?>">
                                <?php echo e($item['label']); ?>

                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </nav>
</aside>
<?php /**PATH /home/labfti/Documents/ceaindonesia.id/resources/views/admin/partials/sidebar.blade.php ENDPATH**/ ?>