<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
 
class MaterialUnit extends Pivot
{
    use HasFactory;
    protected $fillable = ['material_id','unit_id','is_default'];
    public $incrementing = true;
}
