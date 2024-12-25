<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class ManagedServer extends Model
{
    protected $fillable = [
        'server_uuid',
        'server_name',
        'provider',
        'cloud_server_provider_id',
        'version',
        'region',
        'availability_zone',
        'size_slug',
        'ssh_key',
        'public_key',
        'web_server',
        'app_hostname',
        'database_type',
 'app_miniadmin_username' ,
'app_miniadmin_email' ,
'app_miniadmin_password',
        'db_name',
        'db_password',
        'application_name',
        'application_user',
        'application_user_password',
        'server_instance_id',
        'serveravatar_id',
        'vultr_instance_id',
        'ssh_status',
        'agent_status',
        'ip_address',
        'system_user_id',
        'wow_app_id',
        'cloud_app_id',
        'pavel_app_id',
        'provider_name',
        'php_cli_version',
        'folder_name'
    ];

    protected $hidden = [
        'db_password',
        'application_user_password',
    ];

    protected static function boot()
    {
        parent::boot();
        



        static::creating(function ($model) {

 if (empty($model->public_key)) {
                $model->public_key = 'ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQCEzZ2087B8dNmxfXPTPbP0Gmby15wT1OmXShLJHV/yeEcpS29OBZKt1tmgO2ZteLvAEnMmaYA2rCDVWu3ux+OAWftaLb+FIY1wJsB33HKsq5A9IOTetlWNOba41R+0XI8Y7SOhvtZIbkfPjmsrPhtFZb2khkNuDutGHmj+GZP6lYjwAYmFCdthUB+wlM31QwNsmiQszX4s89LVWkXfqX52SDTBrzauuoH3ve1+A1AocZIqKPAJkYitG67HfLbxMO0vpumCySA3awUpzIP1ZZL6128kqKhx1T/C9qbex/Y0m0Iv2roNhaJI96phT9EsoXiMbUcO5hK+n4wVylgPjtSl oliveearth@yahoo.com';
            }
            
            if (empty($model->server_uuid)) {
                $model->server_uuid = (string) Str::uuid();
            }

//            $model->server_uuid = Str::uuid();
        });
    }

    // Helper method to generate unique database name
    public static function generateUniqueDatabaseName(): string
    {
        do {
            $dbName = 'db_' . Str::random(10);
        } while (self::where('db_name', $dbName)->exists());
        
        return $dbName;
    }

    // Helper method to generate unique database password
    public static function generateUniqueDatabasePassword(): string
    {
        // Generate a 16-character password with:
        // - At least one uppercase letter
        // - At least one lowercase letter
        // - At least one number
        // - At least one special character
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $specialChars = '!@#$%^&*()_+-=[]{}|;:,.<>?';

        $password = [
            // Ensure at least one of each character type
            $uppercase[random_int(0, strlen($uppercase) - 1)],
            $lowercase[random_int(0, strlen($lowercase) - 1)],
            $numbers[random_int(0, strlen($numbers) - 1)],
            $specialChars[random_int(0, strlen($specialChars) - 1)],
        ];

        // Fill the rest with random characters
        $allChars = $uppercase . $lowercase . $numbers . $specialChars;
        for ($i = 0; $i < 12; $i++) {
            $password[] = $allChars[random_int(0, strlen($allChars) - 1)];
        }

        // Shuffle the password array and convert to string
        shuffle($password);
        return implode('', $password);
    }

    // Helper method to generate unique application user
    public static function generateUniqueApplicationUser(): string
    {
        do {
            $appUser = 'app_' . Str::random(8);
        } while (self::where('application_user', $appUser)->exists());
        
        return $appUser;
    }

    // Helper method to generate secure application user password
    public static function generateSecurePassword(): string
    {
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $specialChars = '!@#$%^&*()_+-=[]{}|;:,.<>?';

        $password = [
            // Ensure at least one of each character type
            $uppercase[random_int(0, strlen($uppercase) - 1)],
            $lowercase[random_int(0, strlen($lowercase) - 1)],
            $numbers[random_int(0, strlen($numbers) - 1)],
            $specialChars[random_int(0, strlen($specialChars) - 1)],
        ];

        // Fill the rest with random characters
        $allChars = $uppercase . $lowercase . $numbers . $specialChars;
        for ($i = 0; $i < 12; $i++) {
            $password[] = $allChars[random_int(0, strlen($allChars) - 1)];
        }

        // Shuffle the password array and convert to string
        shuffle($password);
        return implode('', $password);
    }

    public function wowApp(): HasOne
    {
        return $this->hasOne(ManagedServerAppWow::class);
    }

    // Helper method to validate password strength
    public static function isPasswordStrong(string $password): bool
    {
        return strlen($password) >= 12 &&
            preg_match('/[A-Z]/', $password) &&     // At least one uppercase letter
            preg_match('/[a-z]/', $password) &&     // At least one lowercase letter
            preg_match('/[0-9]/', $password) &&     // At least one number
            preg_match('/[^A-Za-z0-9]/', $password); // At least one special character
    }
}


