<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => array_filter([
        'http://localhost:3000',
        'http://127.0.0.1:3000',
        'https://localhost:3000',
        'http://localhost:3001',
        'http://127.0.0.1:3001',
        'https://www.auralearn.xyz',
        'https://auralearn.xyz',
        'https://fsuu-auralearn.vercel.app',
        'https://capstone-app-lyart.vercel.app',
        'https://aura-learn.vercel.app',
        'https://auralearn-app.vercel.app',
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