<?php

namespace App\Http\Controllers\Bill;

use App\DataTables\BillDataTable;
use App\Http\Controllers\BaseController;
use App\Http\Repositories\Bill\BillRepository;

class BillController extends BaseController
{
    private $repo;

    public function __construct()
    {
        $this->repo = new BillRepository();
    }

    public function index()
    {
        return (new BillDataTable())->render('main.bill.index');
    }
}
