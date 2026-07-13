<?php

namespace App\Filament\Widgets;

use App\Models\HandWashLog;
use App\Models\Nurse;
use App\Models\Room;
use App\Models\Shift;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class HandWashStats extends StatsOverviewWidget
{
    protected static bool $isLazy = false;

    protected static ?int $sort = 2;

    protected ?string $pollingInterval = '3s';

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return Auth::user()?->role === 'admin';
    }

    protected function getColumns(): int
    {
        return 3;
    }

    protected function getStats(): array
    {
        $dailyCounts = $this->dailyHandWashCounts();
        $activeNursesToday = HandWashLog::query()
            ->whereDate('tanggal', today())
            ->distinct()
            ->count('nurse_id');

        return [
            Stat::make('Total Perawat', number_format(Nurse::count()))
                ->description(number_format($activeNursesToday).' aktif hari ini')
                ->descriptionIcon('heroicon-m-users')
                ->chart($this->dailyActiveNurseCounts())
                ->color('primary'),

            Stat::make('Ruangan & Shift', number_format(Room::count()).' / '.number_format(Shift::count()))
                ->description('Master area presensi')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->chart($dailyCounts)
                ->color('info'),

            Stat::make('Aktif 10 Menit', number_format(
                HandWashLog::query()
                    ->where('created_at', '>=', now()->subMinutes(10))
                    ->count(),
            ))
                ->description('Sinyal aktivitas terbaru')
                ->descriptionIcon('heroicon-m-signal')
                ->chart($dailyCounts)
                ->color('success'),

            Stat::make('Cuci Tangan Hari Ini', number_format(HandWashLog::whereDate('tanggal', today())->count()))
                ->description('Total presensi harian')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->chart($dailyCounts)
                ->color('primary'),

            Stat::make('Cuci Tangan Minggu Ini', number_format(HandWashLog::whereBetween('tanggal', [
                now()->startOfWeek()->toDateString(),
                now()->endOfWeek()->toDateString(),
            ])->count()))
                ->description('Akumulasi pekan berjalan')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->chart($dailyCounts)
                ->color('info'),

            Stat::make('Total Cuci Tangan', number_format(HandWashLog::count()))
                ->description('Semua presensi tercatat')
                ->descriptionIcon('heroicon-m-hand-raised')
                ->chart($dailyCounts)
                ->color('success'),
        ];
    }

    protected function dailyHandWashCounts(): array
    {
        return collect(range(6, 0))
            ->map(fn (int $day): int => HandWashLog::query()
                ->whereDate('tanggal', Carbon::today()->subDays($day))
                ->count())
            ->toArray();
    }

    protected function dailyActiveNurseCounts(): array
    {
        return collect(range(6, 0))
            ->map(fn (int $day): int => HandWashLog::query()
                ->whereDate('tanggal', Carbon::today()->subDays($day))
                ->distinct()
                ->count('nurse_id'))
            ->toArray();
    }
}
