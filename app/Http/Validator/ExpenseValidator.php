<?php

namespace App\Http\Validator;

class ExpenseValidator
{
    public static function validateExpenseStore($request)
    {
        return $request->validate([
            'names' => ['required', 'array', 'min:1'],
            'names.*.name' => ['required', 'string', 'unique:expenses,name'],
        ]);
    }

    public static function validateExpenseStatistics($request)
    {
        return $request->validate([
            'expenses' => ['nullable', 'array',],
            'expenses.*' => ['nullable', 'exists:expenses,id'],
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date'],
        ]);
    }
}
