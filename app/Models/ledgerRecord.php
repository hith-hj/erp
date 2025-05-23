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

    public function currency(){
        return $this->belongsTo(Currency::class);
    }
}
