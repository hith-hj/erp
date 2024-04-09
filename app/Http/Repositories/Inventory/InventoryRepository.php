<?php 

namespace App\Http\Repositories\Inventory;

use Illuminate\Database\Eloquent\Collection;
use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Material\MaterialRepository;
use App\Models\Inventory;


class InventoryRepository implements BaseRepository
{
    public function all(array|string $columns = ['*']) : Collection
    {
        return Inventory::all($columns);
    }

    public function find(int $id, $columns = ['*']): Inventory
    {
        return Inventory::findOrFail($id,$columns);
    }

    public function add($request) : Inventory
    {        
        $Inventory = Inventory::create($request->all());       
        return $Inventory;
    }


    public function update($request,int $id) :bool
    {
        $Inventory = Inventory::findOrFail($id);        
        return $Inventory->update($request->all());
    }


    public function delete(int $id) : bool
    {
        $Inventory = Inventory::findOrFail($id);
        return $Inventory->delete();
    }

    public function allWith(
        array|string $relation = [],
        array|string $columns = ['*'],
        ) : Collection
    {
        return Inventory::select($columns)->with($relation)->get();
    }

    public function paginateWith(
        int $perPage = 5,
        array|string $relation = [],
        array|string $columns = ['*'],
        ) 
    {
        return Inventory::with($relation)->paginate($perPage,$columns);
    }

    public function findWith(
        int $id,
        array|string $relation = [],
        array|string $columns = ['*']
    ) : Inventory 
    {
        return Inventory::with($relation)->findOrFail($id,$columns);
    }

    public function getMaterial()
    {
        return (new MaterialRepository())->all();
    }

}