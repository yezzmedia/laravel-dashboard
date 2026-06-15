<?php

declare(strict_types=1);

namespace YezzMedia\Dashboard\Pages;

final class Dashboard extends DashboardPage
{
    protected string $view = 'dashboard::pages.dashboard';

    public static function canAccess(): bool
    {
        return auth(config('dashboard.panel.guard', 'web'))->check();
    }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        return [
            'widgets' => config('dashboard.widgets', []),
        ];
    }
}
