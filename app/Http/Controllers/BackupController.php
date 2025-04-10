<?php

namespace App\Http\Controllers;

use App\Models\backupOrder;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\DB;


class BackupController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        $user =User::where('added_by', auth()->user()->id)->get();
        return view('backup.index',compact('user','departments'));
    }

    public function details($departmentId)
    {
        $department = Department::findOrFail($departmentId);
        $users = backupOrder::with('users')->where('department_id', $departmentId)->OrderBy('position', 'asc')->get();

        $oncallPeople = User::where('added_by', auth()->user()->id)->get();

        $view = view('backup.partial.index');
        // Pass the data to the partial view
        return [
            'view' => $view->with(['backupPeople'=> $users,'users' => $users, 'department' => $department,'oncallPeople' => $oncallPeople])->render(),
            'backupPeople' => $department,
            'users' => $users,
            'oncallPeople' => $users
        ];
    }

    public function saveOncallPeopleOrder(Request $request)
    {
        $orderData = json_decode        ($request->oncall_order, true);
        if(empty($orderData)){
            return redirect()->back()->with('error', 'Oncall people order is empty!');
        }
        foreach ($orderData as $data) {
            
            // Check if the record exists
            $exists = DB::table('backup_orders')->where('department_id', $request->department_id)->where('user_id', $data['id'])->exists();
            if ($exists) {
                // Update the existing record
                DB::table('backup_orders')
                    ->where('user_id', $data['id'])
                    ->where('department_id', $request->department_id)
                    ->update([
                        'user_id'         => $data['id'],
                        'department_id' => $request->department_id,
                        'time'       => $request->time,
                        'position'   => $data['position']
                    ]);
            } else {

                DB::table('backup_orders')->insert([
                    'user_id'         => $data['id'],
                    'department_id' => $request->department_id,
                    'time'       => $request->time,
                    'position'   => $data['position'],
                ]);
            }
        }

        return redirect()->back()->with('success', 'Oncall people order updated!');
    }

}
