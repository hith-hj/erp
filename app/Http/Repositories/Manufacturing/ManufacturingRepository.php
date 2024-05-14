<?php

namespace App\Http\Repositories\Manufacturing;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Bill\BillRepository;
use App\Models\Inventory;
use App\Models\InventoryMaterial;
use App\Models\Manufacturing;
use Exception;

class ManufacturingRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Manufacturing::class);
    }

    public function getShowPayload($id)
    {
        return [
            'manufacturing' => $this->findWith($id, ['bill', 'material', 'inventory',]),
        ];
    }

    public function getCreatePayload()
    {
        return [
            'materials' => $this->getter(
                model: 'material',
                callable: [
                    'select' => ['id', 'name'],
                    'with' => ['units:id,name,code'],
                    'has' => ['manufactureModel'],
                    'where' => [['type', 2]],
                ],
            ) ?? [],
            'inventories' => $this->getter(
                model: 'Inventory',
                columns: ['id', 'name', 'is_default']
            ) ?? [],
        ];
    }

    public function storeManufacturig($request)
    {
        $material = $this->firstWithWhere('material', where: [['id', $request->material_id]]);
        if (!$material->hasManufactureModel()) {
            throw new Exception('Material does not have manufacture model');
        }
        $qty = $this->getBaseUnitQuantity($material->units, $request);
        foreach ($material->manufactureModel as $baseMaterial) {
            $object = (object) ['quantity' => $baseMaterial->quantity, 'unit_id' => $baseMaterial->unit_id];

            $qtyTosubtract = $this->getBaseUnitQuantity($baseMaterial->material->units, $object, $qty);

            $inventory = $this->firstWithWhere('Inventory', ['materials:id,name'], [['id', $baseMaterial->inventory_id]], ['id', 'name']);
            $inventoryMaterial = $inventory->materials->first(function ($item) use ($baseMaterial) {
                return $item->id == $baseMaterial->material_id;
            });
            if ($inventoryMaterial->pivot->quantity < $qtyTosubtract) {
                throw new Exception("$inventoryMaterial->name is not sufficient in $inventory->name ");
            }
            $inventory->materials()->updateExistingPivot($baseMaterial->material_id, [
                'quantity' => $inventoryMaterial->pivot->quantity - $qtyTosubtract,
            ]);
        }
        $invnetoryToStore = $this->firstWithWhere('Inventory', where: [['id', $request->inventory_id]]);

        $invnetoryToStore->materials()->syncWithPivotValues($material->id, [
            'quantity' => $invnetoryToStore
                ->materials()
                ->wherePivot('material_id', $material->id)
                ->first()?->pivot?->quantity + $qty
        ], false);
        $request['bill_id'] = (new BillRepository())->add(['type' => 3])->id;
        $request['quantity'] = $qty;
        $request['cost'] = $material->manufactureModel->sum('cost') +
            $material->accounts()->where('type', 'Manufacturing')->first()?->expenses()->sum('cost') ?? 0;
        return $this->add($request->all());
    }

    public function getBaseUnitQuantity($collection, $request, $qty = 1)
    {
        $unit = $collection->first(function ($item) use ($request) {
            return $item->pivot->unit_id == $request->unit_id;
        });
        $quantity = $request->quantity;
        if (!$unit->pivot->is_default) {
            $quantity = $request->quantity * $unit->pivot->rate_to_main_unit;
        }
        return $quantity * $qty;
    }
}
