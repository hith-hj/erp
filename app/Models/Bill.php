<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use HasFactory ,SoftDeletes;

    protected $fillable = ['serial','type','status'];

    public function items()
    {
        return match($this->type){
            1=>$this->hasMany(Purchase::class),
            // 1=>$this->hasMany(Purchase::class),
            default=>$this->hasMany(Purchase::class),
        };
    }

    public function getGetTypeAttribute()
    {
        return match($this->type){
            1=>'Purchase',
            2=>'Sale',
            default=>'Not Set'
        };
    }

    public function getGetStatusAttribute()
    {
        return match($this->status){
            0=>'Unsaved',
            1=>'Saved',
            2=>'Audited',
            default=>'Not Set'
        };
    }
}
