<?php
// app/Services/ServerAvatarService.php

namespace App\Services;

//use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ServerAvatarService
{
    protected string $baseUrl;
    protected string $token;
    protected string $organizationId;

    public function __construct()
    {
        $this->baseUrl = config('services.serveravatar.url');
        $this->token = config('services.serveravatar.token');
        $this->organizationId = config('services.serveravatar.organization_id');
    }

/*    public function createServer(array $data): array
    {
        $response = Http::withToken($this->token)
            ->post("{$this->baseUrl}/organizations/{$this->organizationId}/servers", $data);

        return $response->throw()->json();
    }*/

public function createServer(array $data): array
    {
        try {
            $response = Http::withHeaders([
                'content-type' => 'application/json',
                'accept' => 'application/json',
                'Authorization' => "Bearer {$this->token}"
            ])->post("{$this->baseUrl}/organizations/{$this->organizationId}/servers", [
                'name' => $data['name'],
                'provider' => 'vultr',
                'cloud_server_provider_id' => 3077,
                'version' => 20,
                'region' => 'atl',
                'availabilityZone' => 'us-east-1a',
                'sizeSlug' => 'vc2-1c-1gb',
                'ssh_key' => true,
                'public_key' => "ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQCEzZ2087B8dNmxfXPTPbP0Gmby15wT1OmXShLJHV/yeEcpS29OBZKt1tmgO2ZteLvAEnMmaYA2rCDVWu3ux+OAWftaLb+FIY1wJsB33HKsq5A9IOTetlWNOba41R+0XI8Y7SOhvtZIbkfPjmsrPhtFZb2khkNuDutGHmj+GZP6lYjwAYmFCdthUB+wlM31QwNsmiQszX4s89LVWkXfqX52SDTBrzauuoH3ve1+A1AocZIqKPAJkYitG67HfLbxMO0vpumCySA3awUpzIP1ZZL6128kqKhx1T/C9qbex/Y0m0Iv2roNhaJI96phT9EsoXiMbUcO5hK+n4wVylgPjtSl oliveearth@yahoo.com",
                'web_server' => 'apache2',
                'database_type' => 'mysql',
                'linode_root_password' => 'Newdelhi@202!2024',
                'nodejs' => false
            ]);

            if (!$response->successful()) {
                Log::error('ServerAvatar API Error', [
                    'status' => $response->status(),
                    'body' => $response->json() ?? $response->body(),
                    'request_data' => $data
                ]);

                throw new \Exception(
                    'Failed to create server: ' . 
                    ($response->json()['message'] ?? 'Server creation failed')
                );
            }

            Log::info('ServerAvatar Server Created', [
                'server_name' => $data['name'],
                'response' => $response->json()
            ]);

//dd($response);
            return $response->json();

        } catch (\Exception $e) {
            Log::error('ServerAvatar Service Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $data
            ]);
            throw $e;
        }
    }

    public function getServerStatus(int $serverId): array
    {
        $response = Http::withToken($this->token)
            ->get("{$this->baseUrl}/organizations/{$this->organizationId}/servers/{$serverId}");

        return $response->throw()->json();
    }

    public function createDatabase(int $serverId, array $data): array
    {
        $response = Http::withToken($this->token)
            ->post("{$this->baseUrl}/organizations/{$this->organizationId}/servers/{$serverId}/databases", $data);

        return $response->throw()->json();
    }


// app/Services/ServerAvatarService.php

public function createWpApplication($serverId, array $data)
{
    try {
        $response = Http::withHeaders([
            'content-type' => 'application/json',
            'accept' => 'application/json',
            'Authorization' => "Bearer {$this->token}"
        ])->post("{$this->baseUrl}/organizations/{$this->organizationId}/servers/{$serverId}/applications", [
            'name' => $data['name'],
            'method' => 'one_click',
            'framework' => 'wordpress',
            'title' => 'wordpress',
            'email' => $data['email'],
            'password' => $data['password'],
            'username' => $data['username'],
            'database_name' => $data['database_name'],
            'temp_domain' => 1,
            'temp_domain_url' => 'satemporary.online',
            'temp_sub_domain_name' => $data['temp_sub_domain_name'],
            'hostname' => '',
            'systemUser' => 'new',
            'systemUserInfo' => [
                'username' => $data['system_username'],
                'password' => $data['system_password']
            ],
            'webroot' => '',
            'www' => false,
            'php_version' => '8.2',
            'install_litespeed_cache_plugin' => false
        ]);

        if (!$response->successful()) {
            Log::error('WordPress Application Creation Failed', [
                'status' => $response->status(),
                'body' => $response->json() ?? $response->body()
            ]);
            throw new \Exception('Failed to create WordPress application: ' . ($response->json()['message'] ?? 'Unknown error'));
        }

        return $response->json();

    } catch (\Exception $e) {
        Log::error('WordPress Application Creation Error', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        throw $e;
    }
}



// app/Services/ServerAvatarService.php

public function createApplication($serverId, array $data)
{
    try {
        $response = Http::withHeaders([
            'content-type' => 'application/json',
            'accept' => 'application/json',
            'Authorization' => "Bearer {$this->token}"
        ])->post("{$this->baseUrl}/organizations/{$this->organizationId}/servers/{$serverId}/applications", [
            'name' => $data['name'],
            'method' => 'git',
            'framework' => 'github',
            'temp_domain' => 0,
            'hostname' => $data['hostname'],
            'systemUser' => 'new',
            'systemUserInfo' => [
                'username' => $data['application_user'],
                'password' => $data['system_password']
            ],
            'php_version' => '8.1',
            'webroot' => '',
            'www' => false,
            'type' => 'public',
            'git_provider_id' => 228,
            'temp_sub_domain' => true,
            'temp_domain_url' => 'satemp.site',
            'clone_url' => 'https://github.com/ted81das/newxtwowai-1-tbd.git',
            'branch' => 'main',
            'script' => $this->getWowInstallationScript($data)
        ]);

        if (!$response->successful()) {
            Log::error('Application Creation Failed', [
                'status' => $response->status(),
                'body' => $response->json() ?? $response->body()
            ]);
            throw new \Exception('Failed to create application: ' . ($response->json()['message'] ?? 'Unknown error'));
        }

        return $response->json();

    } catch (\Exception $e) {
        Log::error('Application Creation Error', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        throw $e;
    }
}

private function getWowInstallationScript(array $data): string
{
    return <<<SCRIPT
wp config create --dbname="{$data['db_name']}" --dbuser="{$data['db_name']}" --dbpass="{$data['db_password']}" --dbhost="localhost";

wp core install --url="{$data['hostname']}" --title="Your Site Title" --admin_user="{$data['admin_user']}" --admin_password="{$data['admin_password']}" --admin_email="{$data['admin_email']}";

wp db import nextwowtry2-2024-12-01-da6c6a5.sql;

wp search-replace "nextwowtry2.test" "{$data['hostname']}";

wp user create {$data['manager_user']} {$data['manager_email']} --role=manager --user_pass={$data['manager_password']};

rm nextwowtry2-2024-12-01-da6c6a5.sql

history -c;

history -w;

SCRIPT;
}



   /* public function createApplication(int $serverId, array $data): array
    {
        $response = Http::withToken($this->token)
            ->post("{$this->baseUrl}/organizations/{$this->organizationId}/servers/{$serverId}/applications", $data);

        return $response->throw()->json();
    }*/
}
