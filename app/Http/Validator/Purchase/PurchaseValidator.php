<?php

namespace App\Http\Validator\Purchase;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PurchaseValidator
{
  public static function validate(Request $request)
  {
    return $request->validate([
      'bill_id' => ['required', 'exists:bills,id'],
      'purchases' => ['required', 'array', 'min:1'],
      'purchases.*.discount' => ['nullable',],
      'purchases.*.vendor_id' => ['required',],
      'purchases.*.inventory_id' => ['required',],
      'purchases.*.material_id' => ['required',],
      'purchases.*.quantity' => ['required',],
      'purchases.*.unit_id' => ['required',],
      'purchases.*.cost' => ['required',],
      'purchases.*.currency_id' => ['required',],
      'purchases.*.rate_to' => ['required',],
      'purchases.*.total' => ['required',],
      'purchases.*.note' => ['nullable',],
      'purchases.*.mark' => ['required',],
      'purchases.*.level' => ['required',],
    ]);
  }
}
