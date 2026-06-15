<?php

declare(strict_types=1);

use Tests\Fixtures\AnotherPlugin;
use Tests\Fixtures\TestPlugin;
use YezzMedia\Dashboard\Support\HubExtensionRegistry;

beforeEach(function (): void {
    $this->registry = new HubExtensionRegistry;
});

it('registers plugin classes', function (): void {
    $this->registry->register(TestPlugin::class);

    expect($this->registry->all())->toHaveCount(1);
    expect($this->registry->all()[0])->toBe(TestPlugin::class);
});

it('returns multiple registered plugins', function (): void {
    $this->registry
        ->register(TestPlugin::class)
        ->register(AnotherPlugin::class);

    expect($this->registry->all())->toHaveCount(2);
});

it('returns empty array when no plugins are registered', function (): void {
    expect($this->registry->all())->toBe([]);
});

it('seals and prevents further registration', function (): void {
    $this->registry->seal();

    expect(fn () => $this->registry->register(TestPlugin::class))
        ->toThrow(RuntimeException::class, 'sealed');
});
