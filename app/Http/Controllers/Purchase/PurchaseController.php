<?php

namespace App\Http\Controllers\Purchase;

use App\DataTables\PurchaseDataTable;
use App\Http\Controllers\BaseController;
use App\Http\Repositories\Purchase\PurchaseRepository;
use App\Http\Validator\Purchase\PurchaseValidator;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends BaseController
{
    private $repo;

    public function __construct()
    {
        $this->repo = new PurchaseRepository();
    }

    public function index()
    {
        $table = new PurchaseDataTable();
        return $table->render('main.purchase.index');
    }

    public function show($id)
    {
        return view('main.purchase.show',$this->repo->getShowPayload($id));
    }

    public function create()
    {
        return view('main.purchase.create', $this->repo->getCreatePayload());
    }

    public function store(Request $request)
    {
        PurchaseValidator::validate($request);
        $this->repo->storePurchase($request);
        return redirect()
            ->route('bill.show', ['id' => $request->bill_id])
            ->with('success', 'Purchase created');
    }

    public function delete(Purchase $purchase)
    {
        $this->repo->restorInventoryMaterial($purchase->id);
        $this->repo->delete($purchase->id);
        return redirect()
            ->route('bill.show', ['id' => $purchase->bill_id])
            ->with('success', 'Purchase deleted');
    }

    public function storeToBill(Request $request)
    {
        PurchaseValidator::validate($request);
        $this->repo->add($request->all());
        return $this->repo->updateInventoryMaterial($request);
    }

    public function deleteFromBill($purchase_id)
    {
        $this->repo->restorInventoryMaterial($purchase_id);
        return $this->repo->delete($purchase_id);
    }
}
