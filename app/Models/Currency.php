<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'code'];

    public function rates()
    {
        return $this->belongsToMany(Currency::class, 'currency_rate', 'currency_id', 'rate_to_id')
            ->withPivot(['rate'])
            ->withTimestamps();
    }
}
