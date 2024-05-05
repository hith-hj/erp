<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryMaterial extends Pivot
{
    use HasFactory, SoftDeletes;

    public $incrementing = true;
    protected $casts = ['status' => 'integer'];
    protected $fillable = [
        'inventory_id',
        'material_id',
        'quantity',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function status()
    {
        return match ($this->status) {
            1 => __('locale.In stock'),
            0 => __('locale.Requested'),
            -1 => __('locale.Out of stock'),
            default => __('locale.None')
        };
    }
}
