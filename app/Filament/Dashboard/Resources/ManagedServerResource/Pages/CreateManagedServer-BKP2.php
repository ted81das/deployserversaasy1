<?php

// app/Filament/Resources/ManagedServerResource/Pages/CreateManagedServer.php

namespace App\Filament\Resources\ManagedServerResource\Pages;

use App\Filament\Resources\ManagedServerResource;
use Filament\Resources\Pages\CreateRecord;
use App\Services\ServerAvatarService;
use App\Jobs\MonitorServerProvisioningJob;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class CreateManagedServer extends CreateRecord
{
    protected static string $resource = ManagedServerResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Generate missing values
        if (empty($data['db_name'])) {
            $data['db_name'] = $this->getModel()::generateUniqueDatabaseName();
        }
        
        if (empty($data['db_password'])) {
            $data['db_password'] = $this->getModel()::generateUniqueDatabasePassword();
        }

        // Generate system user and password
        $data['application_user'] = $this->getModel()::generateUniqueApplicationUser();
        $data['system_password'] = $this->getModel()::generateSecurePassword();

        // Default values are handled by migration defaults
        
        return $data;
    }

    protected function afterCreate(): void
    {
        DB::beginTransaction();
        try {
            $server = $this->record;
            $serverAvatarService = app(ServerAvatarService::class);

            $response = $serverAvatarService->createServer([
                'name' => $server->server_name,
                'provider' => $server->provider,
                'cloud_server_provider_id' => $server->cloud_server_provider_id,
                'version' => $server->version,
                'region' => $server->region,
                'sizeSlug' => $server->size_slug,
                'ssh_key' => $server->ssh_key,
                'public_key' => $server->public_key,
                'web_server' => $server->web_server,
                'database_type' => $server->database_type,
            ]);

            $server->update([
                'serveravatar_id' => $response['server']['id'],
                'ssh_status' => $response['server']['ssh_status'],
                'agent_status' => $response['server']['agent_status'],
            ]);

            DB::commit();

            // Dispatch monitoring job
            MonitorServerProvisioningJob::dispatch($server);

            Notification::make()
                ->title('Server creation initiated')
                ->success()
                ->send();

        } catch (\Exception $e) {
            DB::rollBack();
            Notification::make()
                ->title('Server creation failed')
                ->danger()
                ->send();
            throw $e;
        }
    }
}
