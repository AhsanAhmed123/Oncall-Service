<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\department;
use App\Mail\UserPasswordMail;
use App\Mail\WelcomeEmail;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class OncallController extends Controller
{
    public function index()
    {
        $oncallPersons = User::with('department')->where('added_by', auth()->user()->id)->where('role_id', '!=', '1')->get();
        $departments = department::where('active_user_id', auth()->user()->id)->get();
        $roles = Role::where('name', '!=', 'SuperAdmin')->get();
        return view('oncall.index', compact('oncallPersons','departments','roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required',
            'name' => 'required|string|max:255',
            'department_id' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'contact' => 'required',
            'location' => 'required|string|max:255',
        ]);


        // Generate a random password
        $password = Str::random(10);

        $email = $request->email;
        
        $hashedPassword = Hash::make($password);

        $user = User::create([
            'role_id' => $request->role_id,
            'name' => $request->name,
            'department_id' => $request->department_id,
            'email' => $request->email,
            'contact' => $request->contact,
            'location' => $request->location,
            'password' => $hashedPassword,
            'is_email'=>$request->email_enabled,
            'is_sms'=>$request->sms_enabled,
            'is_reminder_call'=>$request->reminder_call_enabled,
            'is_direct_call'=>$request->direct_call_enabled,
            'added_by' => auth()->user()->id
        ]);

       
        Mail::to($user->email)->send(new WelcomeEmail($user, $password));

        return response()->json(['message' => 'On-call person created successfully'], 201);
    }

    public function edit($id)
    {
        $person = User::findOrFail($id);
        return response()->json($person);
    }

    // Update the specified on-call person in storage
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required',
            'role' => 'integer',
            'contact' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'location' => 'required|string|max:255'
        ]);

        $person = User::findOrFail($id);

        $person->update([
            'name' => $request->name,
            'department_id' => $request->department_id,
            'role_id' => $request->role_id,
            'contact' => $request->contact,
            'email' => $request->email,
            'location' => $request->location,
            'is_email' => $request->email_enabled,
            'is_sms' => $request->sms_enabled,
            'is_reminder_call' => $request->reminder_call_enabled,
            'is_direct_call' => $request->direct_call_enabled,
            'added_by' => auth()->user()->id
        ]);

        return response()->json(['message' => 'On-call person updated successfully'], 200);
    }


    public function destroy($id)
    {
        $person = User::findOrFail($id);
        $person->delete();

        return response()->json(['message' => 'On-call person deleted successfully'], 204);
    }
}
