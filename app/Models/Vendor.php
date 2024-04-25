<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['first_name','last_name','email','phone'];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function getfullNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }
}
