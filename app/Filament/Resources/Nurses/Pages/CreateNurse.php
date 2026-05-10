<?php

namespace App\Filament\Resources\Nurses\Pages;

use App\Filament\Resources\Nurses\NurseResource;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;

class CreateNurse extends CreateRecord
{
    protected static string $resource = NurseResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        /** @var User|null $user */
        $user = Filament::auth()->user();

        if ($user?->role === 'perawat') {
            $data['user_id'] = $user->id;
        }

        return $data;
    }
}
