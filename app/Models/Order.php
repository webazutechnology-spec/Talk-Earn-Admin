<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'orders';
    protected $primaryKey = 'id';
    protected $fillable = ['code','order_by_id','user_id','product_details','address','tax_type','total_amount','order_tax','other_charges','anc_amount','net_metering_amount','final_amount_without_tax','final_amount_with_tax','order_status_id','payment_status_id','anc_id','anc_name','net_metering_id','net_metering_name'];
    
    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function payments()
    {
        return $this->hasMany(OrderPayment::class);
    }

    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }

    public function orderBy() {
        return $this->belongsTo(User::class,'order_by_id');
    }
    
    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }

    public function payment()
    {
        return $this->belongsTo(PaymentStatus::class, 'payment_status_id');
    }
    // public function txn() {
    //     return $this->hasMany(OrderStatusTxn::class,'order_id');
    // }

    
    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y H:i A');
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y H:i A');
    }
}
