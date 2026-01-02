<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id',
        'country_code',
        'iso2',
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


    public function country(){
        return $this->belongsTo(Countrie::class,'country_id');
    }

    public function cities()
    {
        return $this->hasMany(Citie::class, 'state_id');
    }

    public function camps()
    {
        return $this->hasMany(Camps::class, 'state_id');
    }

    public static function getActive()
    {
        return State::Join('countries', 'countries.id', '=', 'states.country_id')->select('states.*', 'countries.name AS country_name')->get();
    }

    public static function findByActiveCountry($id)
    {
        return State::Join('countries', 'countries.id', '=', 'states.country_id')->where('states.status', 'Active')->where('states.country_id', $id)->select('states.*', 'countries.name AS country_name')->get();
    }

    public static function findByCountry($id)
    {
        return State::Join('countries', 'countries.id', '=', 'states.country_id')->where('states.country_id', $id)->select('states.*', 'countries.name AS country_name')->get();
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
