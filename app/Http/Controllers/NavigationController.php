<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Password;

class NavigationController extends Controller
{
    public function addpass()
    {
        $user = auth()->user();
        return view('addpassword',['user'=>$user]);
    }

    public function options()
    {
        $user = auth()->user();
        return view('options',['user'=>$user]);
    }

    public function show($id)
    {
        $user = auth()->user();
        $password = Password::findOrFail($id);
        if($user -> id != $password->user_id){
            abort('403');
        }else{
            return view('show',['password'=>$password]);
        }
    }

    public function edit($id)
    {
        $user = auth()->user();
        $password = Password::findOrFail($id);
        if($user -> id != $password->user_id){
            abort('403');
        }else{
            return view('edit',['password'=>$password]);
        }
    }
    
    public function support()
    {
        return view('support');
    }

    public function settings()
    {
        $user = auth()->user();
        
        return view('settings',['user'=>$user]);
        
    }

}
