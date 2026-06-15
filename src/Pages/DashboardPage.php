<?php

declare(strict_types=1);

namespace YezzMedia\Dashboard\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Auth\Authenticatable;
use YezzMedia\Dashboard\Navigation\DashboardNavigationRegistry;

abstract class DashboardPage extends Page
{
    protected static string $layout = 'dashboard::layouts.dashboard';

    protected function translate(string $key, string $fallback): string
    {
        return trans()->has($key) ? __($key) : $fallback;
    }

    protected function initials(Authenticatable $user): string
    {
        $name = $user->name ?? $user->email ?? 'U';
        $parts = explode(' ', $name);
        $initials = '';

        foreach ($parts as $part) {
            if (! empty($part)) {
                $initials .= strtoupper($part[0]);
            }
        }

        return substr($initials, 0, 2) ?: 'U';
    }

    /**
     * @return array<string, mixed>
     */
    protected function getLayoutData(): array
    {
        $registry = app(DashboardNavigationRegistry::class);
        $user = auth(config('dashboard.panel.guard', 'web'))->user();

        $profileSummary = null;
        if ($user instanceof Authenticatable) {
            $profileSummary = [
                'name' => $user->name ?? $user->email ?? 'User',
                'email' => $user->email ?? '',
                'initials' => $this->initials($user),
            ];
        }

        return [
            'pageTitle' => $this->getTitle(),
            'navigationGroups' => $registry->groups(),
            'profileSummary' => $profileSummary,
        ];
    }
}
