<?php

namespace App\Filament\Resources\HandWashLogs\Pages;

use App\Filament\Resources\HandWashLogs\HandWashLogResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHandWashLog extends EditRecord
{
    protected static string $resource = HandWashLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
