<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        return $this->attributes['type'] = DB::table('account_types')->where('id', $value)->first()?->name;
    }

    public function expenses()
    {
        return $this->belongsToMany(Expense::class)
            ->withPivot(['cost', 'note'])
            ->withTimestamps();
    }
}
