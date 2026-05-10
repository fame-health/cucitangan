<?php

namespace App\Filament\Widgets;

use App\Models\HandWashLog;
use App\Models\Nurse;
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
            Stat::make('Total Perawat', Nurse::count())
                ->description('Semua data perawat')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Perawat Laki-laki', Nurse::where('jenis_kelamin', 'L')->count())
                ->description('Jumlah perawat laki-laki')
                ->descriptionIcon('heroicon-m-user')
                ->color('info'),

            Stat::make('Perawat Perempuan', Nurse::where('jenis_kelamin', 'P')->count())
                ->description('Jumlah perawat perempuan')
                ->descriptionIcon('heroicon-m-user')
                ->color('success'),

            Stat::make('Cuci Tangan Hari Ini', HandWashLog::whereDate('tanggal', today())->count())
                ->description('Total aktivitas hari ini')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('warning'),

            Stat::make('Cuci Tangan Minggu Ini', HandWashLog::whereBetween('tanggal', [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ])->count())
                ->description('Total aktivitas minggu ini')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->color('info'),

            Stat::make('Total Cuci Tangan', HandWashLog::count())
                ->description('Semua aktivitas tercatat')
                ->descriptionIcon('heroicon-m-hand-raised')
                ->color('success'),
        ];
    }
}
