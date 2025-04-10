<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
class ServiceController extends Controller
{
    public function email()
    {
        $mail =Service::where('type','email')->first();
        return view('services.email',compact('mail'));
    }

    public function createorupdateemail(Request $request)
    {
        $mail = Service::where('id',$request->id)->where('type','email')->first();
        if($mail){
            $mail->subject = $request->subject;
            $mail->message = $request->message;
            $mail->status = $request->status;
            $mail->save();
        }else {
            $mail = new Service;
            $mail->type = 'email';
            $mail->subject = $request->subject;
            $mail->message = $request->message;
            $mail->status = $request->status;
            $mail->save();
        }
        return redirect()->route('email.create')->with('success', 'Login Successful');
        
    }

    public function sms(Request $request)
    {
        $sms = Service::where('type','sms')->first();
        return view('services.sms',compact('sms'));
        
    }

    public function createorupdatesms(Request $request)
    {
        $sms = Service::where('id',$request->id)->where('type','sms')->first();
        if($sms){
            $sms->message = $request->message;
            $sms->save();
        }else {
            $sms = new Service;
            $sms->type = 'sms';
            $sms->message = $request->message;
            $sms->save();
        }
        return redirect()->route('sms.create')->with('success', 'Login Successful');
        
    }



}
