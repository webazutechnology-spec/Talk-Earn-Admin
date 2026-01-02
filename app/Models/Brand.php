<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;
    protected $table = 'brands';

    protected $fillable = [
        'id',
        'name',
        'slug',
        'image',
        'status',
    ];
    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    
}
