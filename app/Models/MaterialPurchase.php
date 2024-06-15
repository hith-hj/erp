<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MaterialPurchase extends Pivot
{
    public $incrementing = true;

    protected $casts = ['status' => 'integer'];

    protected $fillable = [
        'purchase_id',
        'material_id',
        'currency_id',
        'quantity',
        'unit_id',
        'rate_to',
        'rate',
        'cost',
    ];

    protected $with = ['unit', 'currency', 'rateTo'];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
    
    public function rateTo()
    {
        return $this->belongsTo(Currency::class,'rate_to');
    }
}
