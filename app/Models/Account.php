<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'accountable_id',
        'accountable_type',
    ];

    protected $with = ['expenses'];

    public function setTypeAttribute($value)
    {
        return $this->attributes['type'] = AccountType::find($value)?->name ?? $value;
    }

    // public function getTypeAttribute()
    // {
    //     return AccountType::find($this->type)?->name ?? $this->type;
    // }

    public function expenses()
    {
        return $this->belongsToMany(Expense::class)
            ->withPivot(['cost', 'note'])
            ->withTimestamps();
    }
}
