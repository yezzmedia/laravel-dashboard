<?php

declare(strict_types=1);

namespace YezzMedia\Dashboard\Navigation;

final class DashboardUserMenuItem
{
    public function __construct(
        public string $label,
        public string $url,
        public string $icon = 'heroicon-o-circle',
        public ?string $permission = null,
        public int $sort = 0,
    ) {}
}
