<?php

namespace App\Http\Validator\User;

use Illuminate\Http\Request;

class UserValidator
{
  public static function validateUserDetails(Request $request)
  {
    return $request->validate([
      'username' => ['required', 'string',],
      'full_name' => ['required', 'string', 'max:50'],
      'email' => ['required', 'email', 'unique:users,email'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
      'phone_number' => ['required', 'numeric', 'digits:10'],
    ]);
  }
  
  public static function validateUpdates(Request $request)
  {
    return $request->validate([
      'full_name' => ['required', 'string', 'max:50'],
      'phone_number' => ['required','numeric', 'digits:10'],
      'phone_number_n2' => ['nullable', 'numeric', 'digits:10'],
      'address' => ['nullable', 'string', 'max:100']
    ]);
  }
}
