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
      'purchases.*.discount' => ['nullable','numeric','between:1,100'],
      'purchases.*.vendor_id' => ['required','exists:vendors,id'],
      'purchases.*.inventory_id' => ['nullable','exists:inventories,id'],
      'purchases.*.material_id' => ['required','exists:materials,id'],
      'purchases.*.quantity' => ['required','numeric','min:1'],
      'purchases.*.unit_id' => ['nullable','exists:units,id'],
      'purchases.*.cost' => ['required','numeric','min:1'],
      'purchases.*.currency_id' => ['required','exists:currencies,id'],
      'purchases.*.rate_to' => ['required','exists:currencies,id'],
      'purchases.*.total' => ['required',],
      'purchases.*.note' => ['nullable',],
      'purchases.*.mark' => ['required',],
      'purchases.*.level' => ['required',],
    ]);
  }
}
