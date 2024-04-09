<?php 

namespace App\Http\Repositories\Section;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Http\Repositories\BaseRepository;

use App\Models\Section;

class SectionRepository implements BaseRepository
{
    public function all(array|string $columns = ['*']) : Collection
    {
        return Section::all($columns);
    }

    public function find(int $card_id, $columns = ['*']): Section
    {
        return Section::find($card_id,$columns);
    }

    public function add($request) : Section
    {
        return Section::create($request->all());
    }

    public function update($request,int $card_id) : bool
    {
        return Section::find($card_id)->update($request->all());
    }

    public function delete(int $card_id) : bool
    {
        return Section::find($card_id)->delete();
    }

    public function allWith(
        array|string $relation = [],
        array|string $columnsToHide = [],
        ) : Collection
    {
        return Section::with($relation)->get()->makeHidden($columnsToHide);
    }

    public function findWith(
        int $card_id,
        array|string $relation = [],
        array|string $columns = ['*']
    ) : Section 
    {
        return Section::with($relation)->find($card_id,$columns);
    }
}