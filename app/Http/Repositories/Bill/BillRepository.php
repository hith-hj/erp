<?php

namespace App\Http\Repositories\Bill;

use Illuminate\Support\Str;
use App\Http\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Controllers\Purchase\PurchaseController;
use App\Http\Controllers\Sale\SaleController;
use App\Models\Inventory;
use App\Models\Material;
use App\Models\Currency;
use App\Models\Unit;
use App\Models\Bill;
use Exception;

class BillRepository implements BaseRepository
{
    const bill_stat = ['unsaved'=>0,'saved'=>1,'audited'=>2,'checked'=>3];


    public function all(array|string $columns = ['*']): Collection
    {
        return Bill::all($columns);
    }


    public function find(int $id, $columns = ['*']): Bill
    {
        return Bill::findOrFail($id, $columns);
    }


    public function add($request): Bill
    {
        return Bill::create([
            'serial'=> Str::random(8),
            'type'=>$request->type ?? 1,
        ]);
    }


    public function update($request, int $id): bool
    {
        return Bill::findOrFail($id)->update($request->all());
    }


    public function delete(int $id): bool
    {
        $bill = Bill::with('items')->findOrFail($id);
        if($bill->items()->count() > 0 )
        {
            foreach($bill->items as $purchase){
                $this->deletePurchases($purchase->id);
            }
            $bill->items()->delete();
        }
        return $bill->delete();
    }


    public function allWith(
        array|string $relation = [],
        array|string $columns = ['*'],
    ): Collection {
        return Bill::select($columns)->with($relation)->get();
    }


    public function paginateWith(
        int $perPage = 5,
        array|string $relation = [],
        array|string $columns = ['*'],
    ) {
        return Bill::with($relation)->paginate($perPage, $columns);
    }


    public function findWith(
        int $id,
        array|string $relation = [],
        array|string $columns = ['*']
    ): Bill {
        return Bill::with($relation)->findOrFail($id, $columns);
    }


    public function setBillStatus($bill_id,$status=0)
    {
        $bill = $this->find($bill_id);
        if($bill->items()->count() ==0)
        {
            throw new Exception('Bill is Empty,Can not be saved',10);
        }
        return $bill->update(['status'=>$status]);
    }


    public function save($bill_id)
    {
        return $this->setBillStatus($bill_id,self::bill_stat['saved']);
    }


    public function getUnits()
    {
        return Unit::all();
    }


    public function getCurrencies()
    {
        return Currency::with(['rates:id'])->get(['id','name','code']);
    }


    public function getMaterials()
    {
        return Material::with('units')->get(['id','name']);
    }

    
    public function getInventories()
    {
        return Inventory::all(['id','name']);
    }


    public function storePurchases($request)
    {
        return (new PurchaseController())->storeToBill($request);
    }
    
    
    public function deletePurchases($purchase_id)
    {
        return (new PurchaseController())->deleteFromBill($purchase_id);
    }

    public function storeSale($request)
    {
        return (new SaleController())->storeToBill($request);
    }
    
    public function deleteSale($sale_id)
    {
        return (new SaleController())->deleteFromBill($sale_id);
    }
}
