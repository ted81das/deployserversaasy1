<?php

namespace App\Filament\Services;

use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Net\SSH2;
use App\Models\DeployedServer;
use Illuminate\Support\Facades\Log;

class RemoteServerManager
{
    public static function executeCommand($serverId, $command)
    {
        $server = DeployedServer::find($serverId);

        if (!$server) {
            throw new \Exception('Server not found');
        }

        $keyPath = storage_path('keys/id_rsa');
        $ssh = new SSH2($server->server_ip);
        $privateKey = PublicKeyLoader::load(file_get_contents($keyPath));

        if (!$ssh->login('root', $privateKey)) {
            throw new \Exception('Unable to log in to the server.');
        }

        return $ssh->exec($command);
    }
}
