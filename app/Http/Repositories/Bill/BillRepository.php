<?php

namespace App\Http\Repositories\Bill;

use App\Http\Repositories\BaseRepository;
use App\Models\Bill;

class BillRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Bill::class);
    }

}
