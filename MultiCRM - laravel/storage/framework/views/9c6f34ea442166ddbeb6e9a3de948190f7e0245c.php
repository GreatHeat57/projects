<?php $__env->startSection('body_class','signup-page'); ?>

<?php $__env->startSection('content'); ?>

    <div class="signup-box login-box">


        <div class="card">
            <div class="body">

                <div class="col-lg-6 col-sm-12">

                    <div class="text-center">
                        <img src="<?php echo e(asset(config('bap.login_logo'))); ?>" />
                    </div>

                    <form id="sign_up" method="POST" action="<?php echo e(route('register')); ?>">

                        <?php echo e(csrf_field()); ?>


                        <h4 class="msg"><?php echo app('translator')->getFromJson('auth.register_title'); ?></h4>
                        <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                            <div class="form-line <?php echo e($errors->has('first_name') ? ' error' : ''); ?>">
                                <input id="name" placeholder="<?php echo app('translator')->getFromJson('auth.first_name'); ?>" type="text" class="form-control"
                                       name="first_name" value="<?php echo e(old('first_name')); ?>" autofocus>
                            </div>

                            <?php if($errors->has('first_name')): ?>
                                <span class="help-block">
                                <strong><?php echo e($errors->first('first_name')); ?></strong>
                             </span>
                            <?php endif; ?>

                        </div>
                        <div class="input-group <?php echo e($errors->has('email') ? ' error' : ''); ?>">
                        <span class="input-group-addon">
                            <i class="material-icons">email</i>
                        </span>
                            <div class="form-line">
                                <input id="email" placeholder="<?php echo app('translator')->getFromJson('auth.email'); ?>" type="email" class="form-control"
                                       name="email" value="<?php echo e(old('email')); ?>">
                            </div>
                            <?php if($errors->has('email')): ?>
                                <span class="help-block">
                                <strong><?php echo e($errors->first('email')); ?></strong>
                             </span>
                            <?php endif; ?>
                        </div>
                        <div class="input-group <?php echo e($errors->has('password') ? ' error' : ''); ?>">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                            <div class="form-line">
                                <input id="password" placeholder="<?php echo app('translator')->getFromJson('auth.password'); ?>" type="password"
                                       class="form-control" name="password">
                            </div>
                            <?php if($errors->has('password')): ?>
                                <span class="help-block">
                                <strong><?php echo e($errors->first('password')); ?></strong>
                             </span>
                            <?php endif; ?>

                            <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                            <div class="form-line">
                                <input id="password-confirm" placeholder="<?php echo app('translator')->getFromJson('auth.confirm_password'); ?>"
                                       type="password" class="form-control" name="password_confirmation">
                            </div>

                            <?php if($errors->has('password_confirmation')): ?>
                                <span class="help-block">
                                <strong><?php echo e($errors->first('password_confirmation')); ?></strong>
                             </span>
                            <?php endif; ?>
                        </div>

                        <div class="col-sm-4">
                            <button class="btn btn-lg bg-pink waves-effect waves-block" type="submit"><?php echo app('translator')->getFromJson('auth.sign_up'); ?></button>
                        </div>
                        <div class="col-sm-8 text-right p-r-0">
                            <a class="font-bold" href="<?php echo e(route('login')); ?>" style="line-height: 40px"><?php echo app('translator')->getFromJson('auth.already_have_membership'); ?></a>
                        </div>

                        <?php if(config('bap.GOOGLE_RECAPTCHA_KEY')): ?>
                            <div class="row">
                                <div class="col-sm-12 text-center">

                                    <?php if($errors->has('g-recaptcha-response')): ?>
                                        <span class="help-block error-block">
                                             <strong class="col-red"><?php echo app('translator')->getFromJson('auth.invalid_captacha'); ?></strong>
                                        </span>
                                    <?php endif; ?>

                                    <div class="g-recaptcha" style="display: inline-block"  data-sitekey="<?php echo e(config('bap.GOOGLE_RECAPTCHA_KEY')); ?>"></div>
                                </div>
                            </div>
                        <?php endif; ?>

                    </form>

                    <div class="col-sm-12 text-center">

                        <?php if(config('services.github.client_id') || config('services.twitter.client_id') || config('services.facebook.client_id')  || config('services.google.client_id')): ?>
                            <p>
                                <?php echo app('translator')->getFromJson('auth.or_signup_using'); ?>
                            </p>

                            <?php if(config('services.github.client_id')): ?>
                                <a href="<?php echo e(url('/auth/github')); ?>" class="btn btn-md btn-github"><i
                                            class="fa fa-github"></i> Github</a>
                            <?php endif; ?>
                            <?php if(config('services.twitter.client_id')): ?>
                                <a href="<?php echo e(url('/auth/twitter')); ?>" class="btn btn-md btn-twitter"><i
                                            class="fa fa-twitter"></i> Twitter</a>
                            <?php endif; ?>
                            <?php if(config('services.facebook.client_id')): ?>
                                <a href="<?php echo e(url('/auth/facebook')); ?>" class="btn btn-md btn-facebook"><i
                                            class="fa fa-facebook"></i> Facebook</a>
                            <?php endif; ?>

                            <?php if(config('services.google.client_id')): ?>
                                <a href="<?php echo e(url('/auth/google')); ?>" class="btn btn-sm btn-google"><i
                                            class="fa fa-google"></i> Google</a>
                            <?php endif; ?>
                        <?php endif; ?>

                    </div>

                </div>


                <div class="col-lg-6 col-sm-12 text-center">

                    <img class="img-responsive margin-0" src="<?php echo e(asset(config('bap.register_img'))); ?>"/>

                </div>


            </div>
        </div>

        <?php if(config('bap.vectors')): ?>
            <div class="text-center">
                <a class="vectors" target="_blank" href="https://www.freepik.com">Vectors by Freepik</a>
            </div>
        <?php endif; ?>
    </div>


    <div id="signupModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">

                <div class="modal-body">
                    <div class="text-center">
                        <h4 class="msg">

                            <?php echo app('translator')->getFromJson('auth.please_wait_we_are_preparing'); ?>

                        </h4>

                        <?php if(config('bap.show_register_gif')): ?>
                            <iframe src="https://giphy.com/embed/326joM06WxFNMSkPjj" width="480" height="480" frameBorder="0" class="giphy-embed" allowFullScreen></iframe><p><a href="https://giphy.com/gifs/bublywater-work-tired-326joM06WxFNMSkPjj">via GIPHY</a></p>
                        <?php endif; ?>
                    </div>


                </div>

            </div>

        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>