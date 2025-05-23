<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ledgerRecord extends Model
{
    use HasFactory;

    public function ledger(){
        return $this->belongsTo(Ledger::class);
    }
}
