<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthControler extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email'=> 'required|email|max:50',
            'password' => 'required|max:50',
        ]);
        dd($request -> all());
    }
}
