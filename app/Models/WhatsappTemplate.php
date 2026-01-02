<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WhatsappTemplate extends Model
{

    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $fillable = [
        'slug',
        'template_name',
        'language',
        'variable_mapping',
        'is_active',
    ];

    protected $casts = [
        'variable_mapping' => 'array',
        'is_active' => 'boolean',
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
