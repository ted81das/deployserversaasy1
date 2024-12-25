<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class ManagedServerAppWow extends Model
{
    //
protected $fillable = [
        'managed_server_id',
        'application_name',
        'app_hostname',
        'app_miniadmin_username',
        'app_miniadmin_email',
        'app_miniadmin_password',
        'application_user',
        'system_password',
        'db_name',
        'db_username',
        'db_password',
        'application_user_id',
        'system_user_info',
        'php_version',
        'webroot',
        'git_provider_id',
        'clone_url',
        'branch'
    ];

    public function server(): BelongsTo
    {
        return $this->belongsTo(ManagedServer::class, 'managed_server_id');
    }

}
