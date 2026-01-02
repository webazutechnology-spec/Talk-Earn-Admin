<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderPayment extends Model
{
    use SoftDeletes;

    protected $table = 'order_payments';

    protected $fillable = [
        'id',
        'trans_id',
        'user_id',
        'order_id',
        'trans_type',
        'type',
        'method',
        'utr_no',
        'amount',
        'image',
    ];
    
    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    
}
