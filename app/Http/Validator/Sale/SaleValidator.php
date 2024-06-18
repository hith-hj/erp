<?php

namespace App\Http\Validator\Sale;

use Illuminate\Http\Request;

class SaleValidator
{
    public static function validate(Request $request)
    {
        return $request->validate([
            'discount' => ['nullable','numeric','between:1,100'],
            'client_id' => ['required','exists:clients,id'],
            'inventory_id' => ['nullable','exists:inventories,id'],
            'note' => ['nullable','string'],
            'level' => ['required',],
            'mark' => ['required',],
            'sales' => ['required', 'array', 'min:1'],
            'sales.*.material_id' => ['required','exists:materials,id'],
            'sales.*.currency_id' => ['required','exists:currencies,id'],
            'sales.*.quantity' => ['required','numeric','min:1'],
            'sales.*.unit_id' => ['nullable','exists:units,id'],
            'sales.*.cost' => ['required','numeric','min:1'],
            'sales.*.total' => ['required','numeric'],
        ]);
    }
    
    public static function materials(Request $request)
    {
        return $request->validate([
            'sales' => ['required', 'array', 'min:1'],
            'sales.*.material_id' => ['required','exists:materials,id'],
            'sales.*.currency_id' => ['required','exists:currencies,id'],
            'sales.*.unit_id' => ['nullable','exists:units,id'],
            'sales.*.quantity' => ['required','numeric','min:1'],
            'sales.*.cost' => ['required','numeric','min:1'],
            'sales.*.total' => ['required','numeric'],
        ]);
    }
}
