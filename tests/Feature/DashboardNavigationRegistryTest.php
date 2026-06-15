<?php

declare(strict_types=1);

use YezzMedia\Dashboard\Navigation\DashboardNavigationItem;
use YezzMedia\Dashboard\Navigation\DashboardNavigationRegistry;

beforeEach(function (): void {
    $this->registry = new DashboardNavigationRegistry;
});

it('registers groups in sort order', function (): void {
    $this->registry
        ->group('z', 'Z Group', 10)
        ->group('a', 'A Group', 1);

    $groups = $this->registry->groups();
    expect(array_keys($groups))->toBe(['a', 'z']);
});

it('registers items within a group', function (): void {
    $this->registry
        ->group('test', 'Test', 1)
        ->add('test', new DashboardNavigationItem('Foo', '/foo', 'heroicon-o-circle', 'test', 2))
        ->add('test', new DashboardNavigationItem('Bar', '/bar', 'heroicon-o-circle', 'test', 1));

    $groups = $this->registry->groups();
    expect($groups['test']['items'])->toHaveCount(2);
    expect($groups['test']['items'][0]->label)->toBe('Bar');
    expect($groups['test']['items'][1]->label)->toBe('Foo');
});

it('auto-creates group when adding item to unknown group', function (): void {
    $this->registry->add('auto', new DashboardNavigationItem('Auto', '/auto'));

    $groups = $this->registry->groups();
    expect($groups)->toHaveKey('auto');
    expect($groups['auto']['label'])->toBe('auto');
});

it('seals and prevents further registration', function (): void {
    $this->registry->seal();

    expect(fn () => $this->registry->group('x', 'X', 1))
        ->toThrow(RuntimeException::class, 'sealed');
});
