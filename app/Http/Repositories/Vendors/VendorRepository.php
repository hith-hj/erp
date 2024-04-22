<?php 

namespace App\Http\Repositories\Vendors;

use Illuminate\Database\Eloquent\Collection;
use App\Http\Repositories\BaseRepository;
use App\Models\Vendor;

class VendorRepository implements BaseRepository
{
    public function all(array|string $columns = ['*']) : Collection
    {
        return Vendor::all($columns);
    }


    public function find(int $id, $columns = ['*']): Vendor
    {
        return Vendor::findOrFail($id,$columns);
    }


    public function add($request) : Vendor
    {       
        return Vendor::create($request);
    }


    public function update($request,int $id) :bool
    {     
        return Vendor::findOrFail($id)->update($request->all());
    }


    public function delete(int|Vendor $vendor) : bool
    {
        if(! $vendor instanceof Vendor)
        {
            $vendor = Vendor::findOrFail($vendor);
        }
        return $vendor->delete();
    }


    public function allWith(
        array|string $relation = [],
        array|string $columns = ['*'],
        ) : Collection
    {
        return Vendor::select($columns)->with($relation)->get();
    }


    public function paginateWith(
        int $perPage = 5,
        array|string $relation = [],
        array|string $columns = ['*'],
        ) 
    {
        return Vendor::with($relation)->paginate($perPage,$columns);
    }


    public function findWith(
        int $id,
        array|string $relation = [],
        array|string $columns = ['*']
    ) : Vendor 
    {
        return Vendor::with($relation)->findOrFail($id,$columns);
    }

}