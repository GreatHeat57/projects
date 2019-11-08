<?php $__env->startSection('template_title'); ?>
    <?php echo e(trans('installer_messages.environment.classic.templateTitle')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    <i class="fa fa-code fa-fw" aria-hidden="true"></i> <?php echo e(trans('installer_messages.environment.classic.title')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('container'); ?>

    <?php
      $installationValidator = new \Modules\Platform\Core\Helper\Installer\InstallerValidator();
      $installationValidator->validate();
    ?>

    <div class="msg-box">

        <div class="<?php echo e($installationValidator->valid ? 'success' : 'error'); ?>">
            <?php echo e($installationValidator->message); ?>

        </div>

    </div>

    <form method="post" action="<?php echo e(route('LaravelInstaller::environmentSaveClassic')); ?>">
        <?php echo csrf_field(); ?>

        <textarea class="textarea" name="envConfig"><?php echo e($envConfig); ?></textarea>
        <div class="buttons buttons--right">
            <button class="button " type="submit">
            	<i class="fa fa-floppy-o fa-fw" aria-hidden="true"></i>
             	<?php echo trans('installer_messages.environment.classic.save'); ?>

            </button>
            <?php if($installationValidator->valid): ?>
                    <a style="font-size: 20px;" class="button float-right" href="<?php echo e(route('LaravelInstaller::database')); ?>">
                        <i class="fa fa-check fa-fw" aria-hidden="true"></i>
                        <?php echo trans('installer_messages.environment.classic.install'); ?>

                        <i class="fa fa-angle-double-right fa-fw" aria-hidden="true"></i>
                    </a>
            <?php endif; ?>
        </div>
    </form>




<?php $__env->stopSection(); ?>
<?php echo $__env->make('vendor.installer.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>