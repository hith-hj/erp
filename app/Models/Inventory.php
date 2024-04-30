<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory, SoftDeletes;
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

    public function status()
    {
        return match($this->status){
            1=>__('locale.Active'),
            0=>__('locale.Suspended'),
            -1=>__('locale.Deleted'),
            default=>__('locale.None'),
        };
    }
}
