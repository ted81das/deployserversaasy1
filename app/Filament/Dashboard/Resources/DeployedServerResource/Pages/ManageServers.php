<?php

namespace App\Filament\Dashboard\Resources\DeployedServerResource\Pages;

use App\Filament\Dashboard\Resources\DeployedServerResource;
use App\Models\DeployedServer;
use App\Filament\Services\RemoteServerManager;
use Filament\Resources\Pages\Page;
use App\Services\SSHConnectionService;
use Filament\Notifications\Notification;
use Livewire\Component;


class ManageServers extends Page
{
    protected static string $resource = DeployedServerResource::class;

    protected static string $view = 'filament.dashboard.resources.deployed-server-resource.pages.manage-servers';


public ?DeployedServer $record = null;

    public function mount(DeployedServer $record): void
    {
        $this->record = $record;
    } 


// Define the record property
//    public ?DeployedServer $record = null;

    // Livewire method for optimize database action
    public function optimizeDatabase(): void
    {
        try {
            // Get the current record
            if (!$this->record) {
                throw new \Exception('Server record not found');
            }

            // Execute the command via SSH
            $result = SSHConnectionService::executeCommand(
                $this->record,
                'wp db optimize'
            );

            if ($result) {
                Notification::make()
                    ->title('Database Optimization')
                    ->body('Database optimized successfully')
                    ->success()
                    ->send();
            } else {
                throw new \Exception('Failed to optimize database');
            }

        } catch (\Exception $e) {
            Notification::make()
                ->title('Database Optimization Failed')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    // Livewire method for clear cache action
    public function clearCache(): void
    {
        try {
            // Get the current record
            if (!$this->record) {
                throw new \Exception('Server record not found');
            }

            // Execute the command via SSH
            $result = SSHConnectionService::executeCommand(
                $this->record,
                'php artisan cache:clear'
            );

            if ($result) {
                Notification::make()
                    ->title('Cache Cleared')
                    ->body('Cache cleared successfully')
                    ->success()
                    ->send();
            } else {
                throw new \Exception('Failed to clear cache');
            }

        } catch (\Exception $e) {
            Notification::make()
                ->title('Cache Clear Failed')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    // Add loading states for better UX
    public function getLoadingStates(): array
    {
        return [
            'optimizeDatabase' => __('Optimizing Database...'),
            'clearCache' => __('Clearing Cache...'),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

/*
 public $record;

    public function mount($record): void
    {
        $this->record = $record;
    }



 public function optimizeDatabase($serverId)
    {
        RemoteServerManager::executeCommand($serverId, 'wp db optimize');
    }

    public function clearCache($serverId)
    {
        RemoteServerManager::executeCommand($serverId, 'php artisan cache:clear');
    }

*/



}
