<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Citie extends Model
{
    use SoftDeletes;

    protected $table = 'cities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'state_id',
        'state_code',
        'image',
        'country_id',
        'country_code',
        'latitude',
        'longitude',
        'flag',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

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


    // A city belongs to one state
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    // Optional: A city also belongs to a country (through state)
    public function country()
    {
        return $this->hasOneThrough(
            Countrie::class, // Final model
            State::class,   // Intermediate model
            'id',           // Foreign key on states table (local key for City)
            'id',           // Foreign key on countries table (local key for State)
            'state_id',     // Foreign key on cities table
            'country_id'    // Foreign key on states table
        );
    }


     public function camps()
    {
        return $this->hasMany(Camps::class, 'city_id');
    }

    public static function GetAllCountryData($cid)
    {
        return Citie::LeftJoin('countries', 'countries.id', '=', 'cities.country_id')->LeftJoin('states', 'states.id', '=', 'cities.state_id')->where('cities.country_id', $cid)->select('cities.*', 'states.name AS state_name', 'countries.name AS country_name')->get();
    }

    public static function findByState($sid)
    {
        return Citie::LeftJoin('countries', 'countries.id', '=', 'cities.country_id')->LeftJoin('states', 'states.id', '=', 'cities.state_id')->where('cities.state_id', $sid)->select('cities.*', 'states.name AS state_name', 'countries.name AS country_name')->get();
    }

    public static function findByActiveState($sid)
    {
        return Citie::LeftJoin('countries', 'countries.id', '=', 'cities.country_id')->LeftJoin('states', 'states.id', '=', 'cities.state_id')->where('cities.state_id', $sid)->where('cities.status', 'Active')->select('cities.*', 'states.name AS state_name', 'countries.name AS country_name')->get();
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
