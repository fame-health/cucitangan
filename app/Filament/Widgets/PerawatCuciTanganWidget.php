<?php

namespace App\Filament\Widgets;

use App\Models\HandWashLog;
use App\Models\Room;
use App\Models\Shift;
use Filament\Notifications\Notification;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class PerawatCuciTanganWidget extends Widget
{
    protected string $view = 'filament.widgets.perawat-cuci-tangan-widget';

    protected int | string | array $columnSpan = 'full';

    public ?int $room_id = null;

    public ?int $shift_id = null;

    public array $rooms = [];

    public array $shifts = [];

    public static function canView(): bool
    {
        return Auth::user()?->role === 'perawat';
    }

    public function mount(): void
    {
        $this->rooms = Room::query()
            ->orderBy('nama_ruangan')
            ->pluck('nama_ruangan', 'id')
            ->toArray();

        $this->shifts = Shift::query()
            ->orderBy('id')
            ->pluck('nama_shift', 'id')
            ->toArray();

        $this->room_id = array_key_first($this->rooms);
        $this->shift_id = array_key_first($this->shifts);
    }

    public function cuciTanganSekarang(): void
    {
        $nurse = Auth::user()?->nurse;

        if (! $nurse) {
            Notification::make()
                ->title('Data perawat belum terhubung')
                ->danger()
                ->send();

            return;
        }

        HandWashLog::create([
            'nurse_id' => $nurse->id,
            'room_id' => $this->room_id,
            'shift_id' => $this->shift_id,
            'tanggal' => now()->format('Y-m-d'),
            'waktu' => now()->format('H:i:s'),
        ]);

        Notification::make()
            ->title('Cuci tangan berhasil dicatat')
            ->success()
            ->send();
    }
}
