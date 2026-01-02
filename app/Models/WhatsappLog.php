<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WhatsappLog extends Model
{

    use SoftDeletes;
    
    protected $table = 'whatsapp_logs';

    protected $fillable = [
        'phone_number',
        'template_used',
        'payload_sent',
        'api_response',
        'status',
    ];

    protected $casts = [
        'payload_sent' => 'array',
        'api_response' => 'array',
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
