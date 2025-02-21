<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'ip',
        'mac',
        'port',
        'is_active',
        'image',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
