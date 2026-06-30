<?php

declare(strict_types=1);

namespace YezzMedia\Dashboard\Install;

use YezzMedia\Foundation\Data\InstallContext;
use YezzMedia\Foundation\Install\InstallStep;

final class EnsureAppCssHasDarkVariantInstallStep implements InstallStep
{
    public function key(): string
    {
        return 'ensure_app_css_has_dark_variant';
    }

    public function package(): string
    {
        return 'yezzmedia/laravel-dashboard';
    }

    public function priority(): int
    {
        return 10;
    }

    public function shouldRun(InstallContext $context): bool
    {
        $path = base_path('resources/css/app.css');

        if (! file_exists($path)) {
            return false;
        }

        return ! str_contains(file_get_contents($path), '@variant dark');
    }

    public function handle(InstallContext $context): void
    {
        $path = base_path('resources/css/app.css');
        $content = file_get_contents($path);

        $content = $this->ensureDarkVariant($content);
        $content = $this->ensureSourcePaths($content);

        file_put_contents($path, $content);
    }

    private function ensureDarkVariant(string $content): string
    {
        if (str_contains($content, '@variant dark')) {
            return $content;
        }

        return preg_replace(
            "/@import 'tailwindcss';/",
            "@import 'tailwindcss';\n@variant dark (&:where(.dark, .dark *));",
            $content,
        );
    }

    private function ensureSourcePaths(string $content): string
    {
        $sourceLine = "@source '../../vendor/yezzmedia/*/resources/views/**/*.blade.php';";

        if (str_contains($content, $sourceLine)) {
            return $content;
        }

        $insertBefore = '@theme';
        $pos = strpos($content, $insertBefore);
        if ($pos === false) {
            return $content . "\n" . $sourceLine . "\n";
        }

        return substr_replace($content, $sourceLine . "\n\n", $pos, 0);
    }
}
