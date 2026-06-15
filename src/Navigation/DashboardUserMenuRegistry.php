<?php

declare(strict_types=1);

namespace YezzMedia\Dashboard\Navigation;

final class DashboardUserMenuRegistry
{
    /** @var array<int, DashboardUserMenuItem> */
    private array $items = [];

    private bool $sealed = false;

    public function add(DashboardUserMenuItem $item): static
    {
        $this->ensureNotSealed();

        $this->items[] = $item;

        return $this;
    }

    /**
     * @return array<int, DashboardUserMenuItem>
     */
    public function all(): array
    {
        $sorted = $this->items;

        usort($sorted, fn (DashboardUserMenuItem $a, DashboardUserMenuItem $b): int => $a->sort <=> $b->sort);

        return $sorted;
    }

    public function seal(): void
    {
        $this->sealed = true;
    }

    private function ensureNotSealed(): void
    {
        if ($this->sealed) {
            throw new \RuntimeException('DashboardUserMenuRegistry is sealed — no more items can be registered after boot.');
        }
    }
}
