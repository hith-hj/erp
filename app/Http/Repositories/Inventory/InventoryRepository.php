<?php

namespace App\Http\Repositories\Inventory;

use App\Http\Repositories\BaseRepository;
use App\Models\Inventory;


class InventoryRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Inventory::class);
    }

    public function defaultNotExists()
    {
        return $this->getter('inventory', ['where' => [['is_default', true]] ])->isEmpty();
    }

    public function getCreatePayload()
    {
        return [
            'materials' => $this->getter(
                model: 'material',
                callable: [
                    'with' => ['manufactureModel'],
                ],
            )
        ];
    }

    public function getShowPayload($id)
    {
        return [
            'inventory' => $this->findWith($id, ['materials']),
            'materials' => $this->getter(model: 'material'),
        ];
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
                        'quantity' => $material['quantity'] + $item->first()->pivot->quantity
                    ]);
            } else {
                $inventory->materials()->attach($material['material_id'], ['quantity' => $material['quantity']]);
            }
        }
        return $inventory;
    }

    public function setDefault($id)
    {
        $this
            ->getter('inventory', ['where' => [['is_default', true]]], 'first')
            ?->update(['is_default' => false]);
        $this->update($id, ['is_default' => true]);
        return;
    }
}
