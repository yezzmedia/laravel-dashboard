<?php

declare(strict_types=1);

return [

    'panel' => [
        'id' => 'dashboard',
        'path' => 'hub',
        'guard' => 'web',
    ],

    'brand' => [
        'name' => env('DASHBOARD_BRAND_NAME', 'Dashboard'),
        'logo' => env('DASHBOARD_BRAND_LOGO'),
        'icon' => 'grid',
    ],

    'navigation' => [
        'groups' => [
            'user_center' => ['label' => 'User Center', 'sort' => 1],
        ],
    ],

    'widgets' => [],

    'legal' => [
        'left' => [
            ['label' => 'Help', 'url' => '#'],
            ['label' => 'Cookie Settings', 'url' => '#'],
            ['label' => 'Contact', 'url' => '#'],
        ],
        'right' => [
            ['label' => 'Privacy Policy', 'url' => '#'],
            ['label' => 'Terms of Service', 'url' => 'https://example.com/terms'],
            ['label' => 'Impressum', 'url' => 'https://example.com/imprint'],
        ],
    ],

];
