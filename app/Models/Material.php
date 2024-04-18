<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory, \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = ['name','type','status','main_material'];

    public function units()
    {
        return $this
        ->belongsToMany(Unit::class)
        ->using(MaterialUnit::class)
        ->withPivot(['is_default','main_unit','rate_to_main_unit'])
        ->withTimestamps();
    }

    public function inventories()
    {
        return $this
        ->belongsToMany(Inventory::class)
        ->using(InventoryMaterial::class)
        ->withPivot(['quantity','status'])
        ->withTimestamps();
    }

    public function defaultUnit()
    {
        return $this->units()->where('is_default',1)->first()->value ?? '';
    }

    public function type()
    {
        return match($this->type){
            1=>'Base',
            2=>'Manufactured',
            default=>$this->type,
        };
    }

    public function mainMaterial()
    {
        if($this->main_material)
        {
            return $this->find($this->main_material);
        }
    }
}
