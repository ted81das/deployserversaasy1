<?php

namespace App\Filament\Dashboard\Resources\DeployedServerResource\Pages;

use App\Filament\Dashboard\Resources\DeployedServerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Services\SSHConnectionService;
use Filament\Notifications\Notification;

class CreateDeployedServer extends CreateRecord
{
    protected static string $resource = DeployedServerResource::class;

 protected function afterCreate(): void
    {
        // Attempt SSH connection and update server status
        $success = SSHConnectionService::verifyConnection($this->record);

        if ($success) {
            Notification::make()
                ->title('Server Connected Successfully')
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('Failed to Connect to Server')
                ->danger()
                ->body('Could not establish SSH connection to the server.')
                ->send();
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }


}
