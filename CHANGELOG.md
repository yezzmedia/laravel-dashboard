# Changelog

All notable changes to `yezzmedia/laravel-dashboard` will be documented in this file.

The format is based on Keep a Changelog and this package follows Semantic Versioning.

## [Unreleased]

## [0.2.0] - 2026-06-30

### Added

- `EnsureFilamentPanelHasDefaultInstallStep` — automatically adds `->default()` to the host `AdminPanelProvider` during `website:install`
- `EnsureAppCssHasDarkVariantInstallStep` — ensures `@variant dark` and package source paths exist in the host `resources/css/app.css`
- `POST /logout` route for session termination from the dashboard navbar
- Context-aware sidebar footer on the dashboard layout
- Mobile sidebar with gradient brand header
- Meta description tag on the dashboard layout

### Changed

- Redesigned dashboard hub page to match account overview design language:
  - Uses `<x-account::page-header>` instead of `rounded-xl` cards
  - Section cards with left-border color indicators
  - Quick links as hover rows instead of rounded quick-link cards
  - Empty state component for unregistered widgets
- Dashboard layout aligned with account surface:
  - All `<x-filament::icon>` replaced with `<x-account::icon>`
  - Active sidebar left-border indicator consistent with account
  - Bottom bar via `@includeIf` for consistent rendering
- `Dashboard::getViewData()` now passes `navigationGroups` for quick links rendering

## [0.1.0] - 2026-03-31

### Added

- Shared dashboard shell with navbar, sidebar, and bottom-bar zone
- Hub page with widget-based overview and quick links
- Navigation registry for sidebar items
- User menu registry for dropdown extensions
- Dashboard extension registry for hub widgets
- Bottom-bar link registry for consumer packages
- Foundation-aligned package bootstrap through `DashboardPlatformPackage`
