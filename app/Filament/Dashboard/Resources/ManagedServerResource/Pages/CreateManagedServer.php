<?php

namespace App\Filament\Dashboard\Resources\ManagedServerResource\Pages;

use App\Filament\Dashboard\Resources\ManagedServerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Services\ServerAvatarService;
use App\Jobs\MonitorServerProvisioningJob;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
//use App\Services\ServerAvatarService;

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
        
        // Set server configuration defaults
        $data['provider'] = 'vultr';
        $data['cloud_server_provider_id'] = 3077;
        $data['version'] = '20';
        $data['region'] = 'atl';
        $data['availability_zone'] = 'us-east-1a';
        $data['size_slug'] = $data['plan_type'] ?? 'vc2-1c-1gb';
        $data['ssh_key'] = true;
        $data['web_server'] = 'apache2';
        $data['database_type'] = 'mysql';
        $data['server_uuid'] = (string) Str::uuid();

        // Ensure required fields are set
        if (empty($data['app_hostname'])) {
            $data['app_hostname'] = $data['server_name'] . '.example.com'; // Default domain
        }

        if (empty($data['app_miniadmin_username'])) {
            $data['app_miniadmin_username'] = 'admin_' . Str::random(8);
        }

        if (empty($data['app_miniadmin_email'])) {
            $data['app_miniadmin_email'] = 'admin@' . parse_url($data['app_hostname'], PHP_URL_HOST);
        }

        if (empty($data['app_miniadmin_password'])) {
            $data['app_miniadmin_password'] = Str::random(12);
        }

        return $data;
    }


protected function afterCreate(): void
{
    DB::beginTransaction();
    try {
        $server = $this->record;
        $serverAvatarService = new ServerAvatarService();

        $response = $serverAvatarService->createServer([
            'name' => $server->server_name,
            'provider' => 'vultr',
            'cloud_server_provider_id' => 3077,
            'version' => 20,
            'region' => 'atl',
            'availabilityZone' => 'us-east-1a',
            'sizeSlug' => $server->plan_type ?? 'vc2-1c-1gb',
            'ssh_key' => true,
            'public_key' => "ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQCEzZ2087B8dNmxfXPTPbP0Gmby15wT1OmXShLJHV/yeEcpS29OBZKt1tmgO2ZteLvAEnMmaYA2rCDVWu3ux+OAWftaLb+FIY1wJsB33HKsq5A9IOTetlWNOba41R+0XI8Y7SOhvtZIbkfPjmsrPhtFZb2khkNuDutGHmj+GZP6lYjwAYmFCdthUB+wlM31QwNsmiQszX4s89LVWkXfqX52SDTBrzauuoH3ve1+A1AocZIqKPAJkYitG67HfLbxMO0vpumCySA3awUpzIP1ZZL6128kqKhx1T/C9qbex/Y0m0Iv2roNhaJI96phT9EsoXiMbUcO5hK+n4wVylgPjtSl oliveearth@yahoo.com",
            'web_server' => 'apache2',
            'database_type' => 'mysql',
            'linode_root_password' => 'Newdelhi@202!2024',
            'nodejs' => false
        ]);

        if (isset($response['server'])) {
            $server->update([
                'serveravatar_id' => $response['server']['id'],
                'ssh_status' => $response['server']['ssh_status'] ?? null,
                'agent_status' => $response['server']['agent_status'] ?? null,
                'server_instance_id' => $response['server']['server_instance_id'],
                'vultr_instance_id' => $response['server']['instance_id'],
                'ip_address' => $response['server']['ip'] ?? null,
            ]);
        }

        DB::commit();

        MonitorServerProvisioningJob::dispatch($server);

        Notification::make()
            ->title('Server creation initiated')
            ->success()
            ->send();

    } catch (\Exception $e) {
        DB::rollBack();

        Log::error('Server creation failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        Notification::make()
            ->title('Server creation failed')
            ->body($e->getMessage())
            ->danger()
            ->send();
    }
}

//this was replace dwith above

   /* protected function afterCreate(): void
    {
        DB::beginTransaction();
        try {
            $server = $this->record;
//            $serverAvatarService = app(ServerAvatarService::class);
   $serverAvatarService = app(\App\Services\ServerAvatarService::class);
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
    }*/
}
