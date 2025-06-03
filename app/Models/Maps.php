<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maps extends Model
{
    protected $fillable = [
        // Other fillable fields
        'location',
    ];

    protected $casts = [
        'location' => 'array',
    ];
}
