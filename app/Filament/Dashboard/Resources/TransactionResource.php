<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\TransactionResource\Pages;
use App\Mapper\TransactionStatusMapper;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('amount')->formatStateUsing(function (string $state, $record) {
                    return money($state, $record->currency->code);
                }),
                Tables\Columns\TextColumn::make('status')
                    ->formatStateUsing(fn (string $state, TransactionStatusMapper $mapper): string => $mapper->mapForDisplay($state)),
                Tables\Columns\TextColumn::make('subscription_id')->formatStateUsing(function (string $state, $record) {
                        return $record->subscription->plan->name;
                    })
                    ->label(_('Subscription Plan')),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(_('Date'))
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListTransactions::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function canUpdate(Model $record): bool
    {
        return false;
    }

    public static function canUpdateAny(): bool
    {
        return false;
    }

    public static function canViewAny(): bool
    {
        return true;  // we want to ignore the default permission check (from the policy) and allow all users to view their own transactions
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->user()->id)->where('amount' , '>', 0);
    }

    public static function getModelLabel(): string
    {
        return _('Payments');
    }
}
