<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = ['transaction_id', 'amount', 'created_by'];

    public function transaction(){
        return $this->belongsTo(Transaction::class);
    }
}
