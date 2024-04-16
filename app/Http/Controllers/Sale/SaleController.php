<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\BaseController;
use App\Http\Repositories\Sale\SaleRepository;
use App\Http\Validator\Sale\SaleValidator;
use Illuminate\Http\Request;

class SaleController extends BaseController
{
    private $repo;


    public function __construct()
    {
        $this->repo = new SaleRepository(); 
    }

    public function index()
    {
        return 'sales';
    }

    public function storeToBill(Request $request)
    {
        SaleValidator::validate($request);
        try {
            $this->repo->updateInventoryMaterial($request);
            $sale = $this->repo->add($request);
        } catch (\Throwable $th) {
            return back()->with('error',$th->getMessage());
        }
    }

    public function deleteFromBill($sale_id)
    {
        $this->repo->restorInventoryMaterial($sale_id);
        return $this->repo->delete($sale_id);
    }
}
