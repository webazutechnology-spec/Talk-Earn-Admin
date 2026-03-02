<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{
    use HasFactory;

    protected $table = 'user_requests';

    protected $fillable = [
        'reg_code',
        'name',
        'email',
        'phone_number',
        'phonecode',
        'otp',
        'token',
        'hit_count',
        'for',
        'verify_at',
        'otp_expires_at',
        'referral_id',
        'type'
    ];
}