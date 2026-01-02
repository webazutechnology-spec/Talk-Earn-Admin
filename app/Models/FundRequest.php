<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FundRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_user_id', 'to_user_id', 'bank_id', 'wallet_type', 'mode', 'utr_no', 'utr_img', 'request_for', 'amount', 'points', 'trans_id', 'desc', 'remark', 'status'
    ];

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    
}
