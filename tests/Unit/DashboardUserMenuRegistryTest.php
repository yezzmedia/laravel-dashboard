<?php

declare(strict_types=1);

use YezzMedia\Dashboard\Navigation\DashboardUserMenuItem;
use YezzMedia\Dashboard\Navigation\DashboardUserMenuRegistry;

beforeEach(function (): void {
    $this->registry = new DashboardUserMenuRegistry;
});

it('returns items in sort order', function (): void {
    $this->registry
        ->add(new DashboardUserMenuItem('Z', '/z', sort: 10))
        ->add(new DashboardUserMenuItem('A', '/a', sort: 1))
        ->add(new DashboardUserMenuItem('M', '/m', sort: 5));

    $items = $this->registry->all();

    expect($items)->toHaveCount(3);
    expect($items[0]->label)->toBe('A');
    expect($items[1]->label)->toBe('M');
    expect($items[2]->label)->toBe('Z');
});

it('returns empty array when no items are registered', function (): void {
    expect($this->registry->all())->toBe([]);
});

it('seals and prevents further registration', function (): void {
    $this->registry->seal();

    expect(fn () => $this->registry->add(new DashboardUserMenuItem('X', '/x')))
        ->toThrow(RuntimeException::class, 'sealed');
});

it('preserves default sort value', function (): void {
    $this->registry
        ->add(new DashboardUserMenuItem('First', '/first'))
        ->add(new DashboardUserMenuItem('Second', '/second', sort: 1));

    $items = $this->registry->all();

    expect($items[0]->label)->toBe('First');
    expect($items[1]->label)->toBe('Second');
});
