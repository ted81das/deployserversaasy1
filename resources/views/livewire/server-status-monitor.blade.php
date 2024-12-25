<!-- resources/views/livewire/server-status-monitor.blade.php -->
<div>
    <div class="p-4 bg-white rounded-lg shadow">
        <h3 class="text-lg font-medium">Server Provisioning Status</h3>
        
        <div class="mt-4">
            <div class="flex items-center">
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-blue-600 h-2.5 rounded-full" 
                         style="width: {{ $this->getProgressPercentage() }}%">
                    </div>
                </div>
            </div>
            
            <p class="mt-2 text-sm text-gray-600">
                Current Status: {{ ucfirst($status) }}
            </p>
        </div>
    </div>

    <script>
        setInterval(function() {
            @this.checkStatus()
        }, 60000); // Check every minute
    </script>
</div>
