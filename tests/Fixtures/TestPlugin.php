<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use Filament\Contracts\Plugin;
use Filament\Panel;

class TestPlugin implements Plugin
{
    public function getId(): string
    {
        return 'test-plugin';
    }

    public function register(Panel $panel): void {}

    public function boot(Panel $panel): void {}
}
