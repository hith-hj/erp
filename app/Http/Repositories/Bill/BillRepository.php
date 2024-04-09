<?php

namespace App\Http\Repositories\Bill;

use Illuminate\Support\Str;
use App\Http\Repositories\BaseRepository;
use App\Models\Bill;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class BillRepository implements BaseRepository
{
    const bill_stat = ['unsaved'=>0,'saved'=>1,'audited'=>2,'checked'=>3];
    use BillServices;
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
        dd($bill);
    }

    public function save($bill_id)
    {
        return $this->setBillStatus($bill_id,self::bill_stat['saved']);
    }
}
