<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceTimeSlot extends Model
{
    use HasFactory;

    protected $table = 'service_time_slots';
    protected $fillable = [
        'user_id',
        'day_of_week',
        'start_time',
        'end_time'
    ];
}