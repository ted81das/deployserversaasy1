<?php
// app/Jobs/MonitorServerProvisioningJob.php

namespace App\Jobs;

use App\Models\ManagedServer;
use App\Services\ServerAvatarService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;

class MonitorServerProvisioningJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ManagedServer $server;
    public $tries = 20;
    public $maxExceptions = 10;

    public function __construct(ManagedServer $server)
    {
        $this->server = $server;
    }

    public function handle(ServerAvatarService $serverAvatarService)
    {
        $status = $serverAvatarService->getServerStatus($this->server->serveravatar_id);


//dd($status);
        $this->server->update([
            'ssh_status' => $status['server']['ssh_status'],
            'agent_status' => $status['server']['agent_status'],
            'ip_address' => $status['server']['ip'] ?? null,
            'server_instance_id' => $status['server']['server_instance_id'],
            'vultr_instance_id' => $status['server']['instance_id'],
        ]);

//dd($status,$status['server']['ip']);
$countx = 0;
        if (($status['server']['ssh_status'] !== 'failed')|| ($status['server']['ip']==='8.8.8.8')) {
               Notification::make()
                    ->title('Server Provisioning Status')
                    ->body("Server {$this->server->server_name} is still being provisioned. Current status: {$status['server']['ssh_status']}")
                    ->info()
                    ->actions([
                        Action::make('view')
                            ->button()
                            ->url(route('filament.dashboard.resources.managed-servers.view', $this->server))
                    ]);

// dd($status,$status['ip']);
            $this->release(180); // Try again in 3 minutes
$countx = $countx +1; 
          return;
        }

  dd($status,$countx,$status['ip']);

      // Server is ready, proceed with database creation
        $dbName = $this->server->generateUniqueDatabaseName();
        $dbPassword = $this->server->generateUniqueDatabasePassword();

        $dbResponse = $serverAvatarService->createDatabase($this->server->serveravatar_id, [
            'name' => $dbName,
            'password' => $dbPassword,
        ]);

        $this->server->update([
            'db_name' => $dbName,
            'db_password' => $dbPassword,
        ]);

        // Create WOW application


// In your job or controller where you create the application

$appResponse = $serverAvatarService->createWpApplication($this->server->serveravatar_id, [
    'name' => $this->server->application_name . '_wp',
    'email' => 'oliveearrh@yahoo.com',
    'password' => 'newdelhi2021',
    'username' => 'olive83',
    'database_name' => 'wp_' . strtolower(Str::random(8)),
    'temp_sub_domain_name' => 'tmp' . strtolower(Str::random(8)),
    'system_username' => 'sys_' . strtolower(Str::random(12)),
    'system_password' => 'sys_' . Str::random(16)
]);


if (isset($appResponse['application'])) {
    $this->server->update([
        'wow_app_id' => $appResponse['application']['id'] ?? null,
        'application_url' => $appResponse['application']['url'] ?? null,
        'temp_domain' => $appResponse['application']['temp_domain'] ?? null,
    ]);
}

dd($appResponse);
/*        $appResponse = $serverAvatarService->createWpApplication($this->server->serveravatar_id, [
            'name' => $this->server->application_name . 'wow',
            'method' => 'git',
            'framework' => 'github',
            'hostname' => $this->server->app_hostname,
            'systemUser' => 'new',
            'php_version' => '8.1',
            'webroot' => '',
            'www' => false,
            // ... other application parameters
        ]);*/

        // Update application details
        $this->server->wowApp()->create([
            'application_name' => $this->server->application_name . 'wow',
            'app_hostname' => $this->server->app_hostname,
            'app_miniadmin_username' => $this->server->app_miniadmin_username,
            // ... other fields
        ]);
    }
}
