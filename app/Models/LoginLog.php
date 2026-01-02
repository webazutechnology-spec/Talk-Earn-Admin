<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoginLog extends Model
{
    use HasFactory, SoftDeletes;

    // Explicitly define the table name if it's not the plural of the model
    protected $table = 'login_logs';
    
    // Disable timestamps if your table uses specific column names like 'login' instead of created_at
    public $timestamps = false; 

    protected $fillable = [
        'user_id',
        'user_type',
        'request',
        'server',
        'ip_address',
        'location',
        'login',
        'last_activity'
    ];

    public function user()
    {
        return  $this->belongsTo(User::class);
    }

    
    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y H:i A');
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y H:i A');
    }
}