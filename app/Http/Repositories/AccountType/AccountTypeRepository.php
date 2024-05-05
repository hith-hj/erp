<?php 

namespace App\Http\Repositories\AccountType;

use App\Http\Repositories\BaseRepository;
use App\Models\AccountType;

class AccountTypeRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(AccountType::class);
    }
}