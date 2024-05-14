<?php

namespace App\Http\Controllers\Sale;

use App\DataTables\SaleDataTable;
use App\Http\Controllers\BaseController;
use App\Http\Repositories\Sale\SaleRepository;
use App\Http\Validator\Sale\SaleValidator;
use App\Models\Sale;
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
        return (new SaleDataTable())->render('main.sale.index');
    }

    public function show($id)
    {
        return view('main.sale.show', $this->repo->getShowPayload($id));
    }

    public function create()
    {
        return view('main.sale.create', $this->repo->getCreatePayload());
    }

    public function store(Request $request)
    {
        SaleValidator::validate($request);
        try {
            $this->repo->storeSale($request);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
        return redirect()
            ->route('bill.show', ['id' => $request->bill_id])
            ->with('success', 'Sale Created');
    }

    public function delete(Sale $sale)
    {
        $this->repo->restorInventoryMaterial($sale->id);
        $this->repo->delete($sale->id);
        return redirect()->route('bill.show', ['id' => $sale->bill_id]);
    }

    public function storeToBill(Request $request)
    {
        SaleValidator::validate($request);
        try {
            $this->repo->updateInventoryMaterial($request);
            $sale = $this->repo->add($request->all());
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function deleteFromBill($sale_id)
    {
        $this->repo->restorInventoryMaterial($sale_id);
        return $this->repo->delete($sale_id);
    }
}
