<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['user_id','section_id','code','name','type','note'];
    protected $hidden = ['updated_at','deleted_at'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    
}
