<?php 

namespace App\Http\Repositories\Unit;

use Illuminate\Database\Eloquent\Collection;
use App\Http\Repositories\BaseRepository;
use App\Models\Unit;

class UnitRepository implements BaseRepository
{
    public function all(array|string $columns = ['*']) : Collection
    {
        return Unit::all($columns);
    }


    public function find(int $id, $columns = ['*']): Unit
    {
        return Unit::findOrFail($id,$columns);
    }


    public function add($request) : Unit
    {       
        return Unit::create($request);
    }


    public function update($request,int $id) :bool
    {     
        return Unit::findOrFail($id)->update($request->all());
    }


    public function delete(int|Unit $unit) : bool
    {
        if(! $unit instanceof Unit)
        {
            $unit = Unit::findOrFail($unit);
        }
        return $unit->delete();
    }


    public function allWith(
        array|string $relation = [],
        array|string $columns = ['*'],
        ) : Collection
    {
        return Unit::select($columns)->with($relation)->get();
    }


    public function paginateWith(
        int $perPage = 5,
        array|string $relation = [],
        array|string $columns = ['*'],
        ) 
    {
        return Unit::with($relation)->paginate($perPage,$columns);
    }


    public function findWith(
        int $id,
        array|string $relation = [],
        array|string $columns = ['*']
    ) : Unit 
    {
        return Unit::with($relation)->findOrFail($id,$columns);
    }

}