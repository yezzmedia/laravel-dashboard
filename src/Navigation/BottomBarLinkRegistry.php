<?php

declare(strict_types=1);

namespace YezzMedia\Dashboard\Navigation;

final class BottomBarLinkRegistry
{
    /** @var array<string, array<int, BottomBarLink>> */
    private array $links = ['left' => [], 'right' => []];

    private bool $sealed = false;

    public function add(BottomBarLink $link): static
    {
        $this->ensureNotSealed();
        $this->links[$link->section][] = $link;

        return $this;
    }

    /**
     * @return array{left: array<int, array{label: string, url: string}>, right: array<int, array{label: string, url: string}>}
     */
    public function toConfigArray(): array
    {
        $result = ['left' => [], 'right' => []];

        foreach (['left', 'right'] as $section) {
            $sorted = $this->links[$section];
            usort($sorted, fn (BottomBarLink $a, BottomBarLink $b): int => $a->sort <=> $b->sort);
            $result[$section] = array_map(fn (BottomBarLink $link): array => $link->toArray(), $sorted);
        }

        return $result;
    }

    public function seal(): void
    {
        $this->sealed = true;
    }

    private function ensureNotSealed(): void
    {
        if ($this->sealed) {
            throw new \RuntimeException('BottomBarLinkRegistry is sealed — no more links can be registered after boot.');
        }
    }
}
