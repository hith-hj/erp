<?php

namespace App\Http\Controllers\Purchase;

use App\DataTables\PurchaseDataTable;
use App\Http\Controllers\BaseController;
use App\Http\Repositories\Purchase\PurchaseRepository;
use App\Http\Validator\Purchase\PurchaseValidator;
use Exception;
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
        return view('main.purchase.show', $this->repo->getShowPayload($id));
    }

    public function create()
    {
        return view('main.purchase.create', $this->repo->getCreatePayload());
    }

    public function store(Request $request)
    {
        PurchaseValidator::validate($request);
        $purchase = $this->repo->storePurchase($request);
        return redirect()
            ->route('purchase.show', ['id' => $purchase->id])
            ->with('success', 'Purchase created');
    }

    public function delete(int $id)
    {
        try {
            $this->repo->delete($id);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        return redirect()
            ->route('purchase.all')
            ->with('success', 'Purchase deleted');
    }

    public function addMaterial(Request $request, $id)
    {
        PurchaseValidator::purchases($request);
        try {
            $this->repo->updatePurchase($request, $id);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        return back()->with('success', 'Material Added');
    }

    public function deleteMaterial(Request $request, $id)
    {
        try {
            $this->repo->editPurchase($request, $id);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        return back()->with('success', 'Material Removed');
    }

    public function save($purchase_id)
    {
        try {
            $this->repo->save($purchase_id);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
        return back()->with('success', 'Purchase Saved');
    }

    public function audit($purchase_id)
    {
        try {
            $this->repo->audit($purchase_id);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
        return back()->with('success', 'Purchase Audited');
    }

    public function check($purchase_id)
    {
        try {
            $this->repo->check($purchase_id);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
        return back()->with('success', 'Purchase Checked');
    }
}
