<?php

namespace App\Http\Validator\Sale;

use Illuminate\Http\Request;

class SaleValidator
{
    public static function validate(Request $request)
    {
        return $request->validate([
            'bill_id' => ['required', 'exists:bills,id'],
            'sales' => ['required', 'array', 'min:1'],
            'sales.*.discount' => ['nullable',],
            'sales.*.client_id' => ['required',],
            'sales.*.inventory_id' => ['required',],
            'sales.*.material_id' => ['required',],
            'sales.*.quantity' => ['required',],
            'sales.*.unit_id' => ['required',],
            'sales.*.cost' => ['required', 'min:1'],
            'sales.*.currency_id' => ['required',],
            'sales.*.rate_to' => ['required',],
            'sales.*.total' => ['required',],
            'sales.*.note' => ['nullable',],
            'sales.*.mark' => ['required',],
            'sales.*.level' => ['required',],
        ]);
    }
}
