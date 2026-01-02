<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class BankDetail extends Model
{
    use HasFactory;
    protected $table = 'bank_details';

    protected $fillable = [
        'id',
        'user_id',
        'bank_id',
        'user_name_at_bank',
        'account_number',
        'branch',
        'ifscode',
        'cancele_chq',
        'admin_reply',
        'status',
    ];

    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];


    public function user(){
        return  $this->belongsTo(User::class);
    }

     public function bank(){
        return  $this->belongsTo(Bank::class);
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
