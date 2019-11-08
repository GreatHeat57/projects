<?php
?>

<!-- Top Bar -->
<nav class="navbar">

    <div class="container-fluid">
        <div class="navbar-header">


            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse"
               data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="<?php echo e(url('/')); ?>">

                <?php if(\Modules\Platform\Core\Helper\CompanySettings::get(\Modules\Platform\Core\Helper\SettingsHelper::S_DISPLAY_SHOW_LOGO_IN_APPLICATION)): ?>
                    <?php echo \Modules\Platform\Core\Helper\SettingsHelper::displayLogo(); ?>

                <?php else: ?>
                    <span class="brand-name">
                        <?php echo e(\Modules\Platform\Core\Helper\CompanySettings::get(\Modules\Platform\Core\Helper\SettingsHelper::S_DISPLAY_APPLICATION_NAME, config('app.name'))); ?>

                    </span>
                <?php endif; ?>
            </a>

        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">


            <ul class="nav navbar-nav navbar-right">
            <?php if(config('bap.global_search')): ?>
                <!-- Call Search -->
                    <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a>
                    </li>
                <?php endif; ?>


                <?php if(Auth::user()->hasPermissionTo('company.settings')): ?>
                    <li>
                        <a title="<?php echo e(trans('subscription::subscription.billing')); ?> " href="<?php echo e(route('subscription.board')); ?>">
                            <i class="material-icons">credit_card</i>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if(\Auth::user()->hasPermissionTo('settings.access')): ?>
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="true">
                            <i class="material-icons">device_hub</i>
                        </a>
                        <ul class=" dropdown-menu list-dropdown">
                            <li class="header bg-deep-orange"><?php echo app('translator')->getFromJson('companies::companies.company_context'); ?></li>

                            <?php

                            $contexCompany = Landlord::getTenantId('company_id');
                            ?>
                            <li class="body">
                                <ul class="menu">
                                    <li>
                                        <?php $__currentLoopData = $tenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tenant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a href="<?php echo e(route('settings.companies.switch-context',$tenant->id)); ?>"
                                               class=" waves-effect waves-block">
                                                <div class="menu-info">
                                                    <h4><?php echo e($tenant->name); ?>

                                                        <?php if($contexCompany != null && $contexCompany == $tenant->id): ?>
                                                            <div class="label label-default bg-green"><?php echo app('translator')->getFromJson('companies::companies.current_company'); ?></div>
                                                        <?php endif; ?>
                                                    </h4>
                                                    <small><?php echo e($tenant->description); ?></small>
                                                </div>
                                            </a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <li class="dropdown">
                    <a id="top-bar-notifications" href="javascript:void(0);" class="dropdown-toggle"
                       data-toggle="dropdown" role="button" aria-expanded="true">
                        <i class="material-icons">notifications</i>
                        <span id="top_bar_notifications_count"
                              class="label-count bg-red"> <?php echo e(Auth::user()->unreadNotifications()->count()); ?></span>
                    </a>
                    <ul id="notifications_dropdown" class="dropdown-menu">
                        <li class="header bg-red"><?php echo app('translator')->getFromJson('core::core.notifications'); ?></li>
                        <li class="body">
                            <ul id="top-bar-notifications-menu" class="menu">

                                <?php echo $__env->make('notifications::top-bar', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                            </ul>
                        </li>
                        <li class="footer">
                            <a href="<?php echo e(route('notifications.index')); ?>"
                               class=" waves-effect waves-block"><?php echo app('translator')->getFromJson('notifications::notifications.view_all_notifications'); ?></a>
                        </li>
                    </ul>
                </li>


                <!-- #END# Tasks -->
                <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i
                                class="material-icons">more_vert</i></a></li>
            </ul>
        </div>
    </div>
</nav>
<!-- #Top Bar -->
