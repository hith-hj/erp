<?php

namespace App\Http\Validator\User;

use Illuminate\Http\Request;

class UserValidator
{
  public static function validateUserDetails(Request $request)
  {
    return $request->validate([
      'username' => ['required', 'string',],
      'email' => ['sometimes', 'required', 'email', 'unique:users,email'],
      'password' => ['sometimes', 'required', 'string', 'min:8', 'confirmed'],
      'full_name' => ['required', 'string', 'max:50'],
      'phone_number' => ['required', 'numeric', 'digits:10'],
      'phone_number_n2' => ['sometimes', 'required', 'numeric', 'digits:10'],
      'address' => ['sometimes', 'required', 'string', 'max:100']
    ]);
  }
}
