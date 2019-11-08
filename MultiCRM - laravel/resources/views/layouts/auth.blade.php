
<?php
use Modules\Platform\Core\Helper\SettingsHelper as SettingsHelper;
use Krucas\Settings\Facades\Settings as Settings;
?>

<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>{{ config('app.name') }}</title>
    <!-- Favicon-->

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset(config('bap.favicon')) }}" type="image/png">


    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <link href="https://fonts.googleapis.com/css?family=Lato:300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/materialize-stepper@3.1.0/dist/css/mstepper.min.css">

    <!-- Css -->
    {!!  Packer::css([
        '/bap/plugins/bootstrap/css/bootstrap.css',
        '/bap/plugins/node-waves/waves.css',
        '/bap/plugins/animate-css/animate.css',
        '/bap/scss/style.css',
        '/bap/scss/auth.css',
        '/bap/plugins/font-awesome/css/font-awesome.min.css'
        ],'/storage/cache/css/auth.min.css'
    ) !!}

    @if(config('bap.google_ga'))
    <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('app.google_ga') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', '{{ config('bap.google_ga') }}');
        </script>
    @endif

</head>

<body  style="background: url('{{ config('bap.auth_bg') }}'); background-size: cover;" class="login-page ls-closed auth-background">

@yield('content')


    <script src='https://www.google.com/recaptcha/api.js'></script>

    <!-- Scripts -->
    {!! Packer::js([
        '/bap/plugins/jquery/jquery.min.js',
        '/bap/plugins/bootstrap/js/bootstrap.js',
        '/bap/plugins/node-waves/waves.js',
        '/bap/js/admin.js',
        '/bap/js/login.js'],
        '/storage/cache/js/auth.main.js'
    )  !!}
    <script src="https://unpkg.com/materialize-stepper@3.1.0/dist/js/mstepper.min.js"></script>

</body>
</html>
