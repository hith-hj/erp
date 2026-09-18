<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class InventoryMaterial extends Pivot
{
    use HasFactory;

    public $incrementing = true;

    protected $casts = ['status' => 'integer'];

    protected $fillable = [
        'inventory_id',
        'material_id',
        'quantity',
        'status',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function status()
    {
        return match ($this->status) {
            1 => __('locale.In stock'),
            0 => __('locale.Out of stock'),
            -1 => __('locale.Requested'),
            default => __('locale.None')
        };
    }
}
