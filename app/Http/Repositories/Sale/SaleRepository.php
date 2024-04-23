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
        return Currency::with(['rates:id'])->get(['id', 'name', 'code']);
    }

    public function getMaterials()
    {
        return Material::with('units')->get(['id', 'name']);
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
        $inventoryRepo = new InventoryRepository();
        $inventory = $inventoryRepo->find($request->inventory_id);
        $material = $inventory->materials()
        ->where('material_id', $request->material_id)
        ->first();
        if (!$material) 
        {
            throw new Exception('material not found in this inventory');
        } 
        if( $material->pivot->quantity < $request->quantity )
        {
            throw new Exception('material in this inventory is not suffecint to fullfil this sel ');
        }
        return $inventory->materials()
            ->syncWithPivotValues($request->material_id, [
                'quantity' => $inventory->materials()
                    ->where('material_id', $request->material_id)
                    ->first()->pivot->quantity - $request->quantity 
            ], false);
    }
    
    
    public function restorInventoryMaterial($sale_id)
    {
        $sale = $this->find($sale_id);
        $inventoryRepo = new InventoryRepository();
        $inventory = $inventoryRepo->find($sale->inventory_id);
        return  $inventory->materials()
                ->syncWithPivotValues($sale->material_id, [
                    'quantity' => $inventory->materials()
                        ->where('material_id', $sale->material_id)
                        ->first()
                        ->pivot->quantity + $sale->quantity
                ], false);
    }


}
