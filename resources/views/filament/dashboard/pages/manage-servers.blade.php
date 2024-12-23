

<x-filament::page>
    <div>
        <h1 class="text-xl font-bold">Manage Server</h1>
        <div class="mt-4">
            <button wire:click="optimizeDatabase({{ $record->server_id }})" class="px-4 py-2 font-bold text-white bg-blue-500 rounded">
                Optimize Database
            </button>

            <button wire:click="clearCache({{ $record->server_id }})" class="px-4 py-2 font-bold text-white bg-red-500 rounded">
                Clear Cache
            </button>
        </div>
    </div>
</x-filament::page>
