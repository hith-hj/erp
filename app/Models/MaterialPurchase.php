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
        'quantity',
        'unit_id',
        'cost',
    ];

    protected $with = ['unit'];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    
}
