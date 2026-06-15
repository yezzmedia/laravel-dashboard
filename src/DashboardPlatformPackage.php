<?php

declare(strict_types=1);

namespace YezzMedia\Dashboard;

use YezzMedia\Foundation\Contracts\DefinesAuditEvents;
use YezzMedia\Foundation\Contracts\DefinesPermissions;
use YezzMedia\Foundation\Contracts\PlatformPackage;
use YezzMedia\Foundation\Contracts\RegistersFeatures;
use YezzMedia\Foundation\Data\AuditEventDefinition;
use YezzMedia\Foundation\Data\FeatureDefinition;
use YezzMedia\Foundation\Data\PackageMetadata;
use YezzMedia\Foundation\Data\PermissionDefinition;

final class DashboardPlatformPackage implements DefinesAuditEvents, DefinesPermissions, PlatformPackage, RegistersFeatures
{
    public function metadata(): PackageMetadata
    {
        return new PackageMetadata(
            name: 'yezzmedia/laravel-dashboard',
            vendor: 'yezzmedia',
            description: 'Dashboard shell for the Yezz Media Laravel website platform.',
            packageClass: self::class,
        );
    }

    /**
     * @return array<int, PermissionDefinition>
     */
    public function permissionDefinitions(): array
    {
        return [
            new PermissionDefinition(
                name: 'dashboard.access',
                package: 'yezzmedia/laravel-dashboard',
                label: 'Access dashboard',
                description: 'Can access the dashboard hub.',
            ),
            new PermissionDefinition(
                name: 'dashboard.manage',
                package: 'yezzmedia/laravel-dashboard',
                label: 'Manage dashboard',
                description: 'Can manage dashboard settings and configuration.',
            ),
        ];
    }

    /**
     * @return array<int, FeatureDefinition>
     */
    public function featureDefinitions(): array
    {
        return [
            new FeatureDefinition(
                name: 'dashboard.hub',
                package: 'yezzmedia/laravel-dashboard',
                label: 'Dashboard hub',
                description: 'Provides the dashboard hub shell with navigation, sidebar, and shared layout.',
            ),
        ];
    }

    /**
     * @return array<int, AuditEventDefinition>
     */
    public function auditEventDefinitions(): array
    {
        return [
            new AuditEventDefinition(
                key: 'dashboard.page_visited',
                package: 'yezzmedia/laravel-dashboard',
                action: 'visited',
                subjectType: 'dashboard_page',
                description: 'A dashboard hub page was visited.',
                severity: 'info',
                contextKeys: ['page', 'user_id', 'ip'],
            ),
            new AuditEventDefinition(
                key: 'dashboard.navigation_navigated',
                package: 'yezzmedia/laravel-dashboard',
                action: 'navigated',
                subjectType: 'dashboard_navigation',
                description: 'A navigation item in the dashboard hub was clicked.',
                severity: 'info',
                contextKeys: ['item_label', 'item_url', 'user_id'],
            ),
        ];
    }
}
