<?php

namespace App\Http\Validator\Material;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaterialValidator
{
  public static function validateMaterialDetails()
  {
    return request()->validate([
      'name' => ['required', 'string', "max:40"],
      'type' => ['required', 'numeric', 'in:1,2,3'],
      'main_material' => ['nullable', 'exists:materials,id'],
      'main_unit' => ['required', 'exists:units,id'],
      'units' => ['required', 'array', 'max:5'],
      'units.*.unit' => ['exists:units,id'],
      'units.*.rate' => ['numeric'],
    ]);
  }

  public static function preventDuplicateUnits($request)
  {
    foreach ($request->units as $key => $item) {
      if ($request->main_unit == $item['unit']) {
        $units = $request->units;
        unset($units[$key]);
        $request['units'] = $units;
      }
    }
    return $request;
  }

  public static function validateManufactureModel($request)
  {
    return $request->validate([
      'material_id' => ['required', 'exists:materials,id'],
      'inventory_to_store_id' => ['required', 'exists:inventories,id'],
      'materials' => ['required', 'array', 'min:1'],
      'materials.*.material_id' => ['required', 'exists:materials,id'],
      'materials.*.inventory_id' => ['required', 'exists:inventories,id'],
      'materials.*.unit_id' => ['required', 'exists:units,id'],
      'materials.*.currency_id' => ['required', 'exists:currencies,id'],
      'materials.*.quantity' => ['required', 'numeric'],
      'materials.*.cost' => ['required', 'numeric'],
      'expenses' => ['required', 'array', 'min:1'],
      'expenses.*.expense_id' => ['required',],
      'expenses.*.cost' => ['required', 'numeric'],
    ]);
  }
}
