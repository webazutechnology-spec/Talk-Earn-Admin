<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'type',
        'name',
        'show',
        'order_by',
        'status',
    ];

    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }

    public static function roleName($id)
    {
        return self::where('id', $id)->first('name');
    }


    // public function getByType($type)
    // {
    //     $query = DB::query()
    //     ->selectRaw('count(*)')
    //     ->from('users_data')
    //     ->whereColumn('users_data.role', 'user_role.id');

    //     $results = DB::query()
    //     ->select('*')
    //     ->selectSub($query, 'total_users')
    //     ->from('user_role')
    //     ->where('user_role.role_type', $type)
    //     ->orderBy('user_role.role_order_by')
    //     ->get();

    //    return $results;
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
