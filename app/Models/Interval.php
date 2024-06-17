<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interval extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'date_diff',
    ];

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }
}
