<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Configuration extends Model
{
    use SoftDeletes;

    protected $table = 'app_configurations';

    protected $fillable = [
        'id',
        'for',
        'title',
        'name',
        'value',
        'desc',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [

    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function GetConfig()
	{
		return Configuration::get();
	} 

    public static function Create($data)
    {
        return $this->insert($data);
    }

    public static function UpdateData($id, $data)
    {
        return $this->where('id',$id)->update($data);
    }

    public static function GetById($id)
    {
        return Configuration::where('id', $id)->first();
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
