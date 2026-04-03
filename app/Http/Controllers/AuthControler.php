<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class AuthControler extends Controller
{
    public function login(Request $request){

        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        //user login
        if (FacadesAuth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau Password yang Anda masukan salah.'
        ])->onlyInput('email');
    }


    public function register(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('register');
        }
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        FacadesAuth::login($user);

        return redirect()->intended('/login');
    }

    public function logout(Request $request){
        FacadesAuth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
        
    }
}