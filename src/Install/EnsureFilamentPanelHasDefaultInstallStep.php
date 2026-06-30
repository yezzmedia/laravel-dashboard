<?php

declare(strict_types=1);

namespace YezzMedia\Dashboard\Install;

use YezzMedia\Foundation\Data\InstallContext;
use YezzMedia\Foundation\Install\InstallStep;

final class EnsureFilamentPanelHasDefaultInstallStep implements InstallStep
{
    public function key(): string
    {
        return 'ensure_filament_panel_has_default';
    }

    public function package(): string
    {
        return 'yezzmedia/laravel-dashboard';
    }

    public function priority(): int
    {
        return 20;
    }

    public function shouldRun(InstallContext $context): bool
    {
        $path = app_path('Providers/Filament/AdminPanelProvider.php');

        if (! file_exists($path)) {
            return false;
        }

        $content = file_get_contents($path);

        return ! str_contains($content, '->default()');
    }

    public function handle(InstallContext $context): void
    {
        $path = app_path('Providers/Filament/AdminPanelProvider.php');
        $content = file_get_contents($path);

        if (str_contains($content, '->default()')) {
            return;
        }

        $content = preg_replace(
            '/(\s*->path\([^)]+\))/',
            "$1\n            ->default()",
            $content,
        );

        file_put_contents($path, $content);
    }
}
