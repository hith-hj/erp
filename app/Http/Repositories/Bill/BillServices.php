<?php 

namespace App\Http\Repositories\Bill;


use App\Models\Currency;
use App\Models\Inventory;
use App\Models\Material;
use App\Models\Unit;
use App\Http\Controllers\Purchase\PurchaseController;


trait BillServices 
{
    
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
        return (new PurchaseController())->storeTobill($request);
    }
    
    
    public function deletePurchases($purchase_id)
    {
        return (new PurchaseController())->deleteFrombill($purchase_id);
    }

    
}