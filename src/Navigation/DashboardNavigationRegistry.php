<?php

declare(strict_types=1);

namespace YezzMedia\Dashboard\Navigation;

final class DashboardNavigationRegistry
{
    /** @var array<string, array{label: string, sort: int, items: array<int, DashboardNavigationItem>}> */
    private array $groups = [];

    private bool $sealed = false;

    public function group(string $key, string $label, int $sort = 0): static
    {
        $this->ensureNotSealed();

        if (! isset($this->groups[$key])) {
            $this->groups[$key] = ['label' => $label, 'sort' => $sort, 'items' => []];
        }

        return $this;
    }

    public function add(string $groupKey, DashboardNavigationItem $item): static
    {
        $this->ensureNotSealed();

        if (! isset($this->groups[$groupKey])) {
            $this->group($groupKey, $groupKey);
        }

        $this->groups[$groupKey]['items'][] = $item;

        return $this;
    }

    /**
     * @return array<string, array{label: string, sort: int, items: array<int, DashboardNavigationItem>}>
     */
    public function groups(): array
    {
        $sorted = $this->groups;

        uasort($sorted, fn (array $a, array $b): int => $a['sort'] <=> $b['sort']);

        foreach ($sorted as $key => $group) {
            usort($sorted[$key]['items'], fn (DashboardNavigationItem $a, DashboardNavigationItem $b): int => $a->sort <=> $b->sort);
        }

        return $sorted;
    }

    public function seal(): void
    {
        $this->sealed = true;
    }

    private function ensureNotSealed(): void
    {
        if ($this->sealed) {
            throw new \RuntimeException('DashboardNavigationRegistry is sealed — no more items can be registered after boot.');
        }
    }
}
