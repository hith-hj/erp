<?php 

namespace App\Http\Repositories\Client;

use App\Http\Repositories\BaseRepository;
use App\Models\Client;

class ClientRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Client::class);
    }

}