<?php

namespace App\Filament\Resources\HandWashLogs\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class HandWashLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('nurse_id')
                    ->label('Perawat')
                    ->relationship('nurse', 'nama')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->visible(fn () => Auth::user()?->role === 'admin')
                    ->dehydrated(fn () => Auth::user()?->role === 'admin'),

                Hidden::make('nurse_id')
                    ->default(fn () => Auth::user()?->nurse?->id)
                    ->required()
                    ->visible(fn () => Auth::user()?->role === 'perawat')
                    ->dehydrated(fn () => Auth::user()?->role === 'perawat'),

                TextInput::make('nama_perawat')
                    ->label('Perawat')
                    ->default(fn () => Auth::user()?->nurse?->nama)
                    ->disabled()
                    ->dehydrated(false)
                    ->visible(fn () => Auth::user()?->role === 'perawat'),

                Select::make('room_id')
                    ->label('Ruangan')
                    ->relationship('room', 'nama_ruangan')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('shift_id')
                    ->label('Shift')
                    ->relationship('shift', 'nama_shift')
                    ->searchable()
                    ->preload()
                    ->required(),

                DatePicker::make('tanggal')
                    ->label('Tanggal')
                    ->default(fn () => now('Asia/Jakarta')->format('Y-m-d'))
                    ->required(),

                TimePicker::make('waktu')
                    ->label('Waktu')
                    ->default(fn () => now('Asia/Jakarta')->format('H:i:s'))
                    ->seconds()
                    ->required(),
            ]);
    }
}
