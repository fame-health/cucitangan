<?php

namespace App\Filament\Widgets;

use App\Models\HandWashLog;
use App\Models\Shift;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class HandWashChart extends ChartWidget
{
    protected static bool $isLazy = false;

    protected static ?int $sort = 3;

    protected ?string $heading = 'Aktivitas Cuci Tangan 7 Hari';

    protected ?string $description = 'Distribusi presensi berdasarkan shift.';

    protected ?string $pollingInterval = '5s';

    protected string $color = 'primary';

    protected ?string $maxHeight = '270px';

    protected int|string|array $columnSpan = [
        'md' => 6,
        'xl' => 8,
    ];

    public static function canView(): bool
    {
        return Auth::user()?->role === 'admin';
    }

    protected function getData(): array
    {
        $dates = collect(range(6, 0))->map(function ($day) {
            return Carbon::today()->subDays($day);
        });

        $shifts = Shift::orderBy('id')->get();

        $colors = [
            1 => ['#db2777', 'rgba(219, 39, 119, 0.18)'],
            2 => ['#0891b2', 'rgba(8, 145, 178, 0.16)'],
            3 => ['#059669', 'rgba(5, 150, 105, 0.16)'],
            4 => ['#7c3aed', 'rgba(124, 58, 237, 0.14)'],
            5 => ['#f59e0b', 'rgba(245, 158, 11, 0.16)'],
            6 => ['#e11d48', 'rgba(225, 29, 72, 0.14)'],
        ];

        if ($shifts->isEmpty()) {
            return [
                'datasets' => [
                    [
                        'label' => 'Belum ada shift',
                        'data' => array_fill(0, $dates->count(), 0),
                        'backgroundColor' => 'rgba(219, 39, 119, 0.12)',
                        'borderColor' => '#db2777',
                        'borderRadius' => 8,
                    ],
                ],
                'labels' => $dates->map(fn (Carbon $date): string => $date->format('d M'))->toArray(),
            ];
        }

        return [
            'datasets' => $shifts->map(function ($shift) use ($dates, $colors) {
                $color = $colors[$shift->id] ?? ['#64748b', 'rgba(100, 116, 139, 0.16)'];

                return [
                    'label' => $shift->nama_shift,
                    'data' => $dates->map(function ($date) use ($shift) {
                        return HandWashLog::whereDate('tanggal', $date)
                            ->where('shift_id', $shift->id)
                            ->count();
                    })->toArray(),
                    'backgroundColor' => $color[1],
                    'borderColor' => $color[0],
                    'borderRadius' => 8,
                    'borderWidth' => 1,
                    'hoverBackgroundColor' => $color[0],
                    'stack' => 'shift',
                ];
            })->toArray(),

            'labels' => $dates->map(fn (Carbon $date): string => $date->format('d M'))->toArray(),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'x' => [
                    'stacked' => true,
                    'grid' => [
                        'display' => false,
                    ],
                ],
                'y' => [
                    'stacked' => true,
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels' => [
                        'boxWidth' => 10,
                        'boxHeight' => 10,
                        'usePointStyle' => true,
                    ],
                ],
            ],
            'maintainAspectRatio' => false,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
