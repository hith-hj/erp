<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Inventory extends Model
{
    use HasFactory, \Illuminate\Database\Eloquent\SoftDeletes;
    protected $fillable = ['name'];

    protected $casts = ['status'=>'integer'];

    public function materials()
    {
        return $this
        ->belongsToMany(Material::class)
        ->using(InventoryMaterial::class)
        ->withPivot(['quantity','status'])
        ->withTimestamps();
    }

    public function units()
    {
        return $this
        ->belongsToMany(Unit::class)
        ->using(InventoryMaterial::class)
        ->withPivot([''])
        ->withTimestamps();
    }

    public function currency()
    {
        return $this
        ->belongsToMany(Currency::class)
        ->using(InventoryMaterial::class)
        ->withPivot([''])
        ->withTimestamps();
    }

    public function status()
    {
        // dd($this->status);
        return match($this->status){
            1=>'Active',
            0=>'suspended',
            -1=>'deleted',
            default=>'Not Set'
        };
    }
}
