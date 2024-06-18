<?php

namespace App\Http\Repositories\Manufacturing;


use Illuminate\Support\Str;
use App\Http\Repositories\BaseRepository;
use App\Models\Manufacturing;

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

    /**
     * this fucked up function
     * get the manufuctered material with its manufacturing models
     * then for each manufacturing model calculate the quantity and update inventory
     * then store the manufactured material in inventory 
     * then store it and create bill for it
     *  */
    public function storeManufacturig($request)
    {
        $material = $this->getter(
            model: 'material',
            getter: 'first',
            callable: [
                'with' => ['manufactureModel'],
                'where' => [['id', $request->material_id]]
            ]
        );
        if (!$material->hasManufactureModel()) {
            $this->throw('Material does not have manufacture model');
        }
        $qty = $this->getBaseUnitQuantity($material->units, $request);
        foreach ($material->manufactureModel as $baseMaterial) {
            $object = (object) ['quantity' => $baseMaterial->quantity, 'unit_id' => $baseMaterial->unit_id];

            $qtyTosubtract = $this->getBaseUnitQuantity($baseMaterial->material->units, $object, $qty);

            $inventory = $this->getter(
                model: 'Inventory',
                getter: 'first',
                callable: [
                    'select' => ['id', 'name'],
                    'with' => ['materials:id,name'],
                    'where' => [['id', $baseMaterial->inventory_id]],
                ]
            );

            $inventoryMaterial = $inventory->materials()->wherePivot('material_id', $baseMaterial->material_id)->first();
            if ($inventoryMaterial->pivot->quantity < $qtyTosubtract) {
                $this->throw("$inventoryMaterial->name is not sufficient in $inventory->name ");
            }
            $inventory->materials()->updateExistingPivot($baseMaterial->material_id, [
                'quantity' => $inventoryMaterial->pivot->quantity - $qtyTosubtract,
            ]);
        }
        $invnetoryToStore = $this->getter(
            model: 'Inventory',
            getter: 'first',
            callable: [
                'where' => [['id', $request->inventory_id]],
            ]
        );
        $invnetoryToStore->materials()->syncWithPivotValues($material->id, [
            'quantity' => $invnetoryToStore
                ->materials()
                ->wherePivot('material_id', $material->id)
                ->first()?->pivot?->quantity + $qty
        ], false);
        $request['quantity'] = $qty;
        $request['cost'] = $material->manufactureModel->sum('cost') +
            $material->accounts()
            ->where('type', 'Manufacturing')
            ->first()?->expenses()
            ->sum('cost') ?? 0;

        $manufacturing = $this->add($request->all());
        $manufacturing->bill()->create([
            'billable_id' => $manufacturing->id,
            'billable_type' => get_class($manufacturing),
            'serial' => Str::random(8),
            'status' => 0,
        ]);
        return $manufacturing;
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
