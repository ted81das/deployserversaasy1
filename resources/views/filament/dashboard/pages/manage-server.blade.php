<x-filament::page>
    <div>
        <h1 class="text-2xl font-bold">Manage Server</h1>

        <p>Welcome to the server management page.</p>

        <!-- Example Actions -->
        <div class="mt-4 space-y-4">
            <button
                class="px-4 py-2 text-white bg-blue-600 rounded"
                wire:click="optimizeDatabase({{ $recordId }})"
            >
                Optimize Database
            </button>

            <button
                class="px-4 py-2 text-white bg-green-600 rounded"
                wire:click="clearCache({{ $recordId }})"
            >
                Clear Cache
            </button>
        </div>
    </div>
</x-filament::page>
