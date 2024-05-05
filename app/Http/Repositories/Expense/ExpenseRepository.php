<?php 

namespace App\Http\Repositories\Expense;

use App\Http\Repositories\BaseRepository;
use App\Models\Expense;

class ExpenseRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Expense::class);
    }
}