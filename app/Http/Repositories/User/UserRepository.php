<?php 

namespace App\Http\Repositories\User;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Http\Repositories\BaseRepository;

use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Support\Facades\Hash;

class UserRepository implements BaseRepository
{
    public function all(array|string $columns = ['*']) : Collection
    {
        return User::all($columns);
    }

    public function find(int $id, $columns = ['*']): User
    {
        return User::findOrFail($id,$columns);
    }

    public function add($request) : User
    {
        return User::create([
            'username'=>$request->username,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'device_token'=>'pindding',
            'full_name'=>$request->full_name
        ]);
    }

    public function update($request,int $id) : bool
    {
        return User::findOrFail($id)->update($request->all());
    }

    public function delete(int $id) : bool
    {
        return User::findOrFail($id)->delete();
    }

    public function allWith(
        array|string $relation = [],
        array|string $columnsToHide = [],
        ) : Collection
    {
        return User::with($relation)->get()->makeHidden($columnsToHide);
    }

    public function findWith(
        int $id,
        array|string $relation = [],
        array|string $columns = ['*']
    ) : User 
    {
        return User::with($relation)->findOrFail($id,$columns);
    }

    public function addUserExtraInfo(Request $request ,$user)
    {
        return $user->settings()->create([
                'key'=>'phone_number',
                'value'=>$request->phone_number,            
        ]);
    }

    public function updateUserExtraInfo(Request $request ,$user)
    {
        $array = ['phone_number','phone_number_n2','address'];
        foreach($array as $setting)
        {
            if($user->settings()->where('key',$setting)->exists())
            {
                $user->settings()->where('key',$setting)->update(['value'=>$request->$setting]);
            }else{
                $user->settings()->create(['key'=>$setting,'value'=>$request->$setting]);
            }
        }
        return $user->settings();
    }
}