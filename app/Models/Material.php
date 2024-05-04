<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\SoftDeletes;
class Material extends Model
{
    use HasFactory,SoftDeletes;

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
        return Unit::where('id',
                $this
                ->units()
                ->where('is_default',1)
                ->first()?->id
            )
            ->first()?->name ?? __('locale.None');
    }

    public function getType()
    {
        return match($this->type){
            1=>__('locale.Base'),
            2=>__('locale.Manufactured'),
            default=>__('locale.None'),
        };
    }

    public function mainMaterial()
    {
        if($this->main_material)
        {
            return $this->find($this->main_material);
        }
    }

    public function hasManufactureModel()
    {
        return $this->manufactureModel()->count() > 0;
    }

    public function manufactureModel()
    {
        return $this->hasMany(ManufactureModel::class,'manufactured_id');
    }

    public function accounts()
    {
        return $this->hasMany(Account::class,'accountable_id')->where('accountable_type',get_class($this));
    }
}
