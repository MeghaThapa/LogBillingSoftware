<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    public function index()
    {
       $users=User:: get(['id','name','email','role','created_at']);

        return view('user.index',['users'=>$users]);
    }
    public function add()
    {
       
        return view('user.create');
    }
    public function store(Request $request)
    {
        $user= new User();
        $user-> name=$request->name;
        $user->email=$request->email;
        $user->password=bcrypt($request->password);
        $user->role=$request->position;

        $user->save();
        return redirect()->route('user.index');
       
    }
    public function edit($id)
    {
       $userFind= User::find($id);
       
        return view('user.edit',['user'=>$userFind]);
    }
    public function update($id,Request $request)
    {
       $userFind= User::find($id);
       $userFind->name=$request->name;
       $userFind->email=$request->email;
       $userFind->role=$request->position;

       $userFind->save();
        return redirect()->route('user.index');
    }
    public function editPW(Request $request)
    {
       $userFind= User::find($request->id);
      
       if($request->pass1 == $request->pass2){
        $userFind->password=bcrypt($request->pass1);
        $userFind->save();
        return back();
       }
        
       
    }
    public function delete($id){

    $user = User::find($id);        
    $user->delete();
    }

}
