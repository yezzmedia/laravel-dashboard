<?php

declare(strict_types=1);

namespace YezzMedia\Dashboard\Pages;

final class Dashboard extends DashboardPage
{
    protected string $view = 'dashboard::pages.dashboard';

    public static function canAccess(): bool
    {
        $guard = auth(config('dashboard.panel.guard', 'web'));

        if (! $guard->check()) {
            return false;
        }

        return $guard->user()->can('dashboard.access');
    }

    public function getTitle(): string
    {
        return $this->translate('dashboard::dashboard.pages.dashboard.title', 'Dashboard');
    }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        return [
            'pageDescription' => $this->translate('dashboard::dashboard.pages.dashboard.description', 'Manage your account, security, and preferences from your control center.'),
            'widgets' => config('dashboard.widgets', []),
        ];
    }
}
