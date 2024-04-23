<?php

namespace App\Http\Repositories\Purchase;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Inventory\InventoryRepository;
use App\Http\Repositories\Vendors\VendorRepository;
use App\Models\Currency;
use App\Models\Inventory;
use App\Models\Material;
use App\Models\Purchase;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Collection;


class PurchaseRepository implements BaseRepository
{
    public function all(array|string $columns = ['*']): Collection
    {
        return Purchase::all($columns);
    }

    public function find(int $id, $columns = ['*']): Purchase
    {
        return Purchase::findOrFail($id, $columns);
    }

    public function add($data): Purchase
    {
        return Purchase::create($data);
    }


    public function update($data, int $id): bool
    {
        return Purchase::findOrFail($id)->update($data);
    }


    public function delete(int $id): bool
    {
        $Purchase = Purchase::findOrFail($id);
        return $Purchase->delete();
    }

    public function allWith(
        array|string $relation = [],
        array|string $columns = ['*'],
    ): Collection {
        return Purchase::select($columns)->with($relation)->get();
    }

    public function paginateWith(
        int $perPage = 5,
        array|string $relation = [],
        array|string $columns = ['*'],
    ) {
        return Purchase::with($relation)->paginate($perPage, $columns);
    }

    public function findWith(
        int $id,
        array|string $relation = [],
        array|string $columns = ['*']
    ): Purchase {
        return Purchase::with($relation)->findOrFail($id, $columns);
    }

    public function getUnits()
    {
        return Unit::all();
    }

    public function getCurrencies()
    {
        return Currency::with(['rates:id,name'])->get(['id', 'name', 'code']);
    }

    public function getMaterials()
    {
        return Material::with('units')->get(['id', 'name']);
    }

    public function getInventories()
    {
        return Inventory::all(['id', 'name']);
    }

    public function getVendors()
    {
        return (new VendorRepository())->all(['id','first_name','last_name']);
    }

    public function updateInventoryMaterial($data)
    {
        $data = (object)$data;
        $inventoryRepo = new InventoryRepository();
        $inventory = $inventoryRepo->find($data->inventory_id);
        if ($inventory->materials()->where('material_id', $data->material_id)->exists()) {
            $inventory->materials()
                ->updateExistingPivot($data->material_id, [
                    'quantity'=> $data->quantity + $inventory->materials()
                        ->where('material_id', $data->material_id)->first()->pivot->quantity
                ]);
        } else {
            $inventory->materials()->attach($data->material_id, ['quantity' => $data->quantity]);
        }
        return true;
    }
    
    
    public function restorInventoryMaterial($purchase_id)
    {
        $purchase = $this->find($purchase_id);
        $inventoryRepo = new InventoryRepository();
        $inventory = $inventoryRepo->find($purchase->inventory_id);
        return  $inventory->materials()
                ->syncWithPivotValues($purchase->material_id, [
                    'quantity' => $inventory->materials()
                        ->where('material_id', $purchase->material_id)
                        ->first()
                        ->pivot->quantity - $purchase->quantity
                ], false);
    }


}
