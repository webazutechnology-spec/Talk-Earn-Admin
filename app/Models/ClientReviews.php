<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientReviews extends Model
{
    use SoftDeletes;
    protected $table = 'client_reviews';
    protected $fillable = [
        'id',
        'url',
        'title',
        'description',
    ];
     protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y H:i A');
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y H:i A');
    }
}
