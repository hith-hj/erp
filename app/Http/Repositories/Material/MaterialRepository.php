<?php 

namespace App\Http\Repositories\Material;

use Illuminate\Database\Eloquent\Collection;
use App\Http\Repositories\BaseRepository;
use App\Models\Material;
use App\Models\Unit;

class MaterialRepository implements BaseRepository
{
    public function all(array|string $columns = ['*']) : Collection
    {
        return Material::all($columns);
    }

    public function find(int $id, $columns = ['*']): Material
    {
        return Material::findOrFail($id,$columns);
    }

    public function add($request) : Material
    {        
        return Material::create($request->all());
    }


    public function update($request,int $id) :bool
    {     
        return Material::findOrFail($id)->update($request->all());
    }


    public function delete(int $id) : bool
    {
        $Material = Material::findOrFail($id);
        return $Material->delete();
    }

    public function allWith(
        array|string $relation = [],
        array|string $columns = ['*'],
        ) : Collection
    {
        return Material::select($columns)->with($relation)->get();
    }

    public function paginateWith(
        int $perPage = 5,
        array|string $relation = [],
        array|string $columns = ['*'],
        ) 
    {
        return Material::with($relation)->paginate($perPage,$columns);
    }

    public function findWith(
        int $id,
        array|string $relation = [],
        array|string $columns = ['*']
    ) : Material 
    {
        return Material::with($relation)->findOrFail($id,$columns);
    }

    public function getUnits()
    {
        return Unit::all();
    }

    public function addUnits($request, $material)
    {
        $material
        ->units()
        ->attach($request->main_unit, ['is_default' => true,]);

        foreach($request->units as $item)
        {
            $material
            ->units()
            ->attach($item['unit'],[
                'is_default' => false,
                'main_unit' => $request->main_unit,
                'rate_to_main_unit' => $item['rate'],
            ]);
        }
        return $material;
    }
}