<?php

declare(strict_types=1);

namespace YezzMedia\Dashboard\Navigation;

final class DashboardNavigationItem
{
    public function __construct(
        public string $label,
        public string $url,
        public string $icon = 'heroicon-o-circle',
        public ?string $group = null,
        public int $sort = 0,
        public ?string $permission = null,
        public ?string $badge = null,
        public ?\Closure $badgeCallback = null,
    ) {}
}
