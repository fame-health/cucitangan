<?php

use App\Models\HandWashLog;
use App\Models\Room;
use App\Models\Shift;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public ?int $room_id = null;

    public ?int $shift_id = null;

    public array $rooms = [];

    public array $shifts = [];

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

        if (! empty($this->rooms)) {
            $this->room_id = (int) array_key_first($this->rooms);
        }

        if (! empty($this->shifts)) {
            $this->shift_id = (int) array_key_first($this->shifts);
        }
    }

    public function cuciTanganSekarang(): void
    {
        if (! $this->room_id || ! $this->shift_id) {
            Notification::make()
                ->title('Pilih ruangan dan shift terlebih dahulu')
                ->warning()
                ->send();

            return;
        }

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
};
?>

@php
    $user = auth()->user();
    $nurse = $user?->nurse;
    $tanggal = now()->format('d M Y');
    $waktu = now()->format('H:i');
@endphp

<div class="ct-page">
    <div class="ct-card">
                <div class="ct-right">
            <div class="ct-form">
                <span class="ct-badge">
                    Form Presensi
                </span>

                <h2>Konfirmasi Cuci Tangan</h2>

                <p>
                    Pilih ruangan dan shift sebelum menyimpan data.
                </p>

                <div class="ct-group">
                    <label>Ruangan</label>

                    <select wire:model="room_id">
                        <option value="">Pilih Ruangan</option>

                        @foreach ($rooms as $id => $nama)
                            <option value="{{ $id }}">
                                {{ $nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="ct-group">
                    <label>Shift</label>

                    <select wire:model="shift_id">
                        <option value="">Pilih Shift</option>

                        @foreach ($shifts as $id => $nama)
                            <option value="{{ $id }}">
                                {{ $nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button
                    type="button"
                    wire:click="cuciTanganSekarang"
                    wire:loading.attr="disabled"
                    class="ct-button"
                >
                    <span wire:loading.remove wire:target="cuciTanganSekarang">
                        Konfirmasi & Simpan
                    </span>

                    <span wire:loading wire:target="cuciTanganSekarang">
                        Menyimpan Data...
                    </span>
                </button>

                <div class="ct-secure">
                    Verified Hygiene Transaction
                </div>
            </div>
        </div>
        <div class="ct-left">
            <div class="ct-icon">
                🖐️
            </div>

            <h1>Presensi Kebersihan Tangan</h1>

            <p>
                Catat aktivitas cuci tangan perawat secara cepat dan otomatis.
            </p>

            <div class="ct-info">
                <div>
                    <span>Perawat</span>
                    <strong>{{ $nurse?->nama ?? '-' }}</strong>
                </div>

                <div>
                    <span>Tanggal</span>
                    <strong>{{ $tanggal }}</strong>
                </div>

                <div>
                    <span>Waktu</span>
                    <strong>{{ $waktu }}</strong>
                </div>
            </div>
        </div>


    </div>
</div>

<style>
    .ct-page {
        width: 100%;
        padding: 8px;
    }

    .ct-card {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        overflow: hidden;
        border-radius: 28px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        box-shadow: 0 24px 60px rgba(15, 23, 42, 0.08);
    }

    .ct-left {
        padding: 36px;
        background: linear-gradient(135deg, #fdf2f8, #ffffff);
        border-right: 1px solid #fbcfe8;
    }

    .ct-icon {
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 24px;
        background: linear-gradient(135deg, #ec4899, #be185d);
        font-size: 34px;
        margin-bottom: 24px;
        box-shadow: 0 18px 35px rgba(236, 72, 153, 0.3);
    }

    .ct-left h1 {
        max-width: 330px;
        font-size: 30px;
        line-height: 1.15;
        font-weight: 800;
        color: #111827;
        margin: 0;
    }

    .ct-left p {
        max-width: 320px;
        margin-top: 14px;
        font-size: 14px;
        line-height: 1.7;
        color: #6b7280;
    }

    .ct-info {
        display: grid;
        gap: 14px;
        margin-top: 36px;
    }

    .ct-info div {
        padding: 16px;
        border-radius: 18px;
        background: #ffffff;
        border: 1px solid #f3f4f6;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.04);
    }

    .ct-info span {
        display: block;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #9ca3af;
    }

    .ct-info strong {
        display: block;
        margin-top: 4px;
        font-size: 15px;
        color: #111827;
    }

    .ct-right {
        padding: 40px;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .ct-form {
        width: 100%;
        max-width: 460px;
    }

    .ct-badge {
        display: inline-block;
        padding: 7px 13px;
        border-radius: 999px;
        background: #fdf2f8;
        color: #db2777;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        margin-bottom: 16px;
    }

    .ct-form h2 {
        font-size: 27px;
        font-weight: 800;
        color: #111827;
        margin: 0;
    }

    .ct-form p {
        margin-top: 8px;
        margin-bottom: 26px;
        color: #6b7280;
        font-size: 14px;
        line-height: 1.7;
    }

    .ct-group {
        margin-bottom: 18px;
    }

    .ct-group label {
        display: block;
        margin-bottom: 8px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #9ca3af;
    }

    .ct-group select {
        width: 100%;
        padding: 14px 16px;
        border-radius: 16px;
        border: 1px solid #e5e7eb;
        background: #ffffff;
        color: #111827;
        font-size: 14px;
        font-weight: 700;
        outline: none;
        box-shadow: 0 6px 16px rgba(15, 23, 42, 0.04);
    }

    .ct-group select:focus {
        border-color: #ec4899;
        box-shadow: 0 0 0 4px rgba(236, 72, 153, 0.12);
    }

    .ct-button {
        width: 100%;
        margin-top: 8px;
        padding: 17px 20px;
        border: none;
        border-radius: 18px;
        background: linear-gradient(135deg, #ec4899, #be185d);
        color: #ffffff;
        font-size: 16px;
        font-weight: 800;
        cursor: pointer;
        box-shadow: 0 20px 35px rgba(236, 72, 153, 0.28);
        transition: 0.2s ease;
    }

    .ct-button:hover {
        transform: translateY(-1px);
        box-shadow: 0 24px 42px rgba(236, 72, 153, 0.34);
    }

    .ct-button:active {
        transform: scale(0.98);
    }

    .ct-button:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    .ct-secure {
        margin-top: 18px;
        text-align: center;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: #cbd5e1;
    }

    @media (max-width: 768px) {
        .ct-card {
            grid-template-columns: 1fr;
        }

        .ct-left {
            border-right: none;
            border-bottom: 1px solid #fbcfe8;
        }

        .ct-left,
        .ct-right {
            padding: 26px;
        }

        .ct-left h1 {
            font-size: 25px;
        }

        .ct-form h2 {
            font-size: 23px;
        }
    }
</style>
