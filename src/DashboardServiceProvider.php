<?php

declare(strict_types=1);

namespace YezzMedia\Dashboard;

use Illuminate\Support\Facades\Gate;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use YezzMedia\Dashboard\Navigation\DashboardNavigationRegistry;
use YezzMedia\Dashboard\Navigation\DashboardUserMenuRegistry;
use YezzMedia\Dashboard\Support\HubExtensionRegistry;
use YezzMedia\Foundation\Support\PlatformPackageRegistrar;

class DashboardServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-dashboard')
            ->hasConfigFile('dashboard')
            ->hasTranslations()
            ->hasViews()
            ->hasRoute('web');
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(DashboardNavigationRegistry::class, fn ($app) => new DashboardNavigationRegistry);

        $this->app->singleton(HubExtensionRegistry::class, fn ($app) => new HubExtensionRegistry);

        $this->app->singleton(DashboardUserMenuRegistry::class, fn ($app) => new DashboardUserMenuRegistry);

        $this->app->register(DashboardPanelProvider::class);
    }

    public function packageBooted(): void
    {
        Gate::define('dashboard.access', fn ($user) => true);

        $this->app->make(PlatformPackageRegistrar::class)
            ->register(new DashboardPlatformPackage);

        $this->app->booted(function (): void {
            $this->app->make(DashboardNavigationRegistry::class)->seal();
            $this->app->make(HubExtensionRegistry::class)->seal();
            $this->app->make(DashboardUserMenuRegistry::class)->seal();
        });
    }
}
