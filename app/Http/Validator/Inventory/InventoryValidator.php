<?php

namespace App\Http\Validator\Inventory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InventoryValidator
{
  public static function validateInventorylDetails(Request $request)
  {
    return $request->validate([
      'name' => ['sometimes', 'required', 'string', 'max:50', 'min:4', 'unique:inventories,name'],
      'materials' => ['required', 'array', 'min:1',],
      'materials.*.material_id' => ['required', 'exists:materials,id'],
      'materials.*.quantity' => ['required', 'numeric', 'min:1'],
    ]);   
  }
}
