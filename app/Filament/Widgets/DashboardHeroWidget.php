<?php

namespace App\Filament\Widgets;

use App\Models\HandWashLog;
use App\Models\Nurse;
use App\Models\Room;
use App\Models\Shift;
use Filament\Widgets\Widget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardHeroWidget extends Widget
{
    protected static bool $isLazy = false;

    protected static ?int $sort = 0;

    protected string $view = 'filament.widgets.dashboard-hero-widget';

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return Auth::check();
    }

    protected function getViewData(): array
    {
        $latestLog = HandWashLog::query()
            ->with(['nurse', 'room', 'shift'])
            ->orderByDesc('tanggal')
            ->orderByDesc('waktu')
            ->first();

        $latestActivityAt = null;

        if ($latestLog) {
            $latestActivityAt = Carbon::parse(
                $latestLog->tanggal->format('Y-m-d').' '.$latestLog->waktu,
            );
        }

        return [
            'activeNursesToday' => HandWashLog::query()
                ->whereDate('tanggal', today())
                ->distinct()
                ->count('nurse_id'),
            'latestActivityAt' => $latestActivityAt,
            'latestLog' => $latestLog,
            'nurseCount' => Nurse::count(),
            'recentCount' => HandWashLog::query()
                ->where('created_at', '>=', now()->subMinutes(10))
                ->count(),
            'roomCount' => Room::count(),
            'shiftCount' => Shift::count(),
            'todayCount' => HandWashLog::query()
                ->whereDate('tanggal', today())
                ->count(),
            'weekCount' => HandWashLog::query()
                ->whereBetween('tanggal', [
                    now()->startOfWeek()->toDateString(),
                    now()->endOfWeek()->toDateString(),
                ])
                ->count(),
        ];
    }
}
