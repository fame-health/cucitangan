<?php

namespace App\Filament\Widgets;

use App\Models\HandWashLog;
use App\Models\Shift;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class HandWashChart extends ChartWidget
{
    protected ?string $heading = 'Diagram Cuci Tangan Berdasarkan Shift 7 Hari Terakhir';

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
            1 => 'rgba(255, 99, 132, 0.8)',
            2 => 'rgba(54, 162, 235, 0.8)',
            3 => 'rgba(255, 206, 86, 0.8)',
            4 => 'rgba(75, 192, 192, 0.8)',
            5 => 'rgba(153, 102, 255, 0.8)',
            6 => 'rgba(255, 159, 64, 0.8)',
        ];

        return [
            'datasets' => $shifts->map(function ($shift) use ($dates, $colors) {
                return [
                    'label' => $shift->nama_shift,
                    'data' => $dates->map(function ($date) use ($shift) {
                        return HandWashLog::whereDate('tanggal', $date)
                            ->where('shift_id', $shift->id)
                            ->count();
                    })->toArray(),
                    'backgroundColor' => $colors[$shift->id] ?? 'rgba(201, 203, 207, 0.8)',
                    'borderColor' => '#ffffff',
                    'borderWidth' => 2,
                    'stack' => 'shift',
                ];
            })->toArray(),

            'labels' => $dates->map(function ($date) {
                return $date->format('d M');
            })->toArray(),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'x' => [
                    'stacked' => true,
                ],
                'y' => [
                    'stacked' => true,
                    'beginAtZero' => true,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
