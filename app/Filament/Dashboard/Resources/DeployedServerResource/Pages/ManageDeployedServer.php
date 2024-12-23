<?php

namespace App\Filament\Resources\DeployedServerResource\Pages;

use App\Filament\Resources\DeployedServerResource;
use App\Models\DeployedServer;
use Filament\Resources\Pages\Page;
use App\Filament\Services\RemoteServerManager;

class ManageDeployedServer extends Page
{
    protected static string $resource = DeployedServerResource::class;

    protected static string $view = 'filament.pages.manage-server';

    public function optimizeDatabase($serverId)
    {
        RemoteServerManager::executeCommand($serverId, 'wp db optimize');
    }

    public function clearCache($serverId)
    {
        RemoteServerManager::executeCommand($serverId, 'php artisan cache:clear');
    }
}
