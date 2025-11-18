<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    // Allowed origins: production frontend plus common local/dev hosts.
    // Keep this list small in production. The patterns below make it easier
    // to test from other devices on your local network (192.168.x.x, 10.x.x.x).
    'allowed_origins' => [
        'https://chrisbalogun-portfolio-zl5o.vercel.app', // production frontend
        'http://localhost',
        'http://127.0.0.1',
        'http://127.0.0.1:8000',
    ],

    // Regex patterns for additional allowed origins (LAN IP ranges).
    // These allow devices on your local network to access the API during testing.
    'allowed_origins_patterns' => [
        '^https?://localhost(:[0-9]+)?$',
        '^https?://127\\.0\\.0\\.1(:[0-9]+)?$',
        '^https?://192\\.168\\.[0-9]{1,3}\\.[0-9]{1,3}(:[0-9]+)?$',
        '^https?://10\\.[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}(:[0-9]+)?$',
    ],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    // Allow credentials (cookies) to be sent for first-party SPA auth (Laravel Sanctum).
    // Make sure to set SANCTUM_STATEFUL_DOMAINS and SESSION_DOMAIN in your production `.env`.
    'supports_credentials' => true,

];
