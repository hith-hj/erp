<?php 

namespace App\Http\Repositories\Client;

use Illuminate\Database\Eloquent\Collection;
use App\Http\Repositories\BaseRepository;
use App\Models\Client;

class ClientRepository implements BaseRepository
{
    public function all(array|string $columns = ['*']) : Collection
    {
        return Client::all($columns);
    }


    public function find(int $id, $columns = ['*']): Client
    {
        return Client::findOrFail($id,$columns);
    }


    public function add($request) : Client
    {       
        return Client::create($request);
    }


    public function update($request,int $id) :bool
    {     
        return Client::findOrFail($id)->update($request->all());
    }


    public function delete(int|Client $client) : bool
    {
        if(! $client instanceof Client)
        {
            $client = Client::findOrFail($client);
        }
        return $client->delete();
    }


    public function allWith(
        array|string $relation = [],
        array|string $columns = ['*'],
        ) : Collection
    {
        return Client::select($columns)->with($relation)->get();
    }


    public function paginateWith(
        int $perPage = 5,
        array|string $relation = [],
        array|string $columns = ['*'],
        ) 
    {
        return Client::with($relation)->paginate($perPage,$columns);
    }


    public function findWith(
        int $id,
        array|string $relation = [],
        array|string $columns = ['*']
    ) : Client 
    {
        return Client::with($relation)->findOrFail($id,$columns);
    }

}