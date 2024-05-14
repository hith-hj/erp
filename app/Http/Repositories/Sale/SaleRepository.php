<?php

namespace App\Http\Repositories\Sale;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Bill\BillRepository;
use App\Http\Repositories\Inventory\InventoryRepository;
use App\Models\Sale;
use Exception;


class SaleRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Sale::class);
    }

    public function getShowPayload($id)
    {
        return [
            'sale' => $this->findWith($id, ['inventory', 'material', 'currency'])
        ];
    }

    public function getCreatePayload()
    {
        return [
            'inventories' => $this->getter(
                model: 'Inventory',
                columns: ['id', 'name']
            ) ?? [],

            'currencies' => $this->getter(
                model: 'Currency',
                callable:[
                    'select'=> ['id', 'name', 'code'],
                    'with' => ['rates:id,name'],
                ]
            ) ?? [],

            'materials' => $this->getter(
                model: 'Material',
                callable:[
                    'select'=> ['id', 'name'],
                    'with' => ['inventories', 'units'],
                    'has' => ['inventories','>',0]
                ]
            ) ?? [],

            'clients' => $this->getter(model: 'Client') ?? [],

            'bill' => (new BillRepository())->add(['type' => 2]),
        ];
    }

    public function storeSale($request)
    {
        foreach ($request->sales as $sale) {
            $sale['bill_id'] = $request->bill_id;
            $sale['created_by'] = auth()->user()->id;
            if (is_null($sale['inventory_id'])) {
                $sale['inventory_id'] =
                    $this->firstWithWhere('inventory', where: [['is_default', 1]])?->id ?? 1;
            }
            if (is_null($sale['unit_id'])) {
                $material = $this->firstWithWhere(
                    model: 'material',
                    with: ['units']
                );
                $unit = $material->units->first(function ($item) {
                    return $item->pivot->is_default == 1;
                });
                $sale['unit_id'] = $unit->id;
            }
            $this->updateInventoryMaterial($sale);
            $this->add($sale);
        }
        return;
    }

    public function updateInventoryMaterial($request)
    {
        $data = (object)$request;
        $inventoryRepo = new InventoryRepository();
        $inventory = $inventoryRepo->find($data->inventory_id);
        $material = $inventory->materials()
            ->wherePivot('material_id', $data->material_id)
            ->first();
        if (!$material) {
            throw new Exception("$material->name material is not found in $inventory->name inventory");
        }

        if ($material->pivot->quantity < $this->getBaseUnitQuantity($material->units, $data)) {
            throw new Exception("$material->name material in $inventory->name inventory is not suffecint to fullfil this sale");
        }

        if ($material->type == 2 && !$material->hasManufactureModel()) {
            throw new Exception("$material->name material is not manufacturd yet");
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
