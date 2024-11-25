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
        'currency_id',
        'created_by',
        'client_id',
        'discount',
        'rate_to',
        'level',
        'rate',
        'note',
        'mark',
    ];

    public function bill()
    {
        return $this->hasOne(Bill::class, 'billable_id')
            ->where('billable_type', get_class($this));
    }

    public function total(){
        $total = 0;
        foreach($this->materials as $material){
            $total += $material->pivot->quantity * $material->pivot->cost;
        }
        return $total;
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
            ->withPivot(['quantity', 'unit_id', 'cost']);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
