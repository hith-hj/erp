<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'inventory_id',
        'created_by',
        'client_id',
        'discount',
        'level',
        'note',
        'mark',
    ];

    public function bill()
    {
        return $this->hasOne(Bill::class, 'billable_id')
            ->where('billable_type', get_class($this));
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class)
            ->using(MaterialSale::class)
            ->withTimestamps()
            ->withPivot(['quantity', 'unit_id', 'currency_id', 'rate_to', 'rate', 'cost']);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
