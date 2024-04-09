<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $fillable = ['name','symbol'];

    public function materials()
    {
        return $this
        ->belongsToMany(Material::class)
        ->using(MaterialUnit::class)
        ->withPivot('is_default')
        ->withTimestamps();
    }

    public function inventory()
    {
        return $this->belongsToMany(Inventory::class)
        ->unsig(InventoryMaterial::class)
        ->withPivot('')
        ->withTimestamps();
    }
}
