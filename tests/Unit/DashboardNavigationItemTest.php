<?php

declare(strict_types=1);

use YezzMedia\Dashboard\Navigation\DashboardNavigationItem;

it('creates a navigation item with defaults', function (): void {
    $item = new DashboardNavigationItem('Profile', '/profile');

    expect($item->label)->toBe('Profile');
    expect($item->url)->toBe('/profile');
    expect($item->icon)->toBe('heroicon-o-circle');
    expect($item->group)->toBeNull();
    expect($item->sort)->toBe(0);
});

it('creates a navigation item with all properties', function (): void {
    $item = new DashboardNavigationItem(
        label: 'Security',
        url: '/security',
        icon: 'heroicon-o-shield',
        group: 'user_center',
        sort: 2,
    );

    expect($item->label)->toBe('Security');
    expect($item->icon)->toBe('heroicon-o-shield');
    expect($item->group)->toBe('user_center');
    expect($item->sort)->toBe(2);
});
