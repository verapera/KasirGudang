<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function showlogin(){
        return view('login');
    }
    public function login(Request $request){
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required|min:6',
        ]);
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended('/');
        }else{
            return redirect()->back()->with('error','login failed check your crendentials!');
        }
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('login')->with('success','you have been login out!');
    }
}
