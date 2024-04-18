<?php

namespace App\Http\Validator\Material;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaterialValidator
{
  public static function validateMaterialDetails(Request $request)
  {
    return $request->validate([
      'name' => ['required', 'string', "max:40"],
      'type' => ['required', 'numeric', 'in:1,2,3'],
      'main_unit' => ['nullable', 'exists:units,id'],
      'units' => ['required', 'array', 'max:5'],
      'units.*.unit' => ['exists:units,id'],
      'units.*.rate' => ['numeric'],
    ]);
  }

  public static function preventDublicateUnits($request)
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
}
