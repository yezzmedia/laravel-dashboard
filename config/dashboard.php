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
        'gradient' => env('DASHBOARD_BRAND_GRADIENT', 'linear-gradient(135deg, #10b981, #14b8a6, #0891b2)'),
        'avatar_gradient' => env('DASHBOARD_BRAND_AVATAR_GRADIENT', 'linear-gradient(135deg, #059669, #0f766e)'),
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
