<?php

namespace App\Filament\Resources\HandWashLogs;

use App\Filament\Resources\HandWashLogs\Pages\CreateHandWashLog;
use App\Filament\Resources\HandWashLogs\Pages\EditHandWashLog;
use App\Filament\Resources\HandWashLogs\Pages\ListHandWashLogs;
use App\Filament\Resources\HandWashLogs\Schemas\HandWashLogForm;
use App\Filament\Resources\HandWashLogs\Tables\HandWashLogsTable;
use App\Models\HandWashLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

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
