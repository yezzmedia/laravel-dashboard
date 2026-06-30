<p align="center">
  <picture>
    <source media="(prefers-color-scheme: dark)" srcset="https://raw.githubusercontent.com/yezzmedia/.github/main/profile/yezzmedia-dark.svg">
    <img src="https://raw.githubusercontent.com/yezzmedia/.github/main/profile/yezzmedia-light.svg" alt="Yezz Media" height="40">
  </picture>
</p>

<p align="center">
  <a href="https://packagist.org/packages/yezzmedia/laravel-dashboard"><img src="https://img.shields.io/packagist/v/yezzmedia/laravel-dashboard?style=flat-square" alt="Latest Version"></a>
  <a href="https://packagist.org/packages/yezzmedia/laravel-dashboard"><img src="https://img.shields.io/packagist/php-v/yezzmedia/laravel-dashboard?style=flat-square" alt="PHP Version"></a>
  <a href="https://packagist.org/packages/yezzmedia/laravel-dashboard"><img src="https://img.shields.io/packagist/l/yezzmedia/laravel-dashboard?style=flat-square" alt="License"></a>
</p>

---

# Laravel Dashboard

`yezzmedia/laravel-dashboard` is the shared navigation shell for Yezz Media user-facing packages.

It provides a consistent Blade layout with navbar, collapsible sidebar, bottom-bar zone, and dynamic hub page — extended by `laravel-account`, `laravel-user-projects`, `laravel-user-consent`, and `laravel-user-support` through stable navigation and extension registries.

## Version

Current release: `0.2.0`

## Requirements

- PHP `^8.5`
- Laravel `^13.0` components
- `filament/filament ^5.0`
- `spatie/laravel-package-tools ^1.93`
- `yezzmedia/laravel-foundation ^0.2`

Optional:

- `yezzmedia/laravel-account` — registers user-facing navigation items for the account surface

## Installation

```bash
composer require yezzmedia/laravel-dashboard
```

The service provider is auto-discovered.

## What The Package Provides

### Navigation Shell

`DashboardServiceProvider` registers the shared `layouts/dashboard.blade.php` layout with:

- Responsive navbar with user dropdown and theme toggle
- Collapsible sidebar with active-state left-border indicators
- Bottom-bar zone via `BottomBarLinkRegistry`
- Mobile sidebar with gradient brand header
- Context-aware sidebar footer

### Hub Page

The dashboard hub page (`/dashboard`) displays a widget-based overview with:

- Page header with icon and dynamic user greeting
- Left sidebar: account card, quick links grouped by navigation categories
- Main area: registered hub widgets from consumer packages
- Empty states when no widgets are registered

### Extension Registries

Package integrates with foundation through:

- `DashboardExtensionRegistry` — consumer packages register hub widgets
- `DashNavigationRegistry` — consumer packages register sidebar navigation items
- `UserMenuRegistry` — consumer packages extend the user dropdown menu
- `BottomBarLinkRegistry` — consumer packages add bottom-bar links

### Install Steps

Two foundation-aligned install steps ensure the host is correctly configured:

- **`EnsureFilamentPanelHasDefaultInstallStep`** — adds `->default()` to the generated `AdminPanelProvider` so `filament()->getDefaultPanel()` resolves
- **`EnsureAppCssHasDarkVariantInstallStep`** — ensures `@variant dark` and package source paths exist in the host `resources/css/app.css`

These run automatically during `php artisan website:install`.

### Routes

The package registers:

- `GET /dashboard` — hub page
- `POST /logout` — session logout

## Development

```bash
composer test
composer analyse
composer format
```

## License

MIT
