<?php

namespace App\Http\Repositories\Purchase;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Inventory\InventoryRepository;
use App\Models\Material;
use App\Models\Purchase;


class PurchaseRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Purchase::class);
    }

    public function updateInventoryMaterial($request)
    {
        $data = (object)$request;
        $inventoryRepo = new InventoryRepository();
        $inventory = $inventoryRepo->find($data->inventory_id);
        $material = $inventory
            ->materials()
            ->where('material_id', $data->material_id)
            ->first();
        if ($material) {
            $inventory
                ->materials()
                ->updateExistingPivot($data->material_id, [
                    'quantity' => $material->pivot->quantity +
                        $this->getBaseUnitQuantity($material->units, $data)
                ]);
        } else {
            $material = Material::find($data->material_id);
            $inventory
                ->materials()
                ->attach($data->material_id, [
                    'quantity' => $this->getBaseUnitQuantity($material->units, $data)
                ]);
        }
        return true;
    }

    public function restorInventoryMaterial($purchase_id)
    {
        $purchase = $this->find($purchase_id);
        $inventoryRepo = new InventoryRepository();
        $inventory = $inventoryRepo->find($purchase->inventory_id);
        $material = $inventory
            ->materials()
            ->where('material_id', $purchase->material_id)
            ->first();
        return  $inventory->materials()
            ->updateExistingPivot($purchase->material_id, [
                'quantity' => $material->pivot->quantity -
                    $this->getBaseUnitQuantity($material->units, $purchase)
            ]);
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
