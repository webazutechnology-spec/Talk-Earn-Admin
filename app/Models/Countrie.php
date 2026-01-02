<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Countrie extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'iso2',
        'iso3',
        'phonecode',
        'capital',
        'currency',
        'currency_symbol',
        'latitude',
        'longitude',
        'flag',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];


    public function states()
    {
        return $this->hasMany(State::class, 'country_id');
    }


    public function cities()
    {
        return $this->hasManyThrough(
            Citie::class,
            State::class,
            'country_id', // Foreign key on states table
            'state_id',   // Foreign key on cities table
            'id',         // Local key on countries table
            'id'          // Local key on states table
        );
    }


    public function camps()
    {
        return $this->hasMany(Camps::class, 'country_id');
    }

    public function GetAllActive()
    {
        return Countrie::where('status', 'Active')->get();
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
