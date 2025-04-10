<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Jobs\SendForgotPasswordOTP;
use App\Models\Children;
use App\Models\Content;
use App\Models\ProfessionalProfile;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Stripe\Stripe;
use Stripe\Account;

class AuthController extends Controller
{
   public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials.'
            ], 401);
        }


        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login successful!',
            'token' => $token,
            'data' => $user,
        ], 200);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found with this email.'
            ], 404);
        }

        // Generate OTP
        $otp = rand(1000, 9999);

        DB::table('password_reset_tokens')->updateOrInsert([
            'email' => $request->email
        ], [
            'token' => $otp,
            'created_at' => now(),
        ]);

        Mail::to($request->email)->send(new ForgotPasswordMail($otp));

        return response()->json([
            'status' => true,
            'message' => 'OTP sent to your registered email.',
            'email' => $request->email,
            'otp' => $otp,
        ], 200);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string',
        ]);

        $otpCheck = DB::table('password_reset_tokens')->where([
            'email' => $request->email,
            'token' => $request->otp,
        ])->first();
        if (!$otpCheck) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid OTP'
            ], 401);
        }
        return response()->json([
            'status' => true,
            'message' => 'OTP verified successfully!',
        ], 200);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'status' => false,
                'error' => 'User not found with this email.'
            ]);
        }

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Password reset successfully!',
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'status' => 200,
            'message' => 'User logged out successfully!'
        ]);
    }
}
