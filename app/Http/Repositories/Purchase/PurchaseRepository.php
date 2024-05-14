<?php

namespace App\Http\Repositories\Purchase;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Bill\BillRepository;
use App\Http\Repositories\Inventory\InventoryRepository;
use App\Models\Material;
use App\Models\Purchase;


class PurchaseRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Purchase::class);
    }

    public function getShowPayload($id)
    {
        return [
            'purchase' => $this->findWith(
                id: $id,
                relation: ['inventory', 'material', 'currency']
            )
        ];
    }

    public function getCreatePayload()
    {
        return [
            'inventories' => $this->getter(
                model: 'Inventory',
                columns: ['id', 'name', 'is_default']
            ) ?? [],

            'currencies' => $this->getter(
                model: 'Currency',
                callable: [
                    'select' => ['id', 'name', 'code'],
                    'with' => ['rates:id,name'],
                ],
            ) ?? [],

            'materials' => $this->getter(
                model: 'Material',
                callable: [
                    'select' => ['id', 'name'],
                    'with' => ['units:id,name,code'],
                ]
            ) ?? [],

            'vendors' => $this->getter(
                model: 'Vendor',
                columns: ['id', 'first_name', 'last_name']
            ) ?? [],

            'bill' => (new BillRepository())->add(['type' => 1]),
        ];
    }

    public function storePurchase($request)
    {
        foreach ($request->purchases as $purchase) {
            $purchase['bill_id'] = $request->bill_id;
            $purchase['created_by'] = auth()->user()->id;
            if (is_null($purchase['inventory_id'])) {
                $purchase['inventory_id'] =
                    $this->firstWithWhere('inventory', where: [['is_default', 1]])?->id ?? 1;
            }
            if (is_null($purchase['unit_id'])) {
                $material = $this->firstWithWhere(
                    model: 'material',
                    with: ['units']
                );
                $unit = $material->units->first(function ($item) {
                    return $item->pivot->is_default == 1;
                });
                $purchase['unit_id'] = $unit->id;
            }
            $purchase = $this->add($purchase);
            $this->updateInventoryMaterial($purchase);
        }
        return;
    }

    public function updateInventoryMaterial($request)
    {
        $data = (object)$request;
        $inventoryRepo = new InventoryRepository();
        $inventory = $inventoryRepo->find($data->inventory_id);
        $material = $inventory
            ->materials()
            ->wherePivot('material_id', $data->material_id)
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
