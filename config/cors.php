<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => array_filter([
        'http://localhost:3000',
        'http://127.0.0.1:3000',
        'https://localhost:3000',
        env('FRONTEND_URL'),
    ]),

    'allowed_origins_patterns' => [
        '/^https:\/\/aura-learn-frontend-.*\.vercel\.app$/',
        '/^https:\/\/.*-kenshis-projects-.*\.vercel\.app$/',
    ],

    'allowed_headers' => ['*'],

    'exposed_headers' => ['Set-Cookie'],

    'max_age' => 600,

    'supports_credentials' => true,
]; 