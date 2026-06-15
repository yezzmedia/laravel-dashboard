<?php

declare(strict_types=1);

namespace YezzMedia\Dashboard\Support;

use Filament\Contracts\Plugin;

final class HubExtensionRegistry
{
    /** @var array<int, class-string<Plugin>> */
    private array $pluginClasses = [];

    private bool $sealed = false;

    /**
     * @param  class-string<Plugin>  $pluginClass
     */
    public function register(string $pluginClass): void
    {
        $this->ensureNotSealed();

        $this->pluginClasses[] = $pluginClass;
    }

    /**
     * @return array<int, class-string<Plugin>>
     */
    public function all(): array
    {
        return $this->pluginClasses;
    }

    public function seal(): void
    {
        $this->sealed = true;
    }

    private function ensureNotSealed(): void
    {
        if ($this->sealed) {
            throw new \RuntimeException('HubExtensionRegistry is sealed — no more plugins can be registered after boot.');
        }
    }
}
