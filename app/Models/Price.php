<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends Model
{
    use SoftDeletes;
    protected $table = 'pricings';

    protected $fillable = [
        'id',
        'name',
        'amount',
        'type',
    ];
    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];
    
}
