<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\TwiML\VoiceResponse;
use App\Models\ivr_configurations;
use App\Models\ivr_options;
use App\Models\backupOrder;
use App\Models\ivr_schedule_greeting;
use App\Models\CallRecording;

class TwilioIVRController extends Controller
{
    
    public function handleIncomingCall(Request $request)
    {
        $response = new VoiceResponse();
        $ivrConfig = ivr_configurations::first();
        $currentDateTime = now()->setTimezone('Asia/Karachi'); 
        
        $scheduledGreeting = ivr_schedule_greeting::where('start_date_time', '<=', $currentDateTime)
            ->where('end_date_time', '>=', $currentDateTime)
            ->first();
    
        $voice = 'man'; 
        if ($ivrConfig) {
            $voice = $ivrConfig->ttstype === 'john' ? 'man' : ($ivrConfig->ttstype === 'sophia' ? 'woman' : 'man');
        }
    
        $gather = $response->gather([
            'numDigits' => 1,
            'action' => url('/ivr/handle-input'), 
            'method' => 'POST'
        ]);
    
    
        if ($scheduledGreeting) {
            $gather->say($scheduledGreeting->greeting_text, ['voice' => $voice]);
        } elseif ($ivrConfig) {
            if ($ivrConfig->ivr_type == "TTS") {
                $gather->say($ivrConfig->main_greeting, ['voice' => $voice]);
            } else {
                $gather->play(asset($ivrConfig->tts_audio));
            }
        } else {
            $gather->say('Thank you for calling On Call Answering Service.', ['voice' => $voice]);
        }
    
        $response->redirect(url('/ivr/incoming-call'));
    
        return response($response)->header('Content-Type', 'text/xml');
    }



    
    public function handleInput(Request $request)
    {
       
        $response = new VoiceResponse();
        $digit = $request->input('Digits');
    
        $ivr_options = ivr_options::whereHas('department', function ($query) use ($digit) {
            $query->where('assigned_key', $digit);
        })->first();
    
        $ivrConfig = ivr_configurations::first();
        $voice = $ivrConfig->ttstype === 'john' ? 'man' : ($ivrConfig->ttstype === 'sophia' ? 'woman' : 'man');
        
        if ($ivr_options) {
    
            $greeting = substr($ivr_options->text_greeting, 0, 200);
            $response->say($greeting, ['voice' => $voice]);
    
        
            $backupOrders = BackupOrder::with('users')
                ->where('department_id', $ivr_options->ivr_dept_id)
                ->orderBy('position')
                ->limit(10)
                ->get();
               

            if ($backupOrders->isEmpty()) {
                 $response->say('No agents are available. Please leave a detailed message.', ['voice' => $voice]);
                    $response->record([
                    'action' => url('/ivr/save-voicemail?department_id=' . $ivr_options->ivr_dept_id),
                        'maxLength' => 60, 
                        'transcribe' => true
                    ]);
                $response->say('No users available.', ['voice' => $voice]);
            } else {
                $userPhoneNumbers = $backupOrders->pluck('users.contact')->toArray();
               
                $this->initiateCall($response, $userPhoneNumbers);
            }
        } else {
            $response->say('Invalid option.', ['voice' => $voice]);
        }    
       
    
        return response($response)->header('Content-Type', 'text/xml');
    }
    
