<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'code', 'is_default', 'rate_to_default'];
    protected $casts = ['is_default' => 'boolean'];

}
