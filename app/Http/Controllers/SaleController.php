<?php

namespace App\Http\Controllers;

use App\DataTables\SaleDataTable;
use App\Http\Repositories\SaleRepository;
use App\Http\Validator\SaleValidator;
use Illuminate\Http\Request;

class SaleController extends BaseController
{
    private $repo;

    public function __construct()
    {
        $this->repo = new SaleRepository;
    }

    public function index()
    {
        return (new SaleDataTable)->render('main.sale.index');
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
            $sale = $this->repo->storeSale($request);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
        return redirect()
            ->route('sale.show', ['id' => $sale->id])
            ->with('success', 'Sale Created');
    }

    public function addMaterial(Request $request, $id)
    {
        SaleValidator::materials($request);
        try {
            $this->repo->updateSale($request, $id);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Material Added');
    }

    public function deleteMaterial(Request $request, $id)
    {
        try {
            $this->repo->editSale($request, $id);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Material Removed');
    }

    public function delete($id)
    {
        try {
            $this->repo->delete($id);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('sale.all')
            ->with('success', 'Sale deleted');
    }

    public function save($sale_id)
    {
        try {
            $this->repo->save($sale_id);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }

        return back()->with('success', 'Sale Saved');
    }

    public function audit($sale_id)
    {
        try {
            $this->repo->audit($sale_id);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }

        return back()->with('success', 'Sale Audited');
    }

    public function check($sale_id)
    {
        try {
            $this->repo->check($sale_id);
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }

        return back()->with('success', 'Sale Checked');
    }

    public function materialsReturns(Request $request, $id)
    {
        SaleValidator::materialReturns($request);
        if ($id != $request->sale_id) {
            return back()->with('error', 'invalid operation');
        }
        try {
            $purchase = $this->repo->find($id);
            $this->repo->materialsReturn($purchase, $request->except(['_token', 'sale_id']));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Material is returned');
    }
}
