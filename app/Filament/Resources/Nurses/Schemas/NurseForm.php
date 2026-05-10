<?php

namespace App\Filament\Resources\Nurses\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class NurseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('user_id')
                    ->default(fn () => Auth::id())
                    ->required(),

                TextInput::make('nama')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),

                TextInput::make('nip')
                    ->label('NIP')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

Select::make('jenis_kelamin')
    ->label('Jenis Kelamin')
    ->options([
        'L' => 'Laki-laki',
        'P' => 'Perempuan',
    ])
    ->required(),

                TextInput::make('no_hp')
                    ->label('No HP')
                    ->tel()
                    ->maxLength(255),

                Textarea::make('alamat')
                    ->label('Alamat')
                    ->columnSpanFull(),
            ]);
    }
}
