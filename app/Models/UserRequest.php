<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{
    use HasFactory;

    protected $table = 'user_requests';

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'otp',
        'token',
        'hit_count',
        'for',
        'verify_at',
        'otp_expires_at',
        'type'
    ];
}