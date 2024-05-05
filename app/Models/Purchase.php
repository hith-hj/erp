<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'inventory_id',
        'material_id',
        'currency_id',
        'created_by',
        'vendor_id',
        'quantity',
        'bill_id',
        'unit_id',
        'rate_to',
        'discount',
        'level',
        'cost',
        'note',
        'mark',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function bill()
    {
        return $this->belongsTo(bill::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
