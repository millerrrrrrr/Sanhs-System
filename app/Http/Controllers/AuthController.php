<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {

        if (session('auth_user') === 'admin') {
            return redirect()->route('home');
        }
        if (session('auth_user') === 'qrattendance') {
            return redirect()->route('scannerIndex');
        }

        return view('auth.login');
    }

    public function login(Request $request){
        
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)){
            $request->session()->regenerate();

            $user = Auth::user();

            if($user->role === 'admin'){
                return redirect()->route('home')->with('success', 'Logged in as admin successfully!');
            }
            elseif($user->role === 'attendance'){
                return redirect()->route('scannerIndex')->with('success', 'Logged in as attendance scanner!');
            }
            

        }
        return back()->with('error', 'Invalid username or password');



    }


    public function logout()
    {
        session()->invalidate();
        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }
}
