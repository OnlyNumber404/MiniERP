<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class AuthControler extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email'=> 'required|email|max:50',
            'password' => 'required|max:50',
        ]);
        
        $credentials = $request -> only('email','password');

        if (FacadesAuth::attempt($credentials)){
            // dd('login berhasil');
            return redirect('/dashboard');
        }
        return back()-> with('failed','Email atau Password salah')->onlyInput('email');
    }
}
