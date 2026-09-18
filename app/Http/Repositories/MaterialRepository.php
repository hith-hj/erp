<?php

namespace App\Http\Repositories;

use App\Models\Account;
use App\Models\Material;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class MaterialRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Material::class);
    }

    public function getShowPayload($id)
    {
        $material = $this->findWith($id, ['inventories', 'units']);
        return [
            'material' => $material,
            'stats' => $this->getMaterialStats($material)
        ];
    }

    public function getMaterialStats($material)
    {
        $material->load([
            'purchases.bill',
            'purchases.currency',
            'sales.bill',
            'sales.currency'
        ]);
        $purchases = $this->transformTransactions($material->purchases);
        $sales = $this->transformTransactions($material->sales);
        return $purchases->concat($sales)->all();
    }

    private function transformTransactions(Collection $transactions, bool $addInventories = false)
    {
        return $transactions->map(function ($transaction) use ($addInventories) {
            $quantity = $transaction->pivot->quantity ?? 0;
            $price = $transaction->pivot->cost ?? 0;
            $rate = $transaction->currency->rate ?? 1;

            $result = [
                'date'      => $transaction->created_at,
                'bill_id' => $transaction->bill->id,
                'bill_type' => $transaction->bill->getType,
                'quantity'  => $quantity,
                'price'     => $price,
                'currency'  => $transaction->currency->name ?? 'N/A',
                'rate'      => $rate,
                'total'     => $quantity * $price * $rate
            ];

            if ($addInventories) {
                $inventoryId = $transaction->inventory_id ?? 'unknown';
                $inventoryName = $transaction->inventory?->name ?? 'unknown';
                $result['inventory_id'] = $inventoryId;
                $result['inventory_name'] = $inventoryName;
            }
            return $result;
        });
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
            ->attach($request->main_unit, ['is_default' => true]);

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

    public function getCreateManufactureModelPayload(int $id)
    {
        return [
            'material' => $this->find($id),
            'materials' => $this->getter(
                model: 'Material',
                callable: [
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
            $expense = (object) $expense;
            $account->expenses()->attach($expense->expense_id, [
                'cost' => $expense->cost,
                'note' => $expense->note,
            ]);
        }

        return $material;
    }

    public function getStatisticsPayload()
    {
        return [
            'materials' => $this->getter(
                model: 'material',
                callable: ['has' => ['inventories'], 'with' => ['inventories:id,name,is_default']],
                columns: ['id', 'name']
            ),
        ];
    }

    public function getMaterialInventoriesStats(Material $material, ?array $inventories = [])
    {
        $withInventories = (bool) (is_array($inventories) && count($inventories) > 0);
        $material->load([
            'inventories' => function ($query) use ($withInventories, $inventories) {
                $query->when(
                    $withInventories,
                    fn($q) => $q->whereIn('inventory_id', array_map('intval', array_values($inventories)))
                );
            },
            'purchases' => function ($query) use ($withInventories, $inventories) {
                $query
                    ->with(['bill', 'currency'])
                    ->when(
                        $withInventories,
                        fn($q) => $q->whereIn('inventory_id', array_map('intval', array_values($inventories)))
                    );
            },
            'sales' => function ($query) use ($withInventories, $inventories) {
                $query
                    ->with(['bill', 'currency'])
                    ->when(
                        $withInventories,
                        fn($q) => $q->whereIn('inventory_id', array_map('intval', array_values($inventories)))
                    );
            },
        ]);
        $purchases = $this->transformTransactions($material->purchases, $withInventories);
        $sales = $this->transformTransactions($material->sales, $withInventories);

        $collection = $purchases->concat($sales);
        return [
            'withInventories' => $withInventories,
            'collection' => $withInventories ?
                $collection->groupBy('inventory_name')->all() :
                $collection->all(),
        ];
    }
}
