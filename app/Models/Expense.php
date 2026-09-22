<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function accounts()
    {
        return $this->belongsToMany(Account::class)
            ->withPivot(['cost', 'note'])
            ->withTimestamps();
    }

    public function records()
    {
        return $this->hasMany(LedgerRecord::class, 'account_id')
            ->where(['account_type' => $this::class]);
    }
}
