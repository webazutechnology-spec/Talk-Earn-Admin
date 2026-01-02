<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainigSession extends Model
{
    use SoftDeletes;

    protected $table = 'training_sessions';

    protected $fillable = [
        'id',
        'category_id',
        'title',
        'url',
        'description',
       
    ];
     protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];


    public function category()
    {
        return $this->belongsTo(TrainingCategories::class, 'category_id');
    }
}
