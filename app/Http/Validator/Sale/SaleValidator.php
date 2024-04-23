<?php

namespace App\Http\Validator\Sale;

use Illuminate\Http\Request;

class SaleValidator
{
    public static function validate(Request $request)
    {
        return $request->validate([
            'discount' => ['nullable',],
            'client' => ['required',],
            'inventory_id' => ['required',],
            'material_id' => ['required',],
            'quantity' => ['required',],
            'unit_id' => ['required',],
            'cost' => ['required',],
            'currency_id' => ['required',],
            'rate_to' => ['required',],
            'total' => ['required',],
        ]);
    }
}
