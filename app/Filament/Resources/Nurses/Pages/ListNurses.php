<?php

namespace App\Filament\Resources\Nurses\Pages;

use App\Filament\Resources\Nurses\NurseResource;
use App\Models\Nurse;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ListRecords;

class ListNurses extends ListRecords
{
    protected static string $resource = NurseResource::class;

    public function mount(): void
    {
        parent::mount();

        /** @var User|null $user */
        $user = Filament::auth()->user();

        if ($user?->role !== 'perawat') {
            return;
        }

        $nurse = Nurse::where('user_id', $user->id)->first();

        if (! $nurse) {
            $this->redirect(NurseResource::getUrl('create'));

            return;
        }

        $this->redirect(NurseResource::getUrl('edit', [
            'record' => $nurse->id,
        ]));
    }
}
