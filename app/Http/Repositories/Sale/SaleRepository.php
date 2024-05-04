<?php

namespace App\Http\Repositories\Sale;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Inventory\InventoryRepository;
use App\Models\Sale;
use Exception;


class SaleRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Sale::class);
    }

    public function updateInventoryMaterial($request)
    {
        $data = (object)$request;
        $inventoryRepo = new InventoryRepository();
        $inventory = $inventoryRepo->find($data->inventory_id);
        $material = $inventory->materials()
            ->where('material_id', $data->material_id)
            ->first();
        if (!$material) {
            throw new Exception("$material->name material is not found in $inventory->name inventory");
        }

        if ($material->pivot->quantity < $this->getBaseUnitQuantity($material->units, $data)) {
            throw new Exception("$material->name material in $inventory->name inventory is not suffecint to fullfil this sale");
        }

        return $inventory->materials()
            ->updateExistingPivot($data->material_id, [
                'quantity' => $material->pivot->quantity - $this->getBaseUnitQuantity($material->units, $data)
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
                    ->pivot->quantity + $this->getBaseUnitQuantity($material->units, $sale)
            ], false);
    }

    public function getBaseUnitQuantity($collection, $data)
    {
        $unit = $collection->first(function ($value) use ($data) {
            return $value->pivot->unit_id == $data->unit_id;
        });
        $quantity = $data->quantity;
        if (!$unit->pivot->is_default) {
            $quantity = $data->quantity * $unit->pivot->rate_to_main_unit;
        }
        return $quantity;
    }
}
