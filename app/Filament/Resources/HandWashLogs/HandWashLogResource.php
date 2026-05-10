<?php

namespace App\Filament\Resources\HandWashLogs;

use App\Filament\Resources\HandWashLogs\Pages\CreateHandWashLog;
use App\Filament\Resources\HandWashLogs\Pages\EditHandWashLog;
use App\Filament\Resources\HandWashLogs\Pages\ListHandWashLogs;
use App\Filament\Resources\HandWashLogs\Schemas\HandWashLogForm;
use App\Filament\Resources\HandWashLogs\Tables\HandWashLogsTable;
use App\Models\HandWashLog;
use App\Models\User;
use BackedEnum;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class HandWashLogResource extends Resource
{
    protected static ?string $model = HandWashLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'handwashlog';

    public static function form(Schema $schema): Schema
    {
        return HandWashLogForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HandWashLogsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        /** @var User|null $user */
        $user = Filament::auth()->user();

        if ($user?->role === 'admin') {
            return $query;
        }

        return $query->where('nurse_id', $user?->nurse?->id);
    }

    public static function canEdit(Model $record): bool
    {
        /** @var User|null $user */
        $user = Filament::auth()->user();

        return $user?->role === 'admin'
            || $record->nurse_id === $user?->nurse?->id;
    }

    public static function canDelete(Model $record): bool
    {
        /** @var User|null $user */
        $user = Filament::auth()->user();

        return $user?->role === 'admin';
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHandWashLogs::route('/'),
            'create' => CreateHandWashLog::route('/create'),
            'edit' => EditHandWashLog::route('/{record}/edit'),
        ];
    }
}
