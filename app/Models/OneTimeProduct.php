<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OneTimeProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'max_quantity',
        'metadata',
        'features',
    ];

    protected $casts = [
        'features' => 'array',
        'metadata' => 'array',
    ];

    public function prices()
    {
        return $this->hasMany(OneTimeProductPrice::class);
    }
}
