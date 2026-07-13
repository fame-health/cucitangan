<?php

namespace App\Filament\Resources\Nurses;

use App\Filament\Resources\Nurses\Pages\CreateNurse;
use App\Filament\Resources\Nurses\Pages\EditNurse;
use App\Filament\Resources\Nurses\Pages\ListNurses;
use App\Filament\Resources\Nurses\Schemas\NurseForm;
use App\Filament\Resources\Nurses\Tables\NursesTable;
use App\Models\Nurse;
use App\Models\User;
use BackedEnum;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class NurseResource extends Resource
{
    protected static ?string $model = Nurse::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $navigationLabel = 'Perawat';

    protected static ?string $modelLabel = 'Perawat';

    protected static ?string $pluralModelLabel = 'Perawat';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return NurseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NursesTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        /** @var User|null $user */
        $user = Filament::auth()->user();

        if ($user?->role === 'admin') {
            return $query;
        }

        return $query->where('user_id', $user?->id);
    }

    public static function canCreate(): bool
    {
        /** @var User|null $user */
        $user = Filament::auth()->user();

        if ($user?->role === 'admin') {
            return true;
        }

        return ! Nurse::where('user_id', $user?->id)->exists();
    }

    public static function canEdit(Model $record): bool
    {
        /** @var User|null $user */
        $user = Filament::auth()->user();

        return $user?->role === 'admin'
            || $record->user_id === $user?->id;
    }

    public static function canDelete(Model $record): bool
    {
        /** @var User|null $user */
        $user = Filament::auth()->user();

        return $user?->role === 'admin';
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNurses::route('/'),
            'create' => CreateNurse::route('/create'),
            'edit' => EditNurse::route('/{record}/edit'),
        ];
    }
}
