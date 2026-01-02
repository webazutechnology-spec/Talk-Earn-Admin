<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupportReply extends Model
{
    use SoftDeletes;

    protected $table = 'support_replies';
    protected $primaryKey = 'id';
    protected $fillable = ['support_id', 'description', 'type','file','user_id','replay_id','status'];
    protected $casts = ['updated_at' => 'datetime','created_at' => 'datetime'];


    public function support() {
        return $this->belongsTo(Support::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function parent() {
        return $this->belongsTo(SupportReply::class, 'replay_id');
    }

    public function children() {
        return $this->hasMany(SupportReply::class, 'replay_id');
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
