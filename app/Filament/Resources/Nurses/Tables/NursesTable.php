<?php

namespace App\Filament\Resources\Nurses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class NursesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('user.name')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('nip')
                    ->label('NIP')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('NIP berhasil disalin'),

                TextColumn::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                        default => '-',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'L', 'Laki-laki' => 'info',
                        'P', 'Perempuan' => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('no_hp')
                    ->label('Nomor WhatsApp')
                    ->searchable()
                    ->formatStateUsing(fn (?string $state): string => $state ? '0' . ltrim($state, '0') : '-')
                    ->url(fn ($record) => 'https://wa.me/' . preg_replace('/^0/', '62', $record->no_hp))
                    ->openUrlInNewTab(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diupdate')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                //
            ])

            ->recordActions([
                EditAction::make()
                    ->label('Edit'),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ])
                    ->visible(fn (): bool =>
                        Filament::auth()->user()?->role === 'admin'
                    ),
            ])

            ->defaultSort('created_at', 'desc')

            ->striped();
    }
}
