<?php

namespace App\Filament\Dashboard\Resources\ManagedServerResource\Pages;

use App\Filament\Dashboard\Resources\ManagedServerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListManagedServers extends ListRecords
{
    protected static string $resource = ManagedServerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
