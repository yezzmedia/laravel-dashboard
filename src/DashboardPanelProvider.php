<?php

declare(strict_types=1);

namespace YezzMedia\Dashboard;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use YezzMedia\Dashboard\Pages\Dashboard;
use YezzMedia\Dashboard\Support\HubExtensionRegistry;

final class DashboardPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $panel = $panel
            ->id('dashboard')
            ->path('hub')
            ->login()
            ->authGuard('web')
            ->navigation(false)
            ->pages([
                Dashboard::class,
            ])
            ->widgets(config('dashboard.widgets', []))
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ], isPersistent: true);

        foreach (app(HubExtensionRegistry::class)->all() as $pluginClass) {
            if (class_exists($pluginClass)) {
                $panel->plugin(app($pluginClass));
            }
        }

        return $panel;
    }
}
