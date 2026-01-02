<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Kyc extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kycs';

    protected $fillable = [
        'id',
        'user_id',
        'aadhar_number',
        'aadhar_image_back',
        'aadhar_image_front',
        'pan_number',
        'pan_image',
        'gst_number',
        'gst_certificate',
        'license_number',
        'remarks',
        'status'
    ];

    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function user(){
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
