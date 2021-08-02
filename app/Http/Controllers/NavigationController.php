<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function addpass()
    {
        $user = auth()->user();
        return view('addpassword',['user'=>$user]);
    }
}
