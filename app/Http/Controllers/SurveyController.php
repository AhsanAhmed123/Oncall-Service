<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Survey;
use Auth;

class SurveyController extends Controller
{
    public function index(){

        if (Auth::user()->business_details->survey == 0) {
            abort(403, 'Access denied.');
            return redirect()->back()->with('error', 'Access restricted.');
        }

        $departments = Department::all();
        return view('survey.index', array('departments' => $departments));  
    }

    public function getQuestions($departmentId)
    {
        $questions = Survey::where('active_user_id', auth()->user()->id)->where('department_id', $departmentId)->get();
        return response()->json(['questions' => $questions]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required',
            'questions' => 'required|array',
            'files' => 'array',
        ]);

        // Pehle us department ka purana data delete karo
        Survey::where('department_id', $request->department_id)->delete();

        // Naya data insert karo
        foreach ($request->questions as $key => $question) {
            Survey::create([
                'active_user_id' => auth()->user()->id,
                'department_id' => $request->department_id,
                'question' => $question,
                'file_path' => $request->hasFile("files.$key") ? $request->file("files.$key")->store('surveys') : null,
            ]);
        }

        return redirect()->back()->with('success', 'Survey updated successfully!');
    }


}
