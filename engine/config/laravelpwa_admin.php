<?php

return [
    'name' => 'Art_demo_admin',
    'manifest' => [
        'name' => env('APP_NAME', 'Art_demo_admin'),
        'short_name' => 'Art_demo_admin',
        'start_url' => env("BACKEND_ACCESS") . "/index",
        'background_color' => '#ffffff',
        'theme_color' => '#000000',
        'display' => 'standalone',
        'orientation' => 'any',
        'icons' => [
            '72x72' => '/themebackend/art_img/icons/icon-72x72.png',
            '96x96' => '/themebackend/art_img/icons/icon-96x96.png',
            '128x128' => '/themebackend/art_img/icons/icon-128x128.png',
            '144x144' => '/themebackend/art_img/icons/icon-144x144.png',
            '152x152' => '/themebackend/art_img/icons/icon-152x152.png',
            '192x192' => '/themebackend/art_img/icons/icon-192x192.png',
            '384x384' => '/themebackend/art_img/icons/icon-384x384.png',
            '512x512' => '/themebackend/art_img/icons/icon-512x512.png'
        ],
        'splash' => [
            '640x1136' => '/themebackend/art_img/icons/splash-640x1136.png',
            '750x1334' => '/themebackend/art_img/icons/splash-750x1334.png',
            '828x1792' => '/themebackend/art_img/icons/splash-828x1792.png',
            '1125x2436' => '/themebackend/art_img/icons/splash-1125x2436.png',
            '1242x2208' => '/themebackend/art_img/icons/splash-1242x2208.png',
            '1242x2688' => '/themebackend/art_img/icons/splash-1242x2688.png',
            '1536x2048' => '/themebackend/art_img/icons/splash-1536x2048.png',
            '1668x2224' => '/themebackend/art_img/icons/splash-1668x2224.png',
            '1668x2388' => '/themebackend/art_img/icons/splash-1668x2388.png',
            '2048x2732' => '/themebackend/art_img/icons/splash-2048x2732.png',
        ],
        'custom' => []
    ]
];
