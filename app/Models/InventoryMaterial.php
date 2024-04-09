<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class InventoryMaterial extends Pivot
{
    use HasFactory, \Illuminate\Database\Eloquent\SoftDeletes;
    
    public $incrementing = true;
    protected $casts = ['status'=>'integer'];


    protected $fillable = [
        'inventory_id',
        'material_id',
        'quantity',
    ];

    // protected $with = ['material'];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function status()
    {
        return match($this->status){
            1=>'In Stock',
            0=>'Requested',
            -1=>'Out of stock',
            default=>'Not Set'
        };
    }
}
