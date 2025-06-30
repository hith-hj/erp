<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LedgerRecord extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function ledger(){
        return $this->belongsTo(Ledger::class);
    }

    public function account()
    {
        return $this->morphTo(__FUNCTION__,'account_type','account_id');
    }

    public function currency(){
        return $this->belongsTo(Currency::class);
    }
}
