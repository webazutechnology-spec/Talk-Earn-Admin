<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderStatusTxn extends Model
{
    use SoftDeletes;
    protected $table = 'order_status_txn';

    protected $fillable = [
        'id',
        'order_id',
        'order_status_id',
        'payment_status_id',
        'creatby_user_type',
        'created_by_id',
        'description',
        'documents',
        'reason_message',
    ];
    
    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    
}
