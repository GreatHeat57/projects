<?php if(\Auth::user()->unreadNotifications()->orderBy('id','desc')->take(10)->count() > 0 ): ?>
    <?php $__currentLoopData = \Auth::user()->unreadNotifications()->orderBy('id','desc')->take(10)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(isset($notification->data['content'])): ?>
            <li>
                <a href="<?php echo e($notification->data['url'] != '' ? $notification->data['url'] : '#'); ?>" class=" waves-effect waves-block">
                    <div class="icon-circle <?php echo e($notification->data['color']); ?>">
                        <i class="material-icons"><?php echo e($notification->data['icon']); ?></i>
                    </div>
                    <div class="menu-info filled">
                        <h4><?php echo e($notification->data['content']); ?></h4>
                        <p>
                            <i class="material-icons">access_time</i> <?php echo e(\Modules\Platform\Core\Helper\UserHelper::formatUserDateTime($notification->created_at)); ?>

                        </p>
                    </div>
                </a>
            </li>
        <?php endif; ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
    <li>
        <a href="#" class=" waves-effect waves-block text-center">

            <div class="menu-info">
                <h4><?php echo app('translator')->getFromJson('notifications::notifications.no_new_notifications'); ?></h4>
                <p>&nbsp;</p>
                <p class="text-center col-blue-grey">
                    <i class="material-icons medium-icon">notifications_none</i>
                </p>
            </div>
        </a>
    </li>
<?php endif; ?>