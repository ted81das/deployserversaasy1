<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\DeployedServerResource\Pages;
use App\Filament\Dashboard\Resources\DeployedServerResource\RelationManagers;
use App\Models\DeployedServer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextArea;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeployedServerResource extends Resource
{
    protected static ?string $model = DeployedServer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
       return $form->schema([
            TextInput::make('server_ip')
                ->label('Server IP')
                ->required()
                ->placeholder('Enter server IP address')
                ->columnSpan(2),

            TextInput::make('owner_email')
                ->label('Owner Email')
                ->email()
                ->required()
                ->columnSpan(2),

            TextInput::make('hostname')
                ->label('Hostname')
                ->disabled(fn ($context) => $context === 'edit')
                ->dehydrated(false)
                ->columnSpan(2),

            TextInput::make('operating_system')
                ->label('Operating System')
                ->disabled()
                ->dehydrated(false)
                ->visible(fn ($context) => $context === 'edit')
                ->columnSpan(2),

            Select::make('server_status')
                ->options([
                    'pending' => 'Pending',
                    'success' => 'Success',
                    'failed' => 'Failed',
                ])
                ->disabled()
                ->dehydrated(false)
                ->visible(fn ($context) => $context === 'edit')
                ->columnSpan(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
       ->columns([
                TextColumn::make('server_ip')
                    ->label('Server IP')
                    ->searchable(),
                TextColumn::make('owner_email')
                    ->label('Owner Email')
                    ->searchable(),
                TextColumn::make('hostname')
                    ->label('Hostname'),
                TextColumn::make('operating_system')
                    ->label('OS'),
                TextColumn::make('server_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'success' => 'success',
                        'failed' => 'danger',
                        default => 'warning',
                    }),
            ])            
            ->filters([
                //
     
//Tables\Actions\Action::make('Manage Server')
  //                  ->url(fn (DeployedServer $record) => route('filament.resources.deployed-servers.manage', $record)),
           
          ])
            ->actions([
//             Tables\Actions\Action::make('Manage Server')
  //                  ->url(fn (DeployedServer $record) => route('filament.resources.deployed-servers.manage', $record)),    
            Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
Tables\Actions\Action::make('manage')
                ->url(fn (DeployedServer $record): string => 
                    static::getUrl('manage', ['record' => $record]))
                ->icon('heroicon-o-cog')
                ->label('Manage'),    


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
            'index' => Pages\ListDeployedServers::route('/'),
            'create' => Pages\CreateDeployedServer::route('/create'),
            'view' => Pages\ViewDeployedServer::route('/{record}'),
            'edit' => Pages\EditDeployedServer::route('/{record}/edit'),
           'manage' => Pages\ManageServers::route('/{record}/manage'),
        ];
    }
}
