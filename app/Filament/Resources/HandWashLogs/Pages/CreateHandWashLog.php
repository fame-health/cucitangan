<?php

namespace App\Filament\Resources\HandWashLogs\Pages;

use App\Filament\Resources\HandWashLogs\HandWashLogResource;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;

class CreateHandWashLog extends CreateRecord
{
    protected static string $resource = HandWashLogResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Filament::auth()->user();

        if ($user?->nurse) {
            $data['nurse_id'] = $user->nurse->id;
        }

        return $data;
    }
}
