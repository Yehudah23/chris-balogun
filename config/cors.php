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

    // Restrict allowed origins to your deployed frontend domain.
    // Replace or add more domains if you host multiple frontends.
    'allowed_origins' => [
        'https://chrisbalogun-portfolio-zl5o.vercel.app', // <-- your frontend domain
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    // Allow credentials (cookies) to be sent for first-party SPA auth (Laravel Sanctum).
    // Make sure to set SANCTUM_STATEFUL_DOMAINS and SESSION_DOMAIN in your production `.env`.
    'supports_credentials' => true,

];
