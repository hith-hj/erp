<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
 
class MaterialUnit extends Pivot
{
    use HasFactory;
    protected $fillable = ['material_id','unit_id','is_default','main_unit','rate_to_main_unit'];
    public $incrementing = true;

    public function unit()
    {
        return $this->belongsTo(Unit::class,'unit_id');
    } 

    public function material()
    {
        return $this->belongsTo(Material::class,'material_id');
    }

    public function mainUnit()
    {
        return !is_null($this->main_unit) ? Unit::find($this->main_unit) : '';
    }
}
