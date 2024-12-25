<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\ManagedServerAppWowResource\Pages;
use App\Filament\Dashboard\Resources\ManagedServerAppWowResource\RelationManagers;
use App\Models\ManagedServerAppWow;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ManagedServerAppWowResource extends Resource
{
    protected static ?string $model = ManagedServerAppWow::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListManagedServerAppWows::route('/'),
            'create' => Pages\CreateManagedServerAppWow::route('/create'),
            'view' => Pages\ViewManagedServerAppWow::route('/{record}'),
            'edit' => Pages\EditManagedServerAppWow::route('/{record}/edit'),
        ];
    }
}
