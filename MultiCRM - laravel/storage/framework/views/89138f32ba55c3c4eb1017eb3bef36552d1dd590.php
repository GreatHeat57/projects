<div class="<?php echo e($config['coll_class']); ?>">
    <div class="info-box-3 <?php echo e($config['bg_color']); ?> hover-expand-effect">
        <div class="icon">
            <i class="material-icons"><?php echo e($config['icon']); ?></i>
        </div>
        <div class="content">
            <div class="text"><?php echo e($config['title']); ?></div>
            <div class="number <?php echo e(!config('bap.disableCountTo') ? 'count-to': ''); ?>" data-from="0" data-to="<?php echo e($config['counter']); ?>" data-speed="2000" data-fresh-interval="20"><?php echo e($config['counter']); ?></div>
        </div>
    </div>
</div>
