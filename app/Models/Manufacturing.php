<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacturing extends Model
{
    use HasFactory;
    protected $fillable = [
        'inventory_id',
        'material_id',
        'quantity',
        'unit_id',
        'cost',
    ];

    public function bill()
    {
        return $this->hasOne(Bill::class, 'billable_id')
            ->where('billable_type', get_class($this));
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
    
    public function materials()
    {
        return $this->hasMany(ManufactureModel::class, 'manufactured_id', 'material_id');
    }

    public function total(){
        return $this->cost;
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
