<?php

declare(strict_types=1);

use YezzMedia\Dashboard\Navigation\DashboardUserMenuItem;

it('creates a user menu item with defaults', function (): void {
    $item = new DashboardUserMenuItem('Profile', '/profile');

    expect($item->label)->toBe('Profile');
    expect($item->url)->toBe('/profile');
    expect($item->icon)->toBe('heroicon-o-circle');
    expect($item->permission)->toBeNull();
    expect($item->sort)->toBe(0);
});

it('creates a user menu item with all properties', function (): void {
    $item = new DashboardUserMenuItem(
        label: 'Settings',
        url: '/settings',
        icon: 'heroicon-o-cog',
        permission: 'dashboard.manage',
        sort: 5,
    );

    expect($item->label)->toBe('Settings');
    expect($item->url)->toBe('/settings');
    expect($item->icon)->toBe('heroicon-o-cog');
    expect($item->permission)->toBe('dashboard.manage');
    expect($item->sort)->toBe(5);
});
