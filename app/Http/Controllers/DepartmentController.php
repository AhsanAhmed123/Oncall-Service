<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    
    public function index()
    {
        $departments = Department::where('active_user_id', auth()->user()->id)->get();
        return view('departments.index', compact('departments'));
    }

    public function store(Request $request)
    {
    
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:departments,email',
            'phone_number' => 'required|string|max:20',
            'assigned_key' => 'required|string|max:255',
            'colour' => 'required|string|max:255', 
        ]);
        $request->merge(['active_user_id' => auth()->user()->id]);
        $department = Department::create($request->all());

        return response()->json($department, 201);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:departments,email,' . $id,
                'phone_number' => 'required|string|max:20',
                'assigned_key' => 'required|string|max:255',
                'colour' => 'required|string|max:255', 
            ]);
            $request->merge(['active_user_id' => auth()->user()->id]);
    
            $department = Department::findOrFail($id);
            $department->update($request->all());
    
            return response()->json(['message' => 'Department updated successfully!', 'department' => $department], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return response()->json(null, 204);
    }


}
