<x-filament-widgets::widget class="ct-activity-widget" wire:poll.4s>
    <x-filament::section>
        <div class="ct-feed-header">
            <div>
                <span>Realtime</span>
                <h2>Aktivitas Terbaru</h2>
            </div>

            <div class="ct-feed-count">
                <strong>{{ number_format($recentCount) }}</strong>
                <span>10 menit</span>
            </div>
        </div>

        <div class="ct-feed-room">
            <span>Ruangan tersibuk</span>
            <strong>
                {{ $topRoom && $topRoom->hand_wash_logs_count > 0 ? $topRoom->nama_ruangan : 'Menunggu aktivitas' }}
            </strong>
        </div>

        <div class="ct-feed-list">
            @forelse ($logs as $log)
                <div class="ct-feed-item">
                    <div class="ct-feed-icon">
                        <x-filament::icon icon="heroicon-m-hand-raised" />
                    </div>

                    <div class="ct-feed-copy">
                        <strong>{{ $log->nurse?->nama ?? '-' }}</strong>
                        <span>{{ $log->room?->nama_ruangan ?? '-' }} - {{ $log->shift?->nama_shift ?? '-' }}</span>
                    </div>

                    <time>
                        {{ $log->tanggal?->format('d M') }}
                        <strong>{{ \Illuminate\Support\Carbon::parse($log->waktu)->format('H:i') }}</strong>
                    </time>
                </div>
            @empty
                <div class="ct-feed-empty">
                    <span class="ct-empty-dot"></span>
                    <strong>Belum ada aktivitas hari ini</strong>
                </div>
            @endforelse
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