    public function initiateCall($response, $userPhoneNumbers)
    {
        if (!empty($userPhoneNumbers)) {
            session(['userPhoneNumbers' => $userPhoneNumbers]);
    
            // Pehla number call karnay ka process
            $dial = $response->dial('', [
                'action' => url('/ivr/next-call'), // Next call attempt if no answer
                'timeout' => 20,  // 20 seconds tak call ring kare
                'answerOnBridge' => true
            ]);
            $dial->number($userPhoneNumbers[0]); 
        } else {
            // Agar koi agent available nahi to voicemail record kare
            $this->recordVoicemail($response);
        }
    }

    
    public function nextCall(Request $request)
    {
        $response = new VoiceResponse();
    
        $userPhoneNumbers = session('userPhoneNumbers', []);
    
        // Pehla number hata kar aglay number ko call kare
        array_shift($userPhoneNumbers);
    
        if (!empty($userPhoneNumbers)) {
            session(['userPhoneNumbers' => $userPhoneNumbers]);
    
            // Agla agent ko call kare
            $dial = $response->dial('', [
                'action' => url('/ivr/next-call'),
                'timeout' => 20,
                'answerOnBridge' => true
            ]);
            $dial->number($userPhoneNumbers[0]);
        } else {
            // Agar sab busy hon to voicemail record kare
            $this->recordVoicemail($response);
        }
    
        return response($response)->header('Content-Type', 'text/xml');
    }
    
    
    public function recordVoicemail($response)
    {
        $response->say('No agents are available. Please leave a detailed message.', ['voice' => 'man']);
    
        $response->record([
            'action' => url('/ivr/save-voicemail'),
            'maxLength' => 60, 
            'transcribe' => true
        ]);
    
        $response->say('Thank you for your message. We will get back to you shortly.');
    }





   public function saveVoicemail(Request $request)
    {
        $response = new VoiceResponse();
    
        $call_sid = $request->input('CallSid');
        $recording_url = $request->input('RecordingUrl');
        $recording_sid = $request->input('RecordingSid');
        $recording_duration = $request->input('RecordingDuration');
        $from_number = $request->input('From');
        $from_city = $request->input('FromCity');
        $from_state = $request->input('FromState');
        $from_zip = $request->input('FromZip');
        $from_country = $request->input('FromCountry');
        $to_number = $request->input('To');
        $to_city = $request->input('ToCity');
        $to_state = $request->input('ToState');
        $to_zip = $request->input('ToZip');
        $to_country = $request->input('ToCountry');
        $direction = $request->input('Direction');
        $caller = $request->input('Caller');
        $caller_city = $request->input('CallerCity');
        $caller_state = $request->input('CallerState');
        $caller_zip = $request->input('CallerZip');
        $caller_country = $request->input('CallerCountry');
        $call_status = $request->input('CallStatus');
        $start_time = $request->input('StartTime'); // May be null if call hasn't started
        $end_time = $request->input('EndTime'); 
        $called = $request->input('Called');
        $called_city = $request->input('CalledCity');
        $called_state = $request->input('CalledState');
        $called_zip = $request->input('CalledZip');
        $called_country = $request->input('CalledCountry');
        $account_sid = $request->input('AccountSid');
        $api_version = $request->input('ApiVersion');
        $department_id = $request->input('department_id');
    
        // Save to database
        CallRecording::create([
            'call_sid' => $call_sid,
            'recording_url' => $recording_url,
            'recording_sid' => $recording_sid,
            'recording_duration' => $recording_duration,
            'from_number' => $from_number,
            'from_city' => $from_city,
            'from_state' => $from_state,
            'from_zip' => $from_zip,
            'from_country' => $from_country,
            'to_number' => $to_number,
            'to_city' => $to_city,
            'to_state' => $to_state,
            'to_zip' => $to_zip,
            'to_country' => $to_country,
            'direction' => $direction,
            'caller' => $caller,
            'caller_city' => $caller_city,
            'caller_state' => $caller_state,
            'caller_zip' => $caller_zip,
            'caller_country' => $caller_country,
            'call_status' => $call_status,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'called' => $called,
            'called_city' => $called_city,
            'called_state' => $called_state,
            'called_zip' => $called_zip,
            'called_country' => $called_country,
            'account_sid' => $account_sid,
            'api_version' => $api_version,
            'department_id'=>$department_id
        ]);
    
        // Twilio response
        $response->say('Thank you for your message. We will get back to you shortly.', ['voice' => 'man']);
        $response->hangup();
    
        return response($response)->header('Content-Type', 'text/xml');
    }

}