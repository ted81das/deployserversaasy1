<?php

namespace App\Services;

use App\Models\DeployedServer;
use phpseclib3\Net\SSH2;
use phpseclib3\Crypt\PublicKeyLoader;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SSHConnectionService
{


 // NEW METHOD: Added specifically for executing commands
    public static function executeCommand(DeployedServer $server, string $command): bool
    {
        try {
            $ssh = new SSH2($server->server_ip);
            $key = PublicKeyLoader::load(file_get_contents(storage_path('app/keys/id_rsa')));

            if (!$ssh->login('root', $key)) {
                Log::error("Failed to connect to server: {$server->server_ip}");
                return false;
            }

            // NEW: Execute the specific command passed as parameter
            $result = $ssh->exec($command);
            
            // NEW: Added logging for command execution
            Log::info("Command executed on {$server->server_ip}: {$command}");
            Log::info("Result: {$result}");

            return true;

        } catch (\Exception $e) {
            Log::error("SSH Command execution error: " . $e->getMessage());
            return false;
        }
    }

//EXISTING METHOD: Keep the verification connection method

    public static function verifyConnection(DeployedServer $server): bool
    {
        try {
            $ssh = new SSH2($server->server_ip);
            $key = PublicKeyLoader::load(file_get_contents(storage_path('keys/id_rsa')));

            if (!$ssh->login('root', $key)) {
                Log::error("Failed to connect to server: {$server->server_ip}");
                return false;
            }

            // Get OS information
            $osInfo = trim($ssh->exec('cat /etc/os-release | grep PRETTY_NAME'));
            $hostname = trim($ssh->exec('hostname'));

            // Update server details
            $server->update([
                'operating_system' => str_replace('PRETTY_NAME="', '', str_replace('"', '', $osInfo)),
                'hostname' => $hostname,
                'server_status' => DeployedServer::STATUS_SUCCESS
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error("SSH Connection error: " . $e->getMessage());
            $server->update(['server_status' => DeployedServer::STATUS_FAILED]);
            return false;
        }
    }
}
