<?php 

namespace App\Http\Validator\Inventory;

use App\Models\Material;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InventoryValidator
{
  public static function validateInventorylDetails(Request $request){
    return $request->validate([
      'name'=>['sometimes','required','string','max:50','min:4','unique:inventories,name'],
      'materials'=>[
        'required',
        'array',
        'min:1',
      ],
      'materials.*'=>['integer',function($attribute, $value, $fail) {
          if (!Material::where('id',explode('.',$attribute)[1])->exists()) {
              return $fail($attribute.' is invalid.');
          }

      },]
      
    ]);
  }

}