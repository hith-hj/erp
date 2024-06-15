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
      'mark' => ['required', 'numeric'],
      'level' => ['required', 'numeric'],
      'note' => ['nullable', 'string', 'max:150'],
      'vendor_id' => ['required', 'exists:vendors,id'],
      'discount' => ['nullable', 'numeric', 'between:1,100'],
      'inventory_id' => ['nullable', 'exists:inventories,id'],
      'purchases' => ['required', 'array', 'min:1'],
      'purchases.*.total' => ['required', 'numeric'],
      'purchases.*.cost' => ['required', 'numeric', 'min:1'],
      'purchases.*.unit_id' => ['nullable', 'exists:units,id'],
      'purchases.*.quantity' => ['required', 'numeric', 'min:1'],
      'purchases.*.material_id' => ['required', 'exists:materials,id'],
      'purchases.*.currency_id' => ['required', 'exists:currencies,id'],
    ]);
  }

  public static function purchases(Request $request)
  {
    return $request->validate([
      'purchases' => ['required', 'array', 'min:1'],
      'purchases.*.total' => ['required', 'numeric'],
      'purchases.*.cost' => ['required', 'numeric', 'min:1'],
      'purchases.*.unit_id' => ['nullable', 'exists:units,id'],
      'purchases.*.quantity' => ['required', 'numeric', 'min:1'],
      'purchases.*.material_id' => ['required', 'exists:materials,id'],
      'purchases.*.currency_id' => ['required', 'exists:currencies,id'],
    ]);
  }
}
