<?php 

namespace App\Http\Repositories\Inventory;

use Illuminate\Database\Eloquent\Collection;
use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Material\MaterialRepository;
use App\Models\Inventory;


class InventoryRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Inventory::class);
    }

    public function checkForMaterialDuplication($data)
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