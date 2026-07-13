<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DashboardHeroWidget;
use App\Filament\Widgets\HandWashChart;
use App\Filament\Widgets\PerawatCuciTanganWidget;
use App\Filament\Widgets\RecentHandWashActivityWidget;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Contracts\Support\Htmlable;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboard Cuci Tangan';

    protected static ?string $navigationLabel = 'Dashboard';

    public function getHeading(): string|Htmlable|null
    {
        return null;
    }

    public function getColumns(): int|array
    {
        return [
            'md' => 6,
            'xl' => 12,
        ];
    }

    public function getWidgets(): array
    {
        return [
            DashboardHeroWidget::class,
            HandWashChart::class,
            RecentHandWashActivityWidget::class,
            PerawatCuciTanganWidget::class,
        ];
    }

    public function getPageClasses(): array
    {
        return [
            'ct-dashboard-page',
        ];
    }
}
