<?php

namespace App\Http\Controllers\Expense;

use App\DataTables\ExpenseDataTable;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Expense\ExpenseRepository;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    private $repo;

    public function __construct()
    {
        $this->repo = new ExpenseRepository();
    }

    public function index()
    {
        return (new ExpenseDataTable())->render('main.expense.index');
    }

    public function show($id)
    {
        return view('main.expense.show', [
            'expense' => $this->repo->find($id),
        ]);
    }

    public function create()
    {
        return view('main.expense.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'names' => ['required', 'array', 'min:1'],
            'names.*.name' => ['required', 'string', 'unique:expenses,name'],
        ]);
        foreach ($request->names as $name) {
            $this->repo->add($name);
        }
        return redirect()
            ->route('expense.all')
            ->with('success', 'expense created');
    }

    public function delete($id)
    {
        $this->repo->delete($id);
        return redirect()
            ->route('expense.all')
            ->with('success', 'expense deleted');
    }
}
