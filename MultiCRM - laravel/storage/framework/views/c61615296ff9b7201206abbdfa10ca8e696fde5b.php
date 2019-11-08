<?php $__env->startSection('body_class','fp-page'); ?>

<?php $__env->startSection('content'); ?>

    <div class="fp-box login-box">


        <div class="card">
            <div class="body">
                <form id="reset_password" method="POST" action="<?php echo e(route('password.email')); ?>">

                    <?php echo e(csrf_field()); ?>


                    <div class="msg">

                        <?php echo app('translator')->getFromJson('auth.reset_password_title'); ?>

                    </div>

                    <?php if(session()->get('status') != null ): ?>
                        <div class="alert alert-success">
                            <?php echo e(session()->get('status')); ?>

                        </div>
                    <?php endif; ?>

                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">email</i>
                        </span>

                        <div class="form-line <?php echo e($errors->has('email') ? ' error' : ''); ?>">
                            <input id="name" type="text" placeholder="<?php echo app('translator')->getFromJson('auth.email'); ?>" class="form-control" name="email" value="<?php echo e(old('email')); ?>" autofocus>
                        </div>

                        <?php if($errors->has('email')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('email')); ?></strong>
                             </span>
                        <?php endif; ?>
                    </div>

                    <div class="text-center">
                    <button class="btn btn-lg bg-pink waves-effect" type="submit"><?php echo app('translator')->getFromJson('auth.reset_my_password'); ?></button>
                    </div>
                    <div class="row m-t-20 m-b--5 align-center">
                        <a class="font-bold" href="<?php echo e(route('login')); ?>"><?php echo app('translator')->getFromJson('auth.sign_in_small_cap'); ?></a>
                    </div>

                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>