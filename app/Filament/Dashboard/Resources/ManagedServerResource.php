<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\ManagedServerResource\Pages;
use App\Filament\Dashboard\Resources\ManagedServerResource\RelationManagers;
use App\Models\ManagedServer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
//use App\Filament\Dashboard\Resources\Table;

// app/Filament/Resources/ManagedServerResource.php
class ManagedServerResource extends Resource
{
    protected static ?string $model = ManagedServer::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Card::make()
                ->schema([
                    // Server Configuration Section
                    Forms\Components\Section::make('Server Configuration')
                        ->schema([
                            Forms\Components\TextInput::make('server_name')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(255),
 Forms\Components\TextInput::make('app_hostname')
                        ->required()
                        ->url()
                        ->maxLength(255),                                
                            Forms\Components\TextInput::make('application_name')
                                ->required()
                                ->maxLength(255),
                                
                            Forms\Components\Select::make('plan_type')
                                ->options([
                                    'vc2-1c-1gb' => '1GB RAM, 1 CPU',
                                    'vc2-2c-2gb' => '2GB RAM, 2 CPU',
                                    'vc2-4c-4gb' => '4GB RAM, 4 CPU',
                                ])
                                ->default('vc2-1c-1gb')
                                ->required(),
                        ])->columns(3),

                    // Database Configuration Section
                    Forms\Components\Section::make('Database Configuration (Optional)')
                        ->schema([
                            Forms\Components\TextInput::make('db_name')
                                ->helperText('Leave empty for auto-generation')
                                ->maxLength(255),
                                
                            Forms\Components\TextInput::make('db_password')
                                ->password()
                                ->helperText('Leave empty for auto-generation')
                                ->maxLength(255),
                        ])->columns(2),

                    // Application Details Section
                    Forms\Components\Section::make('Application Details')
                        ->schema([
                            Forms\Components\TextInput::make('app_hostname')
                                ->required()
                                ->url()
                                ->maxLength(255),
                                
                            Forms\Components\TextInput::make('app_miniadmin_username')
                                ->required()
                                ->maxLength(255),
                                
                            Forms\Components\TextInput::make('app_miniadmin_email')
                                ->required()
                                ->email()
                                ->maxLength(255),
                                
                            Forms\Components\TextInput::make('app_miniadmin_password')
                                ->required()
                                ->password()
                                ->maxLength(255),
                        ])->columns(2),
                ]),
        ]);
    }


 public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('server_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('application_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('app_hostname')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('ssh_status')
                    ->colors([
                        'danger' => 'failed',
                        'warning' => 'pending',
                        'success' => 'ready',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ]);
    }

 public static function getPages(): array
    {
        return [
            'index' => Pages\ListManagedServers::route('/'),
            'create' => Pages\CreateManagedServer::route('/create'),
            'edit' => Pages\EditManagedServer::route('/{record}/edit'),
            'view' => Pages\ViewManagedServer::route('/{record}'),
        ];
    }


}

