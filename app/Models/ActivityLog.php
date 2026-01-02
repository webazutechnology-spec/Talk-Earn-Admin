<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityLog extends Model
{
    use SoftDeletes;

    protected $table = 'activity_logs';

    protected $fillable = [
        'user_id',
        'user_type',
        'type',
        'route_name',
        'title',
        'message',
        'notification_show',
        'old_data',
        'form_data',
        'reference_id',
    ];

    protected $casts = [
        'old_data'  => 'array',
        'form_data' => 'array',
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
