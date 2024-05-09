<?php

namespace App\Http\Repositories\User;

use App\Models\User;
use App\Http\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(User::class);
    }

    public function addUserExtraInfo(Request $request, $user)
    {
        return $user->settings()->create([
            'key' => 'phone_number',
            'value' => $request->phone_number,
        ]);
    }

    public function updateUserExtraInfo(Request $request, $user)
    {
        $array = ['phone_number', 'phone_number_n2', 'address'];
        foreach ($array as $setting) {
            if ($user->settings()->where('key', $setting)->exists()) {
                $user->settings()->where('key', $setting)->update(['value' => $request->$setting]);
            } else {
                $user->settings()->create(['key' => $setting, 'value' => $request->$setting]);
            }
        }
        return $user->settings();
    }
}
