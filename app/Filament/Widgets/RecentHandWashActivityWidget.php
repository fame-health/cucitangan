<?php

namespace App\Filament\Widgets;

use App\Models\HandWashLog;
use App\Models\Room;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class RecentHandWashActivityWidget extends Widget
{
    protected static bool $isLazy = false;

    protected static ?int $sort = 4;

    protected string $view = 'filament.widgets.recent-hand-wash-activity-widget';

    protected int|string|array $columnSpan = [
        'md' => 6,
        'xl' => 4,
    ];

    public static function canView(): bool
    {
        return Auth::user()?->role === 'admin';
    }

    protected function getViewData(): array
    {
        $topRoom = Room::query()
            ->withCount([
                'handWashLogs' => fn ($query) => $query->whereDate('tanggal', today()),
            ])
            ->orderByDesc('hand_wash_logs_count')
            ->first();

        return [
            'logs' => HandWashLog::query()
                ->with(['nurse', 'room', 'shift'])
                ->orderByDesc('tanggal')
                ->orderByDesc('waktu')
                ->limit(8)
                ->get(),
            'recentCount' => HandWashLog::query()
                ->where('created_at', '>=', now()->subMinutes(10))
                ->count(),
            'topRoom' => $topRoom,
        ];
    }
}
