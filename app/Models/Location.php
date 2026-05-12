<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'device_id', 'latitude', 'longitude', 
        'accuracy', 'speed', 'battery_level', 'timestamp'
    ];
    
    protected $casts = [
        'timestamp' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8'
    ];
}