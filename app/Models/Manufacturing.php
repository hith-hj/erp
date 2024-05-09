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
        'bill_id',
        'unit_id',
        'cost',
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
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
}
