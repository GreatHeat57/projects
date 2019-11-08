<?php

?>



<?php $__env->startSection('body_class','login-page'); ?>

<?php $__env->startSection('content'); ?>

<link rel="stylesheet" href="https://unpkg.com/materialize-stepper@3.1.0/dist/css/mstepper.min.css">

<style>
    li{
        list-style: none;
    }
</style>

    <div class="login-box">
        <div class="card">
            <div class="body">
                <div class="logo">
                    <a href="javascript:void(0);"><img src="<?php echo e(asset(config('bap.login_logo'))); ?>"/></a>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <form id="sign_up" method="POST" action="<?php echo e(route('login')); ?>">
                        <?php if(isset($errorMessage)): ?>
                            <span class="help-block">
                                <strong><?php echo e($errorMessage); ?></strong>
                            </span>
                        <?php endif; ?>
                        <?php echo e(csrf_field()); ?>

                        <ul class="stepper linear">
                            <li class="step active">
                                <div class="step-title waves-effect">E-mail</div>
                                <div class="step-content">
                                    <input id="name" type="email" class="form-control validation" name="email" autofocus required />
                                    <div class="step-actions">
                                        <button class="waves-effect waves-dark btn btn-primary next-step">CONTINUE</button>
                                    </div>
                                </div>
                            </li>
                            <li class="step">
                                <div class="step-title waves-effect">Password</div>
                                <div class="step-content">
                                <input id="password" type="password" class="form-control required" name="password" required />
                                    <div class="step-actions">
                                        <button class="waves-effect waves-dark btn btn-warning previous-step">BACK</button>
                                        <button type="submit" class="waves-effect waves-dark btn btn-success">SIGN IN</button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="row">
                            <div class="col-xs-6" style="padding-left:45px;">
                                <input type="checkbox" id="rememberme" name="remember"
                                    <?php echo e(old('remember') ? 'checked' : ''); ?> class="filled-in chk-col-pink">
                                <label for="rememberme"><?php echo app('translator')->getFromJson('auth.remember_me'); ?></label>
                            </div>
                        </div>
                        <?php if(config('bap.GOOGLE_RECAPTCHA_KEY')): ?>
                            <div class="row">
                                <div class="col-sm-12 text-center" >
                                    <?php if($errors->has('g-recaptcha-response')): ?>
                                        <span class="help-block error-block">
                                            <strong class="col-red"><?php echo app('translator')->getFromJson('auth.invalid_captacha'); ?></strong>
                                        </span>
                                    <?php endif; ?>
                                    <div class="g-recaptcha" style="display: inline-block"  data-sitekey="<?php echo e(config('bap.GOOGLE_RECAPTCHA_KEY')); ?>"></div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="row m-t-15 m-b--20">
                            <?php if(config('bap.allow_registration')): ?>
                                <div class="col-xs-12 text-right">
                                    <a class="font-bold"
                                       href="<?php echo e(route('password.request')); ?>"><?php echo app('translator')->getFromJson('auth.forget_password'); ?></a>
                                </div>
                            <?php else: ?>
                                <?php if(config('bap.demo')): ?>
                                    <div class="col-xs-6">
                                        <div class="dropdown">
                                            <button class="btn btn-default dropdown-toggle" type="button"
                                                    id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="true">
                                                Choose User
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                <li><a id="userAdmin" href="#">Admin</a></li>
                                                <li><a id="userCompany1" href="#">OSCORP 1 Manager</a></li>
                                                <li><a id="userCompany2" href="#">Umbrella 2 Manager</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 align-right font-bold">
                                        <a class="font-b"
                                           href="<?php echo e(route('password.request')); ?>"><?php echo app('translator')->getFromJson('auth.forget_password'); ?></a>
                                    </div>
                                <?php else: ?>
                                    <div class="col-xs-12 align-right font-bold">
                                        <a class="font-bold" href="<?php echo e(route('password.request')); ?>"><?php echo app('translator')->getFromJson('auth.forget_password'); ?></a>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </form>
                    <?php if(config('services.github.client_id') || config('services.twitter.client_id') || config('services.facebook.client_id')  || config('services.google.client_id')): ?>
                        <br/>.
                        <div class="text-center">
                            <?php if(config('services.github.client_id')): ?>
                                <a href="<?php echo e(url('/auth/github')); ?>" class="btn btn-sm btn-github"><i
                                            class="fa fa-github"></i> Github</a>
                            <?php endif; ?>
                            <?php if(config('services.twitter.client_id')): ?>
                                <a href="<?php echo e(url('/auth/twitter')); ?>" class="btn btn-sm btn-twitter"><i
                                            class="fa fa-twitter"></i> Twitter</a>
                            <?php endif; ?>
                            <?php if(config('services.facebook.client_id')): ?>
                                <a href="<?php echo e(url('/auth/facebook')); ?>" class="btn btn-sm btn-facebook"><i
                                            class="fa fa-facebook"></i> Facebook</a>
                            <?php endif; ?>

                                <?php if(config('services.google.client_id')): ?>
                                    <a href="<?php echo e(url('/auth/google')); ?>" class="btn btn-sm btn-google"><i
                                                class="fa fa-google"></i> Google</a>
                                <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if(config('bap.allow_registration')): ?>
                        <div class="col-lg-12 login-sentence">
                            <h4 class="text-center"><?php echo app('translator')->getFromJson('auth.dont_have_account'); ?>  <?php echo app('translator')->getFromJson('auth.create_account_its_free'); ?></h4>
                            <br/>
                            <br/>
                            <div class="text-center">
                                <a class="font-bold btn bg-pink btn-md " href="<?php echo e(route('register')); ?>">
                                    <span class="font-25">
                                        <?php echo app('translator')->getFromJson('auth.register'); ?>
                                    </span>
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-lg-6 col-sm-12 text-center">
                    <img class="img-responsive margin-0" src="<?php echo e(asset(config('bap.register_img'))); ?>"/>
                </div>
            </div>
        </div>
        <?php if(config('bap.vectors')): ?>
            <div class="text-center">
                <a class="vectors"  target="_blank" href="https://www.freepik.com">Vectors by Freepik</a>
            </div>
        <?php endif; ?>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>