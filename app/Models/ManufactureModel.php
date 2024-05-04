<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManufactureModel extends Model
{
    use HasFactory;
    protected $fillable = [
        'inventory_id',
        'material_id',
        'currency_id',
        'quantity',
        'unit_id',
        'cost',
    ];

    protected $with = ['material','inventory','unit','currency'];

    public function manufactured()
    {
        return $this->belongsTo(Material::class,'manufactured_id');
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
