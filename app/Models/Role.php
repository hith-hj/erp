<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name'];
    protected $hidden = ['updated_at','deleted_at'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
