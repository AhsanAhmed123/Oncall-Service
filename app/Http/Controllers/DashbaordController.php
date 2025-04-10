<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CallRecording;
use App\Models\Callerdetails;


class DashbaordController extends Controller
{
    public function index()
    {
        
     $oncallperson = User::count();
     $voicemail = CallRecording::count();
     $voicemail_details = CallRecording::with('department')->get();
     return view('dashboard',compact('oncallperson','voicemail','voicemail_details'));
     
    }
    
   public function callerstore(Request $request)
    {
    
        $request->validate([
            'name' => 'required|string|max:255',
            // 'dob' => 'nullable|date',
            'callback_notes' => 'nullable|string',
            'call_recording_id' => 'nullable|integer',
        ]);

        Callerdetails::create([
            'name' => $request->name,
            'dob' => $request->dob,
            'notes' => $request->callback_notes,
            'call_recording_id' => $request->call_recording_id,
        ]);

        return response()->json(['message' => 'Form submitted successfully'], 200);
    

    }
    
    public function fetchNotes($callRecordingId)
    {
        $notes = Callerdetails::where('call_recording_id', $callRecordingId)->get(); 
        return response()->json($notes->toArray());
    }
    
    public function delete(Request $request)
    {
       
        if ($request->has('call_sids')) {
            
            CallRecording::whereIn('call_sid', $request->call_sids)->delete();
      
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 400);
    }

}
