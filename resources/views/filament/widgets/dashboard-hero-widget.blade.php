@php
    $user = auth()->user();
    $isAdmin = $user?->role === 'admin';
    $title = $isAdmin ? 'Monitoring realtime' : 'Presensi Cuci Tangan';
    $subtitle = $isAdmin
        ? 'Monitoring aktivitas cuci tangan perawat hari ini.'
        : 'Catat dan pantau aktivitas cuci tangan Anda.';
@endphp

<x-filament-widgets::widget class="ct-dashboard-hero" wire:poll.4s>
    <section class="ct-hero-shell">
        <div class="ct-hero-top">
            <div class="ct-hero-title">
                <div class="ct-live-row">
                    <span class="ct-live-dot"></span>
                    <span>Live</span>
                </div>

                <div class="ct-hero-copy">
                    <h2>{{ $title }}</h2>
                    <p>{{ $subtitle }}</p>
                </div>
            </div>

            <div class="ct-hero-status">
                <div class="ct-clock">
                    <span>{{ now()->translatedFormat('d M Y') }}</span>
                    <strong>{{ now()->format('H:i:s') }}</strong>
                </div>

                <div class="ct-last-activity">
                    <span>Terakhir</span>
                    <strong>
                        @if ($latestLog)
                            {{ $latestLog->nurse?->nama ?? '-' }}
                            <small>{{ $latestActivityAt?->format('H:i') }} - {{ $latestLog->room?->nama_ruangan ?? '-' }}</small>
                        @else
                            Belum ada aktivitas
                            <small>Menunggu data masuk</small>
                        @endif
                    </strong>
                </div>
            </div>
        </div>

        <div class="ct-kpi-grid">
            <div class="ct-kpi-item">
                <span>Hari Ini</span>
                <strong>{{ number_format($todayCount) }}</strong>
            </div>

            <div class="ct-kpi-item">
                <span>Minggu Ini</span>
                <strong>{{ number_format($weekCount) }}</strong>
            </div>

            <div class="ct-kpi-item">
                <span>Aktif 10 Menit</span>
                <strong>{{ number_format($recentCount) }}</strong>
            </div>

            <div class="ct-kpi-item">
                <span>Perawat</span>
                <strong>{{ number_format($nurseCount) }}</strong>
            </div>

            <div class="ct-kpi-item">
                <span>Ruangan</span>
                <strong>{{ number_format($roomCount) }}</strong>
            </div>

            <div class="ct-kpi-item">
                <span>Shift</span>
                <strong>{{ number_format($shiftCount) }}</strong>
            </div>
        </div>
    </section>
</x-filament-widgets::widget>
