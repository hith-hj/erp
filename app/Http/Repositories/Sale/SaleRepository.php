<?php

namespace App\Http\Repositories\Sale;

use Illuminate\Support\Str;
use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Inventory\InventoryRepository;
use App\Models\Sale;
use Exception;


class SaleRepository extends BaseRepository
{
    const Sale_stat = ['unsaved' => 0, 'saved' => 1, 'checked' => 2, 'audited' => 3];

    public function __construct()
    {
        parent::__construct(Sale::class);
    }

    public function getShowPayload($id)
    {
        return [
            'sale' => $this->findWith($id, ['inventory.materials.units', 'materials.units',]),
            'currencies' => $this->getter('currency'),
        ];
    }

    public function getCreatePayload()
    {
        return [
            'inventories' => $this->getter(
                model: 'Inventory',
                callable: [
                    'with' => ['materials.units:id,name'],
                ],
                columns: ['id', 'name', 'is_default']
            ) ?? [],

            'currencies' => $this->getter(
                model: 'Currency',
                callable: [
                    'select' => ['id', 'name', 'code', 'rate_to_default'],
                ]
            ) ?? [],

            'clients' => $this->getter(model: 'Client') ?? [],
        ];
    }

    public function storeSale($request)
    {
        $data = $request->except('sales');
        $data['created_by'] = auth()->id();
        if (is_null($data['inventory_id'])) {
            $data['inventory_id'] =
                $this->getter(
                    model: 'inventory',
                    getter: 'first',
                    callable: [
                        'where' => [['is_default', 1]],
                    ]
                )?->id ?? 1;
        }
        $currency = $this->getter(
            model: 'Currency',
            getter: 'first',
            callable: ['where' => [['id', $data['currency_id']]],]
        );
        if (!$currency->is_default) {
            $defaultCurrency = $this->getter(
                model: 'Currency',
                getter: 'first',
                callable: ['where' => [['is_default', 1]]]
            );
        }
        $data['rate_to'] = $defaultCurrency->id ?? $currency->id;
        $data['rate'] = $currency->rate_to_default;
        $sale = $this->add($data);
        foreach ($request->sales as $material) {
            $this->addMaterialToSale($sale, $material);
        }
        $sale->bill()->create([
            'billable_id' => $sale->id,
            'billable_type' => get_class($sale),
            'serial' => Str::random(8),
            'status' => 0,
        ]);
        return $sale;
    }

    public function updateSale($request, $id)
    {
        $sale = $this->findWith($id, ['bill']);
        if ($sale->bill->status != self::Sale_stat['unsaved']) {
            return $this->throw('Sale Can\'t be modified');
        }
        foreach ($request->sales as $material) {
            $this->addMaterialToSale($sale, $material);
        }
        return $sale;
    }

    public function addMaterialToSale($sale, $material)
    {
        $material = $this->prepareMaterial($sale, $material);

        $this->updateInventory($material);

        return $sale->materials()->attach($material['material_id'], [
            'quantity' => $material['quantity'],
            'unit_id' => $material['unit_id'],
            'cost' => $material['cost'],
        ]);
    }

    private function prepareMaterial($sale, $material)
    {
        $material['inventory_id'] = $sale->inventory_id;
        if (is_null($material['unit_id'])) {
            $item = $this->getter(
                model: 'material',
                getter: 'first',
                callable: [
                    'where' => [['id', $material['material_id']]],
                    'with' => ['units']
                ],
            );
            $unit = $item->units()->wherePivot('is_default', 1)->first();
            $material['unit_id'] = $unit->id ?? 1;
        }
        return $material;
    }

    public function editSale($request, $id)
    {
        $sale = $this->findWith($id, ['bill']);
        if ($sale->bill->status != self::Sale_stat['unsaved']) {
            return $this->throw('Sale Can\'t be modified');
        }
        $material = $sale->materials()->wherePivot('material_id', $request->material_id);
        if ($material->exists()) {
            $material = $material->first();
            $material->inventory_id = $sale->inventory_id;
            $this->restoreInventory($material);
            $sale->materials()->detach($request->material_id);
        }
        return $sale;
    }

    public function updateInventory($material)
    {
        $data = (object)$material;
        $inventoryRepo = new InventoryRepository();
        $inventory = $inventoryRepo->find($data->inventory_id);
        $material = $inventory->materials()
            ->wherePivot('material_id', $data->material_id)
            ->first();
        if (!$material) {
            $this->throw("$material->name material is not found in $inventory->name inventory");
        }

        if ($material->pivot->quantity < $this->getBaseUnitQuantity($material->units, $data)) {
            $this->throw("$material->name material in $inventory->name inventory is not suffecint to fullfil this sale");
        }
        if ($material->type == 2 && !$material->hasManufactureModel() && $material->pivot->quantity == 0) {
            $this->throw("$material->name material is not manufacturd yet");
        }
        return $inventory->materials()
            ->updateExistingPivot($data->material_id, [
                'quantity' => $material->pivot->quantity -
                    $this->getBaseUnitQuantity($material->units, $data)
            ]);
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
                'quantity' => $inventoryMaterial->pivot->quantity +
                    $this->getBaseUnitQuantity($inventoryMaterial->units, $material->pivot)
            ]);
        return;
    }

    public function delete(int $id): bool
    {
        $sale = $this->findWith($id, ['materials', 'bill']);
        if ($sale->materials()->count() > 0 || $sale->bill->status != 0) {
            return $this->throw('Sale is not empty Can\'t be Deleted', 9);
        }
        foreach ($sale->materials as $material) {
            $material->inventory_id = $sale->inventory_id;
            $this->restoreInventory($material);
        }
        $sale->materials()->detach();
        $sale->bill()->delete();
        return $sale->delete();
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

    public function setStatus($sale_id, $status = 0)
    {
        $purchase = $this->find($sale_id);
        if ($purchase->materials()->count() == 0) {
            $this->throw('Purchase is Empty,Can\'t be saved', 10);
        }
        if ($purchase->bill->status != self::Sale_stat['unsaved'] && $status == self::Sale_stat['saved']) {
            $this->throw('Purchase Can\'t be saved', 11);
        }
        if ($purchase->bill->status != self::Sale_stat['saved'] && $status == self::Sale_stat['checked']) {
            $this->throw('Purchase Can\'t be checked', 12);
        }
        if ($purchase->bill->status != self::Sale_stat['checked'] && $status == self::Sale_stat['audited']) {
            $this->throw('Purchase Can\'t be audited', 13);
        }
        return $purchase->bill()->update(['status' => $status]);
    }

    public function save($purchase_id)
    {
        return $this->setStatus($purchase_id, self::Sale_stat['saved']);
    }

    public function audit($purchase_id)
    {
        return $this->setStatus($purchase_id, self::Sale_stat['audited']);
    }

    public function check($purchase_id)
    {
        return $this->setStatus($purchase_id, self::Sale_stat['checked']);
    }
}
