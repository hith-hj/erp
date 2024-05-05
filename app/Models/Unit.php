<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'code'];

    public function materials()
    {
        return $this
            ->belongsToMany(Material::class)
            ->using(MaterialUnit::class)
            ->withPivot(['is_default', 'main_unit', 'rate_to_main_unit'])
            ->withTimestamps();
    }
}
