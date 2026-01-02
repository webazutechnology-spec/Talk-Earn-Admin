<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawRequest extends Model
{
    use HasFactory;

    protected $table = 'withdraw_requests'; // explicitly set table name

    protected $fillable = [
        'user_id',
        'referral_id',
        'bank_id',
        'wallet_type',
        'mode',
        'utr_no',
        'amount',
        'trans_id',
        'desc',
        'admin_reply',
        'status',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
