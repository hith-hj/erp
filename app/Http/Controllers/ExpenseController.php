<?php

namespace App\Http\Controllers;

use App\DataTables\ExpenseDataTable;
use App\Http\Repositories\ExpenseRepository;
use App\Http\Validator\ExpenseValidator;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    private $repo;

    public function __construct()
    {
        $this->repo = new ExpenseRepository;
    }

    public function index()
    {
        return (new ExpenseDataTable)->render('main.expense.index');
    }

    public function show($id)
    {
        return view('main.expense.show', [
            'expense' => $this->repo->find($id),
        ]);
    }

    public function statistics()
    {
        return view('main.expense.statistics', ['expenses' => $this->repo->all()]);
    }

    public function getStatistics(Request $request)
    {
        ExpenseValidator::validateExpenseStatistics($request);
        $result = $this->repo->getExpensesStats($request->all());

        return view('main.expense.statistics', [
            'result' => $result,
            'expenses' => $this->repo->all()
        ]);
    }

    public function create()
    {
        return view('main.expense.create');
    }

    public function store(Request $request)
    {
        ExpenseValidator::validateExpenseSTore($request);

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
