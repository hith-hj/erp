<?php 

namespace App\Http\Validator\Purchase;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PurchaseValidator
{
  public static function validate(Request $request){
    return $request->validate([
      'account' => ['required',],
      'vendor' => ['required',],
      'inventory_id' => ['required',],
      'material_id' => ['required',],
      'quantity' => ['required',],
      'unit_id' => ['required',],
      'cost' => ['required',],
      'currency_id' => ['required',],
      'rate_to' => ['required',],
      'total' => ['required',],
      'note' => ['nullable',],
      'mark' => ['required',],
      'level' => ['required',],
    ]);
  }

}