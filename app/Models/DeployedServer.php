<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class DeployedServer extends Model
{
    //
use HasFactory;

    protected $primaryKey = 'server_id';

    protected $fillable = [
        'server_ip',
        'server_ipv6',
        'hostname',
        'owner_user_id',
        'owner_email',
        'root_password',
        'operating_system',
        'server_status',
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_SUCCESS = 'success';
    public const STATUS_FAILED = 'failed';


protected static function boot()
    {
        parent::boot();

        static::creating(function ($server) {
            $server->server_status = self::STATUS_PENDING;
            $server->owner_user_id = auth()->id() ?? 1; // Set default if not authenticated
        });
    }


}
