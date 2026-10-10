<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'midtrans' => [
        'server_key' => env('MIDTRANS_SERVER_KEY'),
        'client_key' => env('MIDTRANS_CLIENT_KEY'),
        'is_production' => (bool) env('MIDTRANS_IS_PRODUCTION', false),
        'is_sanitized' => (bool) env('MIDTRANS_IS_SANITIZED', true),
        'is_3ds' => (bool) env('MIDTRANS_IS_3DS', true),
        'merchant_id' => env('MIDTRANS_MERCHANT_ID'),
    ],

    'meta_wa' => [
        'token' => env('META_WA_TOKEN'),
        'phone_number_id' => env('META_WA_PHONE_NUMBER_ID'),
        'business_account_id' => env('META_WA_BUSINESS_ACCOUNT_ID'),
        'api_version' => env('META_WA_API_VERSION', 'v25.0'),
        'webhook_verify_token' => env('META_WA_WEBHOOK_VERIFY_TOKEN'),
        'template_name' => env('META_WA_OTP_TEMPLATE', 'vertifikasi'),
        'template_lang' => env('META_WA_OTP_LANG', 'en_US'),
    ],

];
