<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'active',

        'calendar_id',

        'name',
        'description',
        'link',
        'color',
        'beginning',
        'ending',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}
