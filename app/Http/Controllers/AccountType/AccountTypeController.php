<?php

namespace App\Http\Controllers\AccountType;

use App\DataTables\AccountTypeDataTable;
use App\Http\Controllers\Controller;
use App\Http\Repositories\AccountType\AccountTypeRepository;
use Illuminate\Http\Request;

class AccountTypeController extends Controller
{
    private $repo ;

    public function __construct()
    {
        $this->repo = new AccountTypeRepository();
    }

    public function index()
    {
        return (new AccountTypeDataTable())->render('main.accountType.index');
    }

    public function show($id)
    {
        return view('main.accountType.show',[
            'accountType'=>$this->repo->find($id),
        ]);
    }

    public function create()
    {
        return view('main.accountType.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'names'=>['required','array','min:1'],
            'names.*.name'=>['required','string','unique:account_types,name'],
        ]);
        foreach($request->names as $name)
        {
            $this->repo->add($name);
        }
        return redirect()
            ->route('accountType.all')
            ->with('success','account type acreated');
    }

    public function delete($id)
    {
        $this->repo->delete($id);
        return redirect()
            ->route('accountType.all')
            ->with('success','account type deleted');
    }
}
