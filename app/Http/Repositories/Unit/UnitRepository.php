<?php 

namespace App\Http\Repositories\Unit;

use App\Http\Repositories\BaseRepository;
use App\Models\Unit;

class UnitRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Unit::class);
    }
}