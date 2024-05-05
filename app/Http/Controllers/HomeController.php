<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('main.main');
    }

    public function changePasswordForm(User $user)
    {
        return view('auth.passwords.reset', ['user' => $user]);
    }

    public function changePassword(Request $request, User $user)
    {
        $request->validate([
            'old_password' => ['required', 'string', 'min:8'],
            'new_password' => ['required', 'string', 'confirmed'],
        ]);
        if (Hash::check($request->old_password, $user->password)) {
            $user->update(['password' => Hash::make($request->new_password)]);;
            return redirect('/')->with('success', 'password Changed');
        } else {
            return redirect('/')->with('error', 'old password dont match our records');
        }
    }

    public function themeCustomizer(Request $request)
    {
        $data = [
            'theme' => $request->skinColor,
            'navbarColor' => $request->navColor,
            'verticalMenuNavbarType' => $request->navType,
        ];
        foreach ($data as $key => $value) {
            if (!is_null($value)) {
                UserSetting::updateOrCreate(['key' => $key], [
                    'user_id' => auth()->user()->id,
                    'value' => $value,
                ]);
            }
        }
        return redirect('/')->with('success', 'theme stored');
    }
}
