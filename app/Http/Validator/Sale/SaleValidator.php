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
            'sales.*.discount' => ['nullable','numeric','between:1,100'],
            'sales.*.client_id' => ['required','exists:clients,id'],
            'sales.*.inventory_id' => ['nullable','exists:inventories,id'],
            'sales.*.material_id' => ['required','exists:materials,id'],
            'sales.*.quantity' => ['required','numeric','min:1'],
            'sales.*.unit_id' => ['nullable','exists:units,id'],
            'sales.*.cost' => ['required','numeric','min:1'],
            'sales.*.currency_id' => ['required','exists:currencies,id'],
            'sales.*.rate_to' => ['required','exists:currencies,id'],
            'sales.*.total' => ['required',],
            'sales.*.note' => ['nullable',],
            'sales.*.mark' => ['required',],
            'sales.*.level' => ['required',],
        ]);
    }
}
