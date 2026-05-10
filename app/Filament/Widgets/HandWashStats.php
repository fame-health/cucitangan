<?php

namespace App\Filament\Widgets;

use App\Models\HandWashLog;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class HandWashStats extends StatsOverviewWidget
{
    protected int | string | array $columnSpan = 1;

    public static function canView(): bool
    {
        return Auth::user()?->role === 'admin';
    }

    protected function getColumns(): int
    {
        return 2;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Cuci Tangan Hari Ini', HandWashLog::whereDate('tanggal', today())->count()),

            Stat::make('Cuci Tangan Minggu Ini', HandWashLog::whereBetween('tanggal', [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ])->count()),

            Stat::make('Cuci Tangan Bulan Ini', HandWashLog::whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->count()),

            Stat::make('Total Cuci Tangan', HandWashLog::count()),
        ];
    }
}
