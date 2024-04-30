<?php 

namespace App\Http\Repositories\Currency;


use App\Http\Repositories\BaseRepository;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;

class CurrencyRepository implements BaseRepository
{
    public function all(array|string $columns = ['*']) : Collection
    {
        return Currency::all($columns);
    }


    public function find(int $id, $columns = ['*']): Currency
    {
        return Currency::findOrFail($id,$columns);
    }


    public function add($data) : Currency
    {       
        return Currency::create($data);
    }


    public function update($data,int $id) :bool
    {     
        return Currency::findOrFail($id)->update($data);
    }


    public function delete(int|Currency $unit) : bool
    {
        if(! $unit instanceof Currency)
        {
            $unit = Currency::findOrFail($unit);
        }
        return $unit->delete();
    }


    public function allWith(
        array|string $relation = [],
        array|string $columns = ['*'],
        ) : Collection
    {
        return Currency::select($columns)->with($relation)->get();
    }


    public function paginateWith(
        int $perPage = 5,
        array|string $relation = [],
        array|string $columns = ['*'],
        ) 
    {
        return Currency::with($relation)->paginate($perPage,$columns);
    }


    public function findWith(
        int $id,
        array|string $relation = [],
        array|string $columns = ['*']
    ) : Currency 
    {
        return Currency::with($relation)->findOrFail($id,$columns);
    }
}