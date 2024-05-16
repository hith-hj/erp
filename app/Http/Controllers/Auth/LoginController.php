<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\LoginTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    // use AuthenticatesUsers;
    use UserLoginTrait;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email'=>['required','email','exists:users,email'],
    //         'password'=>['required','string','min:8'],
    //     ]);
    //     $user = User::where('email',$request->email)->first();
    //     if($request->generated_token === $user->device_token){
    //         auth()->attempt($request->only(['email','password']));
    //         if ($request->hasSession()) {
    //             $request->session()->put('auth.password_confirmed_at', time());
    //         }
    //         if ($response = $this->authenticated($request, $this->guard()->user())) {
    //             return $response;
    //         }
    //     }
    //     return redirect()->back()->with('error','Attempt to login on forign device ');
    // }
}
