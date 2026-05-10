<?php

namespace App\Filament\Resources\HandWashLogs\Pages;

use App\Filament\Resources\HandWashLogs\HandWashLogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHandWashLogs extends ListRecords
{
    protected static string $resource = HandWashLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
