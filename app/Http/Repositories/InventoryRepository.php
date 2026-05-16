<?php

namespace App\Http\Repositories;

use App\Models\Inventory;

class InventoryRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Inventory::class);
    }

    public function defaultDontExist()
    {
        return $this->getter('inventory', ['where' => [['is_default', true]]])->isEmpty();
    }

    public function getCreatePayload()
    {
        return [
            'materials' => $this->getter(
                model: 'material',
                callable: [
                    'with' => ['manufactureModel'],
                ],
            ),
        ];
    }

    public function getShowPayloadx($id)
    {
        return [
            'inventory' => $this->findWith($id, ['materials']),
            'materials' => $this->getter(model: 'material'),
        ];
    }

    public function getShowPayload($id)
    {
        $inventory = $this->findWith($id, ['materials', 'materials.latestPurchase']);
        return [
            'inventory' => $inventory,
            'materials' => $this->getter(model: 'material'),
            'stats' => $this->getInventoryStats($inventory)
        ];
    }

    public function getInventoryStats($inventory)
    {
        return $inventory->materials->map(function ($material) {
            $quantity = $material->pivot->quantity ?? 0;
            $latestPurchase = $material->latestPurchase->first();
            $lastPrice = $latestPurchase ?
                $latestPurchase->pivot->cost * $latestPurchase->rate
                : 1;
            return [
                'material_id'         => $material->id,
                'material_name'       => $material->name,
                'quantity'       => max(0, $quantity),
                'last_price' => $lastPrice,
                'quantity_value'         => max(0, $quantity) * $lastPrice,
            ];
        });
    }

    public function checkForMaterialDuplication($data)
    {
        $data = $data['materials'];
        for ($i = 0; $i < count($data); $i++) {
            for ($j = $i + 1; $j < count($data); $j++) {
                if ($data[$i]['material_id'] == $data[$j]['material_id']) {
                    $data[$i]['quantity'] = $data[$i]['quantity'] + $data[$j]['quantity'];
                    array_splice($data, $j, 1);
                }
            }
        }

        return $data;
    }

    public function updateInventory($inventory, $materials)
    {
        foreach ($materials as $material) {
            $item = $inventory->materials()->where('material_id', $material['material_id']);
            if ($item->exists()) {
                $inventory->materials()
                    ->updateExistingPivot($material['material_id'], [
                        'quantity' => $material['quantity'] + $item->first()->pivot->quantity,
                        'status' => 1,
                    ]);
            } else {
                $inventory->materials()->attach($material['material_id'], ['quantity' => $material['quantity']]);
            }
        }

        return $inventory;
    }

    public function setDefault($id)
    {
        if (! $this->defaultDontExist()) {
            $this
                ->getter('inventory', ['where' => [['is_default', true]]], 'firstOrFail')
                ?->update(['is_default' => false]);
        }
        $this->update($id, ['is_default' => true]);
    }
}
