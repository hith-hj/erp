<?php

namespace App\Http\Repositories\Material;;

use App\Http\Repositories\BaseRepository;
use App\Models\Material;

class MaterialRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Material::class);
    }

    public function addUnits($request, $material)
    {
        $material
            ->units()
            ->attach($request->main_unit, ['is_default' => true,]);

        foreach ($request->units as $item) {
            $material
                ->units()
                ->attach($item['unit'], [
                    'is_default' => false,
                    'main_unit' => $request->main_unit,
                    'rate_to_main_unit' => $item['rate'],
                ]);
        }
        return $material;
    }
}
