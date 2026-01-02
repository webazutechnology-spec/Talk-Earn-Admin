<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use SoftDeletes;

    public function scopeForRole($query, $roleId)
    {
        return $query->where('show', 'Yes')->whereRaw('FIND_IN_SET(?, role_id_view)', [$roleId]);
    }

    public function children()
    {
        return $this->hasMany(Module::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Module::class, 'parent_id');
    }
}
