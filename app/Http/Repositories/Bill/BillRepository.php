<?php

namespace App\Http\Repositories\Bill;

use Illuminate\Support\Str;
use App\Http\Repositories\BaseRepository;
use App\Http\Controllers\Purchase\PurchaseController;
use App\Http\Controllers\Sale\SaleController;
use App\Models\Bill;
use Exception;

class BillRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Bill::class);
    }
    const bill_stat = ['unsaved'=>0,'saved'=>1,'audited'=>2,'checked'=>3];

    public function add($data): Bill
    {
        $data = (object)$data;
        return Bill::create([
            'serial'=> Str::random(8),
            'type'=>$data->type ?? 1,
        ]);
    }

    public function delete(int $id): bool
    {
        $bill = $this->findWith($id,relation:'items');
        if($bill->items()->count() > 0 )
        {
            foreach($bill->items as $item){
                $this->deletePurchases($item->id);
            }
            $bill->items()->delete();
        }
        return $bill->delete();
    }
    
    public function deletePurchases($purchase_id)
    {
        return (new PurchaseController())->deleteFromBill($purchase_id);
    }
    
    public function deleteSale($sale_id)
    {
        return (new SaleController())->deleteFromBill($sale_id);
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
    
}
