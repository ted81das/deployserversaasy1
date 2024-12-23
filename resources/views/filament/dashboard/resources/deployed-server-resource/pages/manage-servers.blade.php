<x-filament-panels::page>
    <x-filament::card>
        <div class="p-4">
            <h2 class="text-lg font-medium">Server Details</h2>
            <div class="mt-4 space-y-4">
                <div>
                    <span class="font-bold">IP Address:</span> 
                    {{ $this->record->server_ip }}
                </div>
                <div>
                    <span class="font-bold">Hostname:</span> 
                    {{ $this->record->hostname }}
                </div>
                <div>
                    <span class="font-bold">Operating System:</span> 
                    {{ $this->record->operating_system }}
                </div>
                <div>
                    <span class="font-bold">Status:</span> 
                    {{ $this->record->server_status }}
                </div>
            </div>
        </div>
    </x-filament::card>

    <x-filament::card class="mt-4">
        <div class="p-4">
            <h2 class="text-lg font-medium">Server Management</h2>
            <div class="mt-4 space-x-4">
                <x-filament::button
                    wire:click="optimizeDatabase"
                    wire:loading.attr="disabled"
                    wire:target="optimizeDatabase"
                      >
                    <span wire:loading.remove wire:target="optimizeDatabase">
                        Optimize Database
                    </span>
                    <span wire:loading wire:target="optimizeDatabase">
                        Optimizing...
                    </span>
                 
                </x-filament::button>

                <x-filament::button
                    wire:click="clearCache"
                    wire:loading.attr="disabled"
                    wire:target="clearCache"
                    >
                    <span wire:loading.remove wire:target="clearCache">
                        Clear Cache
                    </span>
                    <span wire:loading wire:target="clearCache">
                        Clearing...
                    </span>                
                </x-filament::button>
            </div>
        </div>
    </x-filament::card>
</x-filament-panels::page>

