<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    public function index()
    {
        $user = User::where('role_id',3)->get();
        return view('Admin.superadmin.index',compact('user'));
    }

    public function shadow_login(Request $request)
    {
        $userId = $request->input('user_id');

        
        $user = User::findOrFail($userId);
      
        session(['admin_id' => auth()->id(), 'shadow_mode' => true]);

        Auth::login($user); // login as selected user

        return redirect('/dashboard');
    }

}
