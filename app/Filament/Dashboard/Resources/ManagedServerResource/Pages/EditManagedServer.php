<?php

namespace App\Filament\Dashboard\Resources\ManagedServerResource\Pages;

use App\Filament\Dashboard\Resources\ManagedServerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditManagedServer extends EditRecord
{
    protected static string $resource = ManagedServerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
