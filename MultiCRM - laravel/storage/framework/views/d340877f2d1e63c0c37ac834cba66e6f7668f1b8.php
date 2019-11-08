<script type="text/javascript">

    window.APPLICATION_USER_DATE_FORMAT = '<?php echo e(\Modules\Platform\Core\Helper\UserHelper::userJsDateFormat()); ?>';
    window.APPLICATION_USER_TIME_FORMAT = '<?php echo e(\Modules\Platform\Core\Helper\UserHelper::userJsTimeFormat()); ?>';
    window.APPLICATION_USER_LANGUAGE = '<?php echo e(app()->getLocale()); ?>';
    window.APPLICATION_USER_TIMEZONE = '<?php echo e(Auth::user()->time_zone); ?>';
    window.UID = '<?php echo e(Auth::user()->id); ?>';
    window.PUSHER_ACIVE = '<?php echo e(config('broadcasting.connections.pusher.key') != '' ? 1 : 0); ?>';
    <?php if(\Modules\Platform\Core\Helper\UserHelper::userJsTimeFormat()  == 'HH:mm'): ?>
    window.APPLICATION_USER_TIME_FORMAT_24 = true;
    <?php else: ?>
    window.APPLICATION_USER_TIME_FORMAT_24 = false;
    <?php endif; ?>
    <?php if(config('bap.tags_allow_add_new')): ?>
    window.APPLICATION_ALLOW_NEW_TAGS = true;
    <?php else: ?>
    window.APPLICATION_ALLOW_NEW_TAGS = false;
    <?php endif; ?>
</script>


<?php if(config('bap.google_ga')): ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo e(config('app.google_ga')); ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '<?php echo e(config('bap.google_ga')); ?>');
    </script>
<?php endif; ?>
