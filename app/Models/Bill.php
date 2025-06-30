<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['billable_id', 'billable_type', 'serial', 'status'];

    public function getNameAttribute()
    {
        return $this->serial;
    }
    
    public function item()
    {
        return $this->belongsTo($this->billable_type,'billable_id');
    }

    public function getGetTypeAttribute()
    {
        return __('locale.'.explode('\\',$this->billable_type)[2]) ?? __('locale.None');
    }

    public function getBaseTypeAttribute()
    {
        return explode('\\',$this->billable_type)[2];
    }

    public function getGetStatusAttribute()
    {
        return match ($this->status) {
            0 => __('locale.Unsaved'),
            1 => __('locale.Saved'),
            2 => __('locale.Checked'),
            3 => __('locale.Audited'),
            default => __('locale.None')
        };
    }

    public function transaction(){
        return $this->hasOne(Transaction::class,'belongTo_id')
        ->where(['belongTo_type'=>$this::class]);
    }
}
