<?php

namespace App\Http\Repositories\Sale;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Client\ClientRepository;
use App\Http\Repositories\Inventory\InventoryRepository;
use App\Models\Currency;
use App\Models\Inventory;
use App\Models\Material;
use App\Models\Sale;
use App\Models\Unit;
use Exception;
use Illuminate\Database\Eloquent\Collection;


class SaleRepository implements BaseRepository
{
    public function all(array|string $columns = ['*']): Collection
    {
        return Sale::all($columns);
    }

    public function find(int $id, $columns = ['*']): Sale
    {
        return Sale::findOrFail($id, $columns);
    }

    public function add($data): Sale
    {
        return Sale::create($data);
    }

    public function update($data, int $id): bool
    {
        return Sale::findOrFail($id)->update($data);
    }

    public function delete(int $id): bool
    {
        $Sale = Sale::findOrFail($id);
        return $Sale->delete();
    }

    public function allWith(
        array|string $relation = [],
        array|string $columns = ['*'],
    ): Collection {
        return Sale::select($columns)->with($relation)->get();
    }

    public function paginateWith(
        int $perPage = 5,
        array|string $relation = [],
        array|string $columns = ['*'],
    ) {
        return Sale::with($relation)->paginate($perPage, $columns);
    }

    public function findWith(
        int $id,
        array|string $relation = [],
        array|string $columns = ['*']
    ): Sale {
        return Sale::with($relation)->findOrFail($id, $columns);
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
        return Material::with(['inventories','units'])->get(['id', 'name']);
    }

    public function getInventories()
    {
        return Inventory::all(['id', 'name']);
    }

    public function getClients()
    {
        return (new ClientRepository())->all();
    }

    public function updateInventoryMaterial($request)
    {
        $data = (object)$request;
        $inventoryRepo = new InventoryRepository();
        $inventory = $inventoryRepo->find($data->inventory_id);
        $material = $inventory->materials()
            ->where('material_id', $data->material_id)
            ->first();
        if( ! $material ) 
        {
            throw new Exception("$material->name material is not found in $inventory->name inventory");
        } 

        if( $material->pivot->quantity < $this->getBaseUnitQuantity($material->units,$data) )
        {
            throw new Exception("$material->name material in $inventory->name inventory is not suffecint to fullfil this sale");
        }

        return $inventory->materials()
            ->updateExistingPivot($data->material_id, [
                'quantity' => $material->pivot->quantity - $this->getBaseUnitQuantity($material->units,$data) 
            ]);
    }
    
    public function restorInventoryMaterial($sale_id)
    {
        $sale = $this->find($sale_id);
        $inventoryRepo = new InventoryRepository();
        $inventory = $inventoryRepo->find($sale->inventory_id);
        $material = $inventory->materials()
            ->where('material_id', $sale->material_id)
            ->first();
        return  $inventory->materials()
                ->syncWithPivotValues($sale->material_id, [
                    'quantity' => $inventory->materials()
                        ->where('material_id', $sale->material_id)
                        ->first()
                        ->pivot->quantity + $this->getBaseUnitQuantity($material->units,$sale)
                ], false);
    }

    public function getBaseUnitQuantity($collection,$data)
    {
        $unit = $collection->first(function($value)use($data){
            return $value->pivot->unit_id == $data->unit_id;
        });
        $quantity = $data->quantity;
        if(! $unit->pivot->is_default )
        {
            $quantity = $data->quantity * $unit->pivot->rate_to_main_unit;
        }
        return $quantity;
    }
}
