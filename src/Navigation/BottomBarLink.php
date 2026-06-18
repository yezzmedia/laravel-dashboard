<?php

declare(strict_types=1);

namespace YezzMedia\Dashboard\Navigation;

final readonly class BottomBarLink
{
    public function __construct(
        public string $label,
        public string $url,
        public string $section = 'right',
        public int $sort = 100,
    ) {}

    /**
     * @return array{label: string, url: string}
     */
    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'url' => $this->url,
        ];
    }
}
