<?php

namespace App\Http\Controllers\User;

use App\DataTables\UserDataTable;
use App\Http\Controllers\BaseController;
use App\Http\Repositories\User\UserRepository;
use App\Http\Validator\User\UserValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    private $repo;
    private $userValidator;

    public function __construct()
    {
        $this->repo = new UserRepository();
    }
    

    public function index()
    {
        $this->setTrails();
        $table = new UserDataTable();
        return $table->render('main.user.index');
    }

    
    public function create()
    {
        $this->setTrails();
        return view('main.user.create');
    }

    
    public function store(Request $request)
    {
        UserValidator::validateUserDetails($request);
        $user = $this->repo->add($request);
        $this->repo->addUserExtraInfo($request,$user);
        return redirect()->route('user.all');
    }

    public function show($id)
    {
        $this->setTrails([Auth::user()->full_name,]);
        return view('main.user.profile',[
            'user'=>$this->repo->findWith($id,['settings']),
        ]);
    }

   
    public function edit($id)
    {
        //
    }


    public function update(Request $request,UserValidator $valid , $id)
    {
        UserValidator::validateUserDetails($request);
        $user = $this->repo->find($id);
        $this->repo->update($request,$id);
        $this->repo->updateUserExtraInfo($request,$user);
        return redirect()->route('user.show',['id'=>$user->id])->with('success','user account is updated');
    }


    public function delete(Request $request,$user_id)
    {
        $this->repo->delete($user_id);
        return redirect()->route('user.all')->with('success','user account is deleted');
    }
}