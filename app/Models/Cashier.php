<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cashier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'total', 'is_default', ];

    public function transactions(){
        return $this->hasMany(Transaction::class)->orderBy('created_at','desc');
    }

    public function ledgers(){
        return $this->hasMany(Ledger::class);
    }

    public function transfers(){
        return $this->hasMany(Transaction::class,'belongTo_id')
        ->where(['belongTo_type'=>$this::class])
        ->orderBy('created_at','desc');
    }

}
