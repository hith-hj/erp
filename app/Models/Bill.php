<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['serial', 'type', 'status'];

    public function items()
    {
        return match ($this->type) {
            1 => $this->hasMany(Purchase::class),
            2 => $this->hasMany(Sale::class),
            3 => $this->hasMany(Manufacturing::class),
            default => $this->hasMany(Purchase::class),
        };
    }

    public function getGetTypeAttribute()
    {
        return match ($this->type) {
            1 => __('locale.Purchase'),
            2 => __('locale.Sale'),
            3 => __('locale.Manufacturing'),
            default => __('locale.None'),
        };
    }

    public function getGetStatusAttribute()
    {
        return match ($this->status) {
            0 => __('locale.Unsaved'),
            1 => __('locale.Saved'),
            2 => __('locale.Audited'),
            default => __('locale.None')
        };
    }
}
