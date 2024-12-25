// app/Http/Livewire/ServerStatusMonitor.php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\ServerAvatarService;
use App\Models\ManagedServer;

class ServerStatusMonitor extends Component
{
    public ManagedServer $server;
    public $status = '';
    
    protected $listeners = ['checkStatus'];

    public function mount(ManagedServer $server)
    {
        $this->server = $server;
    }

    public function checkStatus()
    {
        $service = new ServerAvatarService();
        $status = $service->getServerStatus($this->server->serveravatar_id);
        
        $this->status = $status['ssh_status'];
        
        if ($this->status === 'ready') {
            $this->emit('serverReady');
        }
    }

    public function render()
    {
        return view('livewire.server-status-monitor');
    }
}
