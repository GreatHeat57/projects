<?php $__env->startSection('content'); ?>

    <div class="row">

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('leads.browse')): ?>
            <?php echo app('arrilot.widget')->run('Modules\Dashboard\Widgets\CountWidget',['title' =>
            trans('dashboard::dashboard.widgets.leads'),'bg_color'=>'bg-pink','icon'=>'search','counter' =>
            $countLeads]); ?>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('contacts.browse')): ?>
            <?php echo app('arrilot.widget')->run('Modules\Dashboard\Widgets\CountWidget',['title' =>
            trans('dashboard::dashboard.widgets.contacts'),'bg_color'=>'bg-cyan','icon'=>'contacts','counter' =>
            $countContacts]); ?>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('orders.browse')): ?>
            <?php echo app('arrilot.widget')->run('Modules\Dashboard\Widgets\CountWidget',['title' =>
            trans('dashboard::dashboard.widgets.orders'),'bg_color'=>'bg-orange','icon'=>'pageview','counter' =>
            $countOrders]); ?>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('invoices.browse')): ?>
            <?php echo app('arrilot.widget')->run('Modules\Dashboard\Widgets\CountWidget',['title' =>
            trans('dashboard::dashboard.widgets.invoices'),'bg_color'=>'bg-green','icon'=>'shopping_cart','counter' =>
            $countInvoices]); ?>
        <?php endif; ?>
    </div>

    <div class="row dashboard-row">

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('leads.browse')): ?>
        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
            <div class="card collapsible">
                <div id="dashboard_leads" class="header card-inside-title">

                    <span class="badge bg-pink pull-right"><?php echo app('translator')->getFromJson('core::core.this_month'); ?></span>
                    <h2 class="pointer">

                        <?php echo app('translator')->getFromJson('dashboard::dashboard.widgets.leads_chart'); ?>

                        <span class="expander">
                            <i class="fa fa-angle-up pointer" aria-hidden="true"></i>
                        </span>
                    </h2>

                </div>
                <div class="body panel-content">
                    <div id="leads_chart" class="dashboard-leads_chart" style="height: 230px">
                        <?php echo $leadOverview->container(); ?>

                    </div>


                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('payments.browse')): ?>
        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
            <div class="card collapsible">
                <div id="dashboard_income_vs_payments" class="header card-inside-title">


                    <div class="dropdown pull-right m-r-5">
                        <button  class="btn btn-xs bg-pink btn-flat dropdown-toggle" type="button" data-toggle="dropdown"><?php echo e(strtoupper($currentCurrency)); ?> <?php echo app('translator')->getFromJson('core::core.last_three_months'); ?><span class="caret"></span></button>
                        <ul class="dropdown-menu scrollable">

                            <?php $__currentLoopData = $paymentCurrency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a href="?ivseCurrency=<?php echo e($currency); ?>"><?php echo e($currency); ?></a></li>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </ul>
                    </div>

                    <h2 class="pointer">
                        <?php echo app('translator')->getFromJson('dashboard::dashboard.widgets.income_vs_expenses'); ?>
                        <span class="expander">
                            <i class="fa fa-angle-up pointer" aria-hidden="true"></i>
                        </span>
                    </h2>
                </div>
                <div class="body panel-content" style="text-align: center">
                    <div id="income_chart" class="dashboard-income_chartt" style="text-align: center; height: 230px">
                        <?php echo $incomeVsExpense->container(); ?>

                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>

    <div class="row dashboard-row">

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tickets.browse')): ?>
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <div class="card collapsible">
                <div id="dashboard_tickets" class="header card-inside-title">

                    <h2 class="pointer">
                        <?php echo app('translator')->getFromJson('dashboard::dashboard.widgets.tickets'); ?>
                        <span class="expander">
                            <i class="fa fa-angle-up pointer" aria-hidden="true"></i>
                        </span>
                    </h2>
                </div>
                <div class="body panel-content">
                    <div class="table-responsive col-lg-12 col-md-12 col-sm-12">
                        <?php echo e($ticketDatatable->table(['width' => '100%'])); ?>

                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('tickets.browse')): ?>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="card collapsible">
                    <div id="dashboard_tickets_overview" class="header card-inside-title">

                        <span class="badge bg-red pull-right"><?php echo app('translator')->getFromJson('core::core.this_month'); ?></span>
                        <h2 class="pointer">

                            <?php echo app('translator')->getFromJson('dashboard::dashboard.widgets.tickets_overview'); ?>
                            <span class="expander">
                            <i class="fa fa-angle-up pointer" aria-hidden="true"></i>
                        </span>
                        </h2>
                    </div>
                    <div class="body panel-content">
                        <h5><?php echo app('translator')->getFromJson('dashboard::dashboard.widgets.tickets_by_status'); ?></h5>
                        <div style="text-align: center; height: 253px">
                            <?php echo $ticketStatusOverview->container(); ?>

                        </div>
                        <br /><br />
                        <h5><?php echo app('translator')->getFromJson('dashboard::dashboard.widgets.tickets_by_priority'); ?></h5>
                        <div style="text-align: center; height: 253px">
                            <?php echo $ticketPriorityOverview->container(); ?>

                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('css-up'); ?>

<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>


<?php $__env->startPush('scripts'); ?>

    <script type="text/javascript" src="<?php echo e(asset('bap/plugins/chartjs/Chart.bundle.js')); ?>"></script>
    <script src="<?php echo Module::asset('dashboard:js/BAP_Dashboard.js'); ?>"></script>

    <?php echo $leadOverview->script(); ?>

    <?php echo $incomeVsExpense->script(); ?>

    <?php echo $ticketStatusOverview->script(); ?>

    <?php echo $ticketPriorityOverview->script(); ?>


<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<?php echo $ticketDatatable->scripts(); ?>

<?php $__env->stopPush(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>