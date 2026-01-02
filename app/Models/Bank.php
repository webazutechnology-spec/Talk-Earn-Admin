<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'country_id',
        'state_id',
        'headquarter',
        'latitude',
        'longitude',
        'image',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function get()
    {
        return Bank::LeftJoin('countries', 'countries.id', '=', 'banks.country_id')->LeftJoin('states', 'states.id', '=', 'banks.state_id')->LeftJoin('cities', 'cities.id', '=', 'banks.headquarter')->select('banks.*','cities.name AS city_name', 'states.name AS state_name', 'countries.name AS country_name')->get();
    }

    public function findByCountry($cid)
    {
        return Bank::LeftJoin('countries', 'countries.id', '=', 'banks.country_id')->LeftJoin('states', 'states.id', '=', 'banks.state_id')->LeftJoin('cities', 'cities.id', '=', 'banks.headquarter')->where('banks.country_id', $cid)->select('banks.*', 'cities.name AS city_name','states.name AS state_name', 'countries.name AS country_name')->get();
    }
    public function findByState($sid)
    {
        return Bank::LeftJoin('countries', 'countries.id', '=', 'banks.country_id')->LeftJoin('states', 'states.id', '=', 'banks.state_id')->LeftJoin('cities', 'cities.id', '=', 'banks.headquarter')->where('banks.state_id', $sid)->select('banks.*', 'cities.name AS city_name','states.name AS state_name', 'countries.name AS country_name')->get();
    }

    public function findByCity($ciid)
    {
        return Bank::LeftJoin('countries', 'countries.id', '=', 'banks.country_id')->LeftJoin('states', 'states.id', '=', 'banks.state_id')->LeftJoin('cities', 'cities.id', '=', 'banks.headquarter')->where('banks.city_id', $ciid)->select('banks.*', 'cities.name AS city_name','states.name AS state_name', 'countries.name AS country_name')->get();
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
