<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Town extends Model
{
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'country_id',
        'state_id',
        'city_id',
        'latitude',
        'longitude',
        'flag',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // protected $hidden = [
    //     'id',
    // ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function findByCountry($cid)
    {
        return Town::LeftJoin('countries', 'countries.id', '=', 'towns.country_id')->LeftJoin('states', 'states.id', '=', 'towns.state_id')->LeftJoin('cities', 'cities.id', '=', 'towns.city_id')->where('towns.country_id', $cid)->select('towns.*','cities.name AS city_name', 'states.name AS state_name', 'countries.name AS country_name')->get();
    } 

    public function findByState($sid)
    {
        return Town::LeftJoin('countries', 'countries.id', '=', 'towns.country_id')->LeftJoin('states', 'states.id', '=', 'towns.state_id')->LeftJoin('cities', 'cities.id', '=', 'towns.city_id')->where('towns.state_id', $sid)->select('towns.*', 'cities.name AS city_name','states.name AS state_name', 'countries.name AS country_name')->get();
    } 

    public static function findByCity($ciid)
    {
        return Town::LeftJoin('countries', 'countries.id', '=', 'towns.country_id')->LeftJoin('states', 'states.id', '=', 'towns.state_id')->LeftJoin('cities', 'cities.id', '=', 'towns.city_id')->where('towns.city_id', $ciid)->select('towns.*', 'cities.name AS city_name','states.name AS state_name', 'countries.name AS country_name')->get();
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
