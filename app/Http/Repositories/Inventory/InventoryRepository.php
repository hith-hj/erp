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

    public function add($data) : Inventory
    {        
        return Inventory::create($data);       
    }

    public function update($data,int $id) :bool
    {
        return Inventory::findOrFail($id)->update($data);
    }

    public function delete(int $id) : bool
    {
        return Inventory::findOrFail($id)->delete();
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

    public function checkForMaterialDoublication($data)
    {
        $data = $data['materials'];
        for($i = 0 ; $i < count($data) ; $i++ )
        {
            for($j = $i+1 ; $j < count($data) ; $j++ )
            {
                if($data[$i]['material_id'] == $data[$j]['material_id'])
                {
                    $data[$i]['quantity'] = $data[$i]['quantity'] + $data[$j]['quantity'];
                    array_splice($data,$j,1);
                }
            }
        }
        return $data;
    }
}