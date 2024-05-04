<?php 

namespace App\Http\Repositories\Vendors;

use Illuminate\Database\Eloquent\Collection;
use App\Http\Repositories\BaseRepository;
use App\Models\Vendor;

class VendorRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Vendor::class);
    }

}