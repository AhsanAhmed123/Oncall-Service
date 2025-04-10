<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ivr_configurations;
use App\Models\Department;
use App\Models\ivr_options;
use App\Models\ivr_schedule_greeting;
use App\Http\Requests\StoreIvrScheduleGreetingRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class IvrController extends Controller
{
    public function index()
    {
    $ivrConfig = ivr_configurations::where('added_by', auth()->user()->id)->first();

    if ($ivrConfig) {
        $ivrConfig->ivr_type = explode(',', $ivrConfig->ivr_type);
    } else {
       
        $ivrConfig = new \stdClass(); 
        $ivrConfig->ivr_type = []; 
    }

    $departments = Department::with('ivr_options')->where('active_user_id', auth()->user()->id)->orderBy('assigned_key', 'asc')->get();
    $ivr_schedule_greeting = ivr_schedule_greeting::where('active_user_id', auth()->user()->id)->get();

        return view('ivr.index', compact('ivrConfig', 'departments', 'ivr_schedule_greeting'));
    }


    public function update(Request $request)
    {   
        try {
            $validated = $request->validate([
                'did_number' => 'required|string',
                'business_phone' => 'required|string',
                'ivr_type' => 'required|string',
                'tts_audio' => 'nullable|file|mimetypes:audio/*|max:10240', // Allows all audio types, max 10MB
                'ttstype' => 'required|string',
                'main_greeting' => 'required|string',
                'repeat_count' => 'required|integer',
            ]);

            $id = $request->input('ivr_config_id');

            $data = $request->only([
                'did_number', 'business_phone', 'ivr_type', 'ttstype', 'main_greeting', 'repeat_count'
            ]);
            $data['added_by'] = Auth()->user()->id; 

            // Handle file upload
            if ($request->hasFile('tts_audio')) {
                $file = $request->file('tts_audio');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->move('tts_audio', $fileName);
                $data['tts_audio'] = $filePath; 
            }

            if ($id) {
                $record = ivr_configurations::findOrFail($id);

               if($request->hasFile('tts_audio')) {
                if (File::exists($record->tts_audio)) {
                  unlink($record->tts_audio);
                }
                }

                // Update the record
                $record->update($data);
                $message = 'Record updated successfully!';
            } else {
                $data['added_by'] = auth()->user()->id;
                ivr_configurations::create($data);
                $message = 'Record created successfully!';
            }

            return redirect()->back()->with('success', $message);
        } catch (Exception $e) {
            return back()->withErrors([
                'error' => 'There was an error processing your request. Please try again later.',
            ]);
        }
    }


    public function add_schdeule_greeting(StoreIvrScheduleGreetingRequest $request, ivr_schedule_greeting $schedule)
    {   
        if (!$request->ivr_config_id) {
            return redirect()->back()->with('error', 'Please configure IVR first.');
        }
        
        try {
        $request->merge(['active_user_id' => auth()->user()->id]);
        $schedule->create($request->validated());

        return redirect()->back()->with('success', 'Schedule Greeting Added Successfully');
        
    } catch (Exception $e) {    
            return back()->withErrors(['error' => 'There was an error processing your request. Please try again later.']);
    }  

    }

    public function update_schedule_greeting(StoreIvrScheduleGreetingRequest $request, ivr_schedule_greeting $schedule, $id)
    {
        try {
        $schedule = ivr_schedule_greeting::findOrFail($id); 
        $schedule->update($request->validated());

        return redirect()->back()->with('success', 'Schedule Greeting Updated Successfully');
    } catch (Exception $e) {    
            return back()->withErrors(['error' => 'There was an error processing your request. Please try again later.']);
    }
    
    }

    public function delete_schedule_greeting($id)
    {
        try {
        $schedule = ivr_schedule_greeting::find($id);
        $schedule->delete();    
        return redirect()->back()->with('success', 'Schedule Greeting Deleted Successfully');
        } catch (Exception $e) {    
            return back()->withErrors(['error' => 'There was an error processing your request. Please try again later.']);
        }
    }

    public function save_options(Request $request)
{
    if (!$request->ivrId) {
        return response()->json([
            'message' => 'Please configure IVR first',
        ], 400);
    }

    try {
        $audioPath = null;
        if ($request->hasFile('audioGreeting')) {
            $file = $request->file('audioGreeting');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $audioPath = $file->move('audioGreeting', $fileName);
        }

        $data = [
            'ivr_config_id' => $request->input('ivrId'),
            'ivr_dept_id' => $request->input('depId'),
            'text_greeting' => $request->input('greeting'),
            'link' => $request->input('links'),
        ];

        if ($audioPath) {
            $data['audio_greeting'] = $audioPath;
        }
        $data['active_user_id'] = Auth()->user()->id;

        // Check if ivrOptionId exists to update or create
        if ($request->input('ivroptionId')) {
         
            $ivrOption = ivr_options::where('id',$request->ivroptionId)->first();
            if ($ivrOption) {
                $ivrOption->update($data);
                return response()->json([
                    'message' => 'Updated successfully!',
                    'data' => $ivrOption,
                ]);
            }
        }
        // Create new if ivrOptionId is not provided or not found
        $save_option = ivr_options::create($data);

        return response()->json([
            'message' => 'Saved successfully!',
            'data' => $save_option,
        ]);

    } catch (Exception $e) {
        return response()->json([
            'error' => 'There was an error processing your request. Please try again later.',
            'details' => $e->getMessage()
        ], 500);
    }
}


  
}
