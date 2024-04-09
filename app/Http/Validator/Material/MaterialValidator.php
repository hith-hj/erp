<?php 

namespace App\Http\Validator\Material;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaterialValidator
{
  public static function validateMaterialDetails(Request $request){
    return $request->validate([
      'name'=>['required','string',"max:40"],
      'type'=>['required','numeric','in:1,2,3'],
      'base_unit'=>['required','exists:units,id'],
      'units'=>['required','array','max:5'],
      'units.*'=>['exists:units,id']
    ]);
  }

  public static function preventDublicateUnits($request)
  {
    if(key_exists(($key = array_search($request->base_unit,$request->units)),$request->units)){
      $units = $request->units;
      unset($units[$key]);
      $request['units'] = $units;
    }
    return $request;
  }

}