<?php

declare(strict_types=1);

use YezzMedia\Dashboard\DashboardPlatformPackage;

it('returns package metadata', function (): void {
    $pkg = new DashboardPlatformPackage;
    $metadata = $pkg->metadata();

    expect($metadata->name)->toBe('yezzmedia/laravel-dashboard');
    expect($metadata->vendor)->toBe('yezzmedia');
    expect($metadata->packageClass)->toBe(DashboardPlatformPackage::class);
});

it('defines permissions', function (): void {
    $pkg = new DashboardPlatformPackage;
    $permissions = $pkg->permissionDefinitions();

    expect($permissions)->toHaveCount(2);

    $names = array_map(fn ($p) => $p->name, $permissions);
    expect($names)->toContain('dashboard.access');
    expect($names)->toContain('dashboard.manage');
});

it('defines features', function (): void {
    $pkg = new DashboardPlatformPackage;
    $features = $pkg->featureDefinitions();

    expect($features)->toHaveCount(1);

    expect($features[0]->name)->toBe('dashboard.hub');
});

it('defines audit events', function (): void {
    $pkg = new DashboardPlatformPackage;
    $events = $pkg->auditEventDefinitions();

    expect($events)->toHaveCount(2);

    $keys = array_map(fn ($e) => $e->key, $events);
    expect($keys)->toContain('dashboard.page_visited');
    expect($keys)->toContain('dashboard.navigation_navigated');
});
