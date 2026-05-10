<?php

namespace App\Filament\Resources\HandWashLogs\Pages;

use App\Filament\Resources\HandWashLogs\HandWashLogResource;
use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ListRecords;

class ListHandWashLogs extends ListRecords
{
    protected static string $resource = HandWashLogResource::class;

    protected function getHeaderActions(): array
    {
        /** @var User|null $user */
        $user = Filament::auth()->user();

        return [
            CreateAction::make()
                ->visible($user?->role === 'admin'),
        ];
    }
}
