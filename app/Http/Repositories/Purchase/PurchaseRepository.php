<?php

namespace App\Http\Repositories\Purchase;

use Illuminate\Support\Str;
use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Inventory\InventoryRepository;
use App\Models\Purchase;
use Exception;

class PurchaseRepository extends BaseRepository
{
    const Purchase_stat = ['unsaved' => 0, 'saved' => 1, 'checked' => 2, 'audited' => 3];

    public function __construct()
    {
        parent::__construct(Purchase::class);
    }

    public function getShowPayload($id)
    {
        return [
            'purchase' => $this->findWith(
                id: $id,
                relation: ['inventory', 'materials', 'user', 'vendor', 'bill']
            ),
            'currencies' => $this->getter(
                model: 'Currency',
                callable: [
                    'select' => ['id', 'name', 'code', 'is_default', 'rate_to_default'],
                ],
            ) ?? [],
            'materials' => $this->getter(
                model: 'Material',
                callable: [
                    'select' => ['id', 'name'],
                    'with' => ['units:id,name,code'],
                ]
            ) ?? [],
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
                    'select' => ['id', 'name', 'code', 'is_default', 'rate_to_default'],
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
        ];
    }

    public function storePurchase($request)
    {
        $data = $request->except('purchases');
        $data['created_by'] = auth()->id();
        if (is_null($data['inventory_id'])) {
            $data['inventory_id'] =
                $this->getter(
                    model: 'inventory',
                    callable: [
                        'where' => [['is_default', 1]],
                    ],
                    getter: 'first'
                )?->id ?? 1;
        }
        $purchase = $this->add($data);
        foreach ($request->purchases as $material) {
            $this->addMaterialToPurchase($purchase, $material);
        }
        $purchase->bill()->create([
            'billable_id' => $purchase->id,
            'billable_type' => get_class($purchase),
            'serial' => Str::random(8),
            'status' => 0,
        ]);
        return $purchase;
    }

    public function updatePurchase($request, $id)
    {
        $purchase = $this->find($id);
        foreach ($request->purchases as $material) {
            $this->addMaterialToPurchase($purchase, $material);
        }
        return $purchase;
    }

    private function addMaterialToPurchase($purchase, $material)
    {
        if (is_null($material['unit_id'])) {
            $material = $this->getter(model: 'material', callable: ['with' => ['units'],]);
            $unit = $material->units->first(function ($item) {
                return $item->pivot->is_default == 1;
            });
            $material['unit_id'] = $unit->id;
        }
        $currency = $this->getter(
            model: 'Currency',
            getter: 'first',
            callable: [
                'where' => [['id', $material['currency_id']]],
            ]
        );
        if (!$currency->is_default) {
            $defaultCurrency = $this->getter(
                model: 'Currency',
                callable: [
                    'where' => [['is_default', 1]]
                ],
                getter: 'first'
            );
        }

        $purchase->materials()
            ->attach($material['material_id'], [
                'currency_id' => $material['currency_id'],
                'quantity' => $material['quantity'],
                'unit_id' => $material['unit_id'],
                'cost' => $material['cost'],
                'rate_to' => $defaultCurrency->id ?? $currency->id,
                'rate' => $currency->rate_to_default,
            ]);
        $material['inventory_id'] = $purchase->inventory_id;
        return $this->updateInventory($material);
    }

    public function updateInventory($material)
    {
        $data = (object)$material;
        $inventoryRepo = new InventoryRepository();
        $inventory = $inventoryRepo->find($data->inventory_id);
        $material = $inventory->materials()
            ->wherePivot('material_id', $data->material_id)
            ->first();
        if (is_null($material)) {
            $material = $this->getter(
                model: 'Material',
                callable: [
                    'where' => [['id', $data->material_id]]
                ],
                getter: 'first'
            );
            return $inventory
                ->materials()
                ->attach($data->material_id, [
                    'quantity' => $this->getBaseUnitQuantity($material->units, $data)
                ]);
        }
        return $inventory->materials()
            ->updateExistingPivot($data->material_id, [
                'quantity' => $material->pivot->quantity +
                    $this->getBaseUnitQuantity($material->units, $data)
            ]);
    }

    public function editPurchase($request, $id)
    {
        $purchase = $this->find($id);
        $material = $purchase->materials()->wherePivot('material_id', $request->material_id);
        // && $purchase->materials()->count() > 1
        if ($material->exists()) {
            $material = $material->first();
            $material->inventory_id = $purchase->inventory_id;
            $this->restoreInventory($material);
            $purchase->materials()->detach($request->material_id);
        }
        return $purchase;
    }

    public function restoreInventory($material)
    {
        $inventoryRepo = new InventoryRepository();
        $inventory = $inventoryRepo->find($material->inventory_id);
        $inventoryMaterial = $inventory->materials()
            ->wherePivot('material_id', $material->pivot->material_id)
            ->first();
        $inventory->materials()
            ->updateExistingPivot($material->pivot->material_id, [
                'quantity' => $inventoryMaterial->pivot->quantity -
                    $this->getBaseUnitQuantity($inventoryMaterial->units, $material->pivot)
            ]);
        return;
    }

    public function delete(int $id): bool
    {
        $purchase = $this->findWith($id, ['materials', 'bill']);
        if ($purchase->materials()->count() > 0 || $purchase->bill->status != 0) {
            $this->throw('Purchase is not empty Can\'t be Deleted', 9);
        }
        foreach ($purchase->materials as $material) {
            $material->inventory_id = $purchase->inventory_id;
            $this->restoreInventory($material);
        }
        $purchase->materials()->detach();
        $purchase->bill()->delete();
        return $purchase->delete();
    }

    public function restoreInventoryMaterial($purchase_id)
    {
        $purchase = $this->find($purchase_id);
        $inventoryRepo = new InventoryRepository();
        $inventory = $inventoryRepo->find($purchase->inventory_id);
        foreach ($purchase->materials as $material) {
            $inventoryMaterial = $inventory
                ->materials()
                ->wherePivot('material_id', $material->id)
                ->first();
            $inventory->materials()
                ->updateExistingPivot($material->id, [
                    'quantity' => $inventoryMaterial->pivot->quantity -
                        $this->getBaseUnitQuantity($inventoryMaterial->units, $material)
                ]);
        }
        return;
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

    public function setStatus($purchase_id, $status = 0)
    {
        $purchase = $this->find($purchase_id);
        if ($purchase->materials()->count() == 0) {
            $this->throw('Purchase is Empty,Can\'t be saved', 10);
        }
        if ($purchase->bill->status != self::Purchase_stat['unsaved'] && $status == self::Purchase_stat['saved']) {
            $this->throw('Purchase Can\'t be saved', 11);
        }
        if ($purchase->bill->status != self::Purchase_stat['saved'] && $status == self::Purchase_stat['checked']) {
            $this->throw('Purchase Can\'t be checked', 12);
        }
        if ($purchase->bill->status != self::Purchase_stat['checked'] && $status == self::Purchase_stat['audited']) {
            $this->throw('Purchase Can\'t be audited', 13);
        }
        return $purchase->bill()->update(['status' => $status]);
    }

    public function save($purchase_id)
    {
        return $this->setStatus($purchase_id, self::Purchase_stat['saved']);
    }

    public function audit($purchase_id)
    {
        return $this->setStatus($purchase_id, self::Purchase_stat['audited']);
    }

    public function check($purchase_id)
    {
        return $this->setStatus($purchase_id, self::Purchase_stat['checked']);
    }
}
