<?php

namespace App\Http\Repositories\Material;;

use App\Http\Repositories\BaseRepository;
use App\Models\Account;
use App\Models\Material;

class MaterialRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Material::class);
    }

    public function getShowPayload($id)
    {
        return [
            'material' => $this->findWith($id, ['inventories', 'units',]),
        ];
    }
    
    public function getCreatePayload()
    {
        return [
            'units' => $this->getter('unit', columns: ['id', 'name', 'code']),
            'materials' => $this->all(['id', 'name']),
        ];
    }

    public function addUnits($request, $material)
    {
        $material
            ->units()
            ->attach($request->main_unit, ['is_default' => true,]);

        foreach ($request->units as $item) {
            $material
                ->units()
                ->attach($item['unit'], [
                    'is_default' => false,
                    'main_unit' => $request->main_unit,
                    'rate_to_main_unit' => $item['rate'],
                ]);
        }
        return $material;
    }

    public function getCreateManufactureModelPayload($id)
    {
        return [
            'material' => $this->find($id),
            'materials' => $this->getter(
                model: 'Material',
                callable:[
                    'with' => ['units', 'inventories'],
                    'where' => [['type', 1]],
                ]
            ),
            'currencies' => $this->getter(
                model: 'Currency',
                columns: ['id', 'name']
            ),
            'inventories' => $this->getter(
                model: 'Inventory',
                columns: ['id', 'name']
            ),
            'expenses' => $this->getter(
                model: 'Expense',
                columns: ['id', 'name']
            ),
            'accountTypes' => $this->getter(
                model: 'accountType',
                columns: ['id', 'name'],
            ),
        ];
    }

    public function storeMaterialManufactureModel($request)
    {
        $material = $this->find($request->material_id);
        foreach ($request->materials as $item) {
            $material->manufactureModel()->create($item);
        }
        
        $account = Account::create([
            'type' => $request->account_id,
            'accountable_id' => $material->id,
            'accountable_type' => get_class($material),
        ]);

        foreach ($request->expenses as $expense) {
            $expense = (object)$expense;
            $account->expenses()->attach($expense->expense_id, [
                'cost' => $expense->cost,
                'note' => $expense->note,
            ]);
        }
        return $material;
    }
}
