<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->

    <div class="user-info" style="<?php echo e(\Modules\Platform\Core\Helper\SettingsHelper::siebarBackground()); ?>">
        <div class="image">
           <?php echo \Modules\Platform\Core\Helper\UserHelper::profileImage(); ?>

        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo e(Auth::user()->name); ?>

            </div>
            <div class="email">
                <?php echo e(Auth::user()->email); ?>

            </div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                <ul class="dropdown-menu pull-right">
                    <li><a href="<?php echo e(route('account.index')); ?>"><i class="material-icons">person</i><?php echo app('translator')->getFromJson('core::core.menu.account'); ?></a></li>
                    <li role="seperator" class="divider"></li>
                    <li><a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="material-icons">input</i><?php echo app('translator')->getFromJson('core::core.menu.sign_out'); ?></a></li>
                </ul>

                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="post" style="display: none">
                    <?php echo e(csrf_field()); ?>

                </form>
            </div>
        </div>
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">

        <a href="javascript:void(0);" class="bars"></a>
        <?php echo $mainMenu->render(); ?>


    </div>
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal">
        <i title="<?php echo app('translator')->getFromJson('core::core.minify_sidebar'); ?>" id="minify-sidebar" class="material-icons">keyboard_arrow_left</i>
        <div class="version">
            <b><?php echo app('translator')->getFromJson('bap.version'); ?>: <?php echo e(config('bap.version')); ?></b>
        </div>
    </div>
    <!-- #Footer -->
</aside>
<!-- #END# Left Sidebar -->