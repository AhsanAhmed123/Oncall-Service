<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {

        return view('auth.login');

    }

    public function postLogin(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_active' => 1])) {
                return redirect()->route('index-dashboard')
                    ->with('success', 'Login Successful, ' . Auth::user()->name);
            }

            return redirect()->back()->with('error', 'Invalid Credentials or Account Inactive');
        } catch (Exception $e) {
            return back()->withErrors([
                'error' => 'There was an error processing your request. Please try again later.',
            ]);
        }
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'LogOut Successful');
    }

    public function profile(){
        return view('auth.profile');
    }

    public function chagepassword()
    {
        return view('auth.chanegpassword');
    }

    public function updatePassword(Request $request)
    {
        
        try {
    
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'The old password is incorrect.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'profile ');
        } catch (Exception $e) {
            return back()->withErrors([
                'error' => 'There was an error processing your request. Please try again later.',
            ]);
        }
    }

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }
}
