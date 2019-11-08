<!-- Right Sidebar -->
<aside id="rightsidebar" class="right-sidebar">
    <ul class="nav nav-tabs tab-nav-right" role="tablist">
        <li role="presentation" class="active"><a href="#settings"
                                                  data-toggle="tab"><?php echo app('translator')->getFromJson('core::core.right_menu.settings'); ?></a></li>
        <li role="presentation"><a href="#skins" data-toggle="tab"><?php echo app('translator')->getFromJson('core::core.right_menu.skins'); ?></a></li>

    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade " id="skins">


            <ul class="demo-choose-skin">

                <?php $__currentLoopData = \Modules\Platform\Core\Helper\ThemeHelper::SUPPORTED_THEMES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li data-theme="<?php echo e($key); ?>" class="<?php echo e(\Modules\Platform\Core\Helper\ThemeHelper::isActive($key)); ?>">
                        <div class="<?php echo e(strtolower($name)); ?>"></div>
                        <span><?php echo e(trans('core::core.right_menu.theme.'.$name)); ?></span>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </ul>
        </div>
        <div role="tabpanel" class="tab-pane fade in active" id="settings">
            <div class="right-menu-settings">

                <ul class="setting-list">
                    <?php if(Session::has('original_user')): ?>
                        <li>
                            <a href="<?php echo e(route('account.ghost-logout')); ?>">
                                <i class="material-icons">people_outline</i>
                                <span><?php echo app('translator')->getFromJson('core::core.right_menu.ghost_sign_out'); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li>
                        <a href="<?php echo e(route('account.index')); ?>">
                            <i class="material-icons">person</i>
                            <span><?php echo app('translator')->getFromJson('core::core.menu.account'); ?></span>
                        </a>
                    </li>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('company.settings')): ?>
                        <li>
                            <a href="<?php echo e(url('/settings')); ?>">
                                <i class="material-icons">settings</i>
                                <span><?php echo app('translator')->getFromJson('core::core.menu.settings'); ?></span>
                            </a>
                        </li>
                    <?php endif; ?>


                    <li>
                        <a href="<?php echo e(route('notifications.index')); ?>">
                            <i class="material-icons">notifications</i>
                            <span><?php echo app('translator')->getFromJson('core::core.menu.notifications'); ?></span>
                        </a>
                    </li>


                    <li>
                        <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="material-icons">input</i>
                            <span><?php echo app('translator')->getFromJson('core::core.menu.sign_out'); ?></span>
                        </a>
                    </li>
                </ul>

            </div>
        </div>
    </div>
</aside>
<!-- #END# Right Sidebar -->