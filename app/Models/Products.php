<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
        use SoftDeletes;
    protected $table = 'products';

    protected $fillable = [
        'id',
        'name',
        'slug',
        'image',
         'sku',
         'category_id',
         'brand_id',
        'capacity',
        'type',
        'voltage',
        'specifications',
        'price',
        'disc_price',
        'stock_quantity',

    ];

    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
    public function brand()
    {
        return $this->belongsTo(Brands::class, 'brand_id');
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
