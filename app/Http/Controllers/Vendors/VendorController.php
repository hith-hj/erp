<?php

namespace App\Http\Controllers\Vendors;

use App\DataTables\VendorDataTable;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Vendors\VendorRepository;
use App\Http\Validator\Vendors\VendorValidator;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    private $repo;

    public function __construct()
    {
        $this->repo = new VendorRepository();
    }

    public function index()
    {
        return (new VendorDataTable())->render('main.vendors.index');
    }

    public function show(Vendor $vendor)
    {
        return view('main.vendors.show', $this->repo->getShowPayload($vendor));
    }

    public function create()
    {
        return view('main.vendors.create');
    }

    public function store(Request $request)
    {
        VendorValidator::validate($request);
        foreach ($request->vendors as $vendor) {
            $this->repo->add($vendor);
        }
        return redirect()->route('vendor.all')->with('success', 'Vendors Created');
    }

    public function delete($id)
    {
        $this->repo->delete($id);
        return redirect()->route('vendor.all')->with('success', 'Vendors Deleted');
    }
}
