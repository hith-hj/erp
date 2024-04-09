<?php 

namespace App\Http\Repositories\Card;

use App\Http\Controllers\Shift\ShiftController;
use App\Http\Controllers\Build\BuildController;
use App\Http\Controllers\Sale\SalseController;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Repositories\BaseRepository;
use App\Models\Card;


class CardRepository implements BaseRepository
{
    public function all(array|string $columns = ['*']) : Collection
    {
        return Card::all($columns);
    }

    public function find(int $card_id, $columns = ['*']): Card
    {
        return Card::findOrFail($card_id,$columns);
    }

    public function add($request) : Card
    {        
        $request['user_id']=1;
        $request['section_id']=1;
        $card = Card::create($request->all());
        match($card->type){
            'shift'=>(new ShiftController())->store($request,$card),
            // 'build'=>(new BuildController())->store($request,$card),
            // 'build'=>(new SaleController())->store($request,$card),
            default => false,
        };        
        return $card;
    }


    public function update($request,int $card_id) :bool
    {
        $card = Card::findOrFail($card_id);        
        match($card->type){
            'shift'=>(new ShiftController())->update($request,$card_id),
            default => false,
        };
        return $card->update($request->all());
    }


    public function delete(int $card_id) : bool
    {
        $card = Card::findOrFail($card_id);
        match($card->type){
            'shift'=>$card->shift()->delete(),
            default=>false,
        };
        return $card->delete();
    }

    public function allWith(
        array|string $relation = [],
        array|string $columns = ['*'],
        ) : Collection
    {
        return Card::select($columns)->with($relation)->get();
    }

    public function paginateWith(
        int $perPage = 5,
        array|string $relation = [],
        array|string $columns = ['*'],
        ) 
    {
        return Card::with($relation)->paginate($perPage,$columns);
    }

    public function findWith(
        int $card_id,
        array|string $relation = [],
        array|string $columns = ['*']
    ) : Card 
    {
        return Card::with($relation)->findOrFail($card_id,$columns);
    }

}