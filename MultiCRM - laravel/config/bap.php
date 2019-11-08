<?php

return [

    /*
    |--------------------------------------------------------------------------
    | laravel-bap.com - global settings
    |--------------------------------------------------------------------------

    */


    'version' => env('APP_VERSION', '1.0'),

    'allow_registration' => env('BAP_ALLOW_REGISTRATION', false),

    /*
     * Attachments module validation
     */
    'file_upload_types' => 'jpe?g|png|pdf|zip|rar|doc?x',
    'file_upload_laravel_validation' => 'jpg,jpeg,png,pdf,zip,rar,doc,docx',
    'allowe_file_types_message' => 'Jpg, Jpeg, Png, Pdf, Zip, Rar, Doc, Docx',

    /*
     * because soft delete does not check foreign keys,
     * we added a special validation when deleting records. Note that foreign keys must be defined in the database
     * Validation is added In SettingsCrudController, ModuleCrudController
     * Example: (when deleting Language with id 1,  all users with language_id = 1 will be broken and view won't work)
     */
    'validate_fk_on_soft_delete' => true,

    /*
     * XSS Protection Middleware
     */
    'xss_protection_available_html_tags' => '<p><b><strike><blockquote><h1><h2><h3><h4><sup><sub><br><strong><i>',

    /*
     * Google analytics
     */
    'google_ga' => env('GOOGLE_GA', ''),

    'global_search' => false, // Not working yet

    /*
     * Demo instance configuration
     */
    'install_demo_data' => env('BAP_INSTALL_DEMO_DATA', false),
    'demo' => env('BAP_DEMO', false),

    'demo_login' => 'admin@laravel-bap.com',
    'demo_pass' => 'admin',

    'demo_company_1' => 'norman@laravel-bap.com',
    'demo_company_pass_1' => 'admin',

    'demo_company_2' => 'ada@laravel-bap.com',
    'demo_company_pass_2' => 'admin',

    /**
     * Set to true if only BAP Platform is installed
     * Set to false if BAP CRM is installed
     */
    'clean_platform' => env('CLEAN_BAP_PLATFORM', false),

    /**
     * Notifications
     */
    'comment_notification_enabled' => env('BAP_COMMENT_NOTIFICATION_ENABLED', true),
    'attachment_notification_enabled' => env('BAP_ATTACHMENT_NOTIFICATION_ENABLED', true),
    'record_assigned_notification_enabled' => env('BAP_RECORD_ASSIGNED_NOTIFICATION_ENABLED', true),

    /**
     * Gravatar ( Example in Contacts Module )
     */
    'gravatar_resize_width' => 150,
    'gravatar_resize_height' => 150,
    'gravatar_display_size' => 80,
    'gravatar_seo' => env('GRAVATAR_SEO', true),
    'gravatar_seo_contact_name' => env('GRAVATAR_SEO_CONTACT_NAME', true),
    'gravatar_seo_contact_keywords' => env('GRAVATAR_SEO_KEYWORDS', true),


    /**
     * https://en.gravatar.com/site/implement/images/
     *  404: do not load any image if none is associated with the email hash, instead return an HTTP 404 (File Not Found) response
     *  mp: (mystery-person) a simple, cartoon-style silhouetted outline of a person (does not vary by email hash)
     *  identicon: a geometric pattern based on an email hash
     *  monsterid: a generated 'monster' with different colors, faces, etc
     *  wavatar: generated faces with differing features and backgrounds
     *  retro: awesome generated, 8-bit arcade-style pixelated faces
     *  robohash: a generated robot with different colors, faces, etc
     *  blank: a transparent PNG image (border added to HTML below for demonstration purposes)
     */
    'gravatar_default_preview' => 'wavatar',

    /**
     * Store gravatars on local file
     */
    'gravatar_local_cache' => true,

    /**
     * Allow users to create new tags
     */
    'tags_allow_add_new' => env('BAP_TAGS_ALLOW_ADD_NEW', false),

    /**
     * ball - Display ball pre-loaded
     * cirecle - Display circle pre-loaded
     * none - Don't display preloaded. Faster page loading.
     */
    'preloader_type' => env('PRELOADER_TYPE', 'none'), // ball, circle, none

    /**
     * 0 - Data in Datatables are loaded on tab click in module details. Faster single record loading.
     * 1 - Data in Datatables are pre-loaded in tabs in module details. Slower single record loading.
     */
    'defer_datatable' => env('PRELOAD_DATA_IN_DATATBLES', 0),

    /**
     * Faster loading of module index page
     */
    'disableCountTo' => env('DISABLE_COUNT_TO', true),

    'login_logo' => env('BAP_LOGIN_LOGO', '/bap/logo/multicrm_logo_2.png'),

    'register_img' => env('BAP_REGISTER_IMG', '/bg/login/register.png'),

    /**
     * See /app/Console/EmailTest
     */
    'email_test' => env('BAP_EMAIL_TEST', ''),

    /**
     * Force application to use SSL
     */
    'force_ssl' => env('BAP_FORCE_SSL', false),

    /**
     * Background image before login page
     */
    'auth_bg' => env('AUTH_BG', '/bg/login/architecture-1868667_1920.jpg'),
    'favicon' =>  env('FAVICON','bap/images/favicon.png'),

    /**
     * Show information about vectors on login|register page
     */
    'vectors' => env('SHOW_VECTORS_INFO', true),


    /**
     * Verify captcha on login  and register
     */
    'GOOGLE_RECAPTCHA_KEY' => env('GOOGLE_RECAPTCHA_KEY', ''),
    'GOOGLE_RECAPTCHA_SECRET' => env('GOOGLE_RECAPTCHA_SECRET', ''),

    /**
     * Stripe payment setup
     */
    'stripe_public_key' => env('STRIPE_PUBLIC_KEY'),
    'stripe_secret_key' => env('STRIPE_SECRET_KEY'),

    'show_register_gif' => env('SHOW_REGISTER_GIF',true)

];
