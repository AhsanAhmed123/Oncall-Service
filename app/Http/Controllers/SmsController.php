<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class SmsController extends Controller
{
   public function index(){
    return view('sms.index');
   }

   public function sendSms(Request $request)
    {
        // Validate the request
        $request->validate([
            'sendTo' => 'required|string',
            'message' => 'required|string',
        ]);


        // Get Twilio credentials from config
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.auth_token');
        $from = config('services.twilio.phone_number');



        // Initialize Twilio client
        $client = new Client($sid, $token);

        try {
            // Send SMS
            $client->messages->create(
                $request->sendTo, // To
                [
                    'from' => $from,
                    'body' => $request->message,
                ]
            );

            return redirect()->back()->with('success', 'SMS sent successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send SMS: ' . $e->getMessage());
        }
    }

}
