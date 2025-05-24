<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    use HasFactory;

    protected $fillable = [
        'cashier_id',
        'created_by',
        'start_balance',
        'end_balance',
        'note',
        'serial',
        'vendor_id',
        'project_id',
        'currency_id',
    ];

    public function cashier()
    {
        return $this->belongsTo(Cashier::class);
    }

    public function records()
    {
        return $this->hasMany(LedgerRecord::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
