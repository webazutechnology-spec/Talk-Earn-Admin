<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessionalUser extends Model
{
    protected $table = 'professional_users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'title',
        'about',
        'skills',
        'rating',
        'kyc_verified',
    ];
    protected $casts = [
        'skills' => 'array',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'user_id', 'user_id');
    }
}
