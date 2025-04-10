<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roster;
use App\Models\User;

class ManageRoasterController extends Controller
{
    public function index()
    {
        $rosters = Roster::where('active_user_id', auth()->user()->id)->get();
        $employees = User::all();
        return view('Roaster.index', compact('rosters', 'employees'));
    }

    public function getRosterDetails()
    {
        $rosters = Roster::with('user')->where('active_user_id', auth()->user()->id)->get();
        $events = [];

        foreach ($rosters as $roster) {
            $selectedDays = json_decode($roster->days, true);
            $startDate = new \DateTime($roster->start_date);
            $endDate = new \DateTime($roster->end_date);
            $endDate->modify('+1 day');

            $interval = new \DateInterval('P1D');
            $dateRange = new \DatePeriod($startDate, $interval, $endDate);

            foreach ($dateRange as $date) {
                $dayOfWeek = $date->format('D'); // Mon, Tue, etc.
                if (in_array($dayOfWeek, $selectedDays)) {
                    $events[] = [
                        'id'    => $roster->id,
                        'title' => 'Signup - ' . $roster->user->name,
                        'start' => $date->format('Y-m-d') . 'T' . date('H:i:s', strtotime($roster->start_date)),
                        'end'   => $date->format('Y-m-d') . 'T' . date('H:i:s', strtotime($roster->end_date)),
                        'color' => '#dc3545'
                    ];
                }
            }
        }

        return response()->json($events);
    }

    public function store(Request $request)
    {
        Roster::create([
            'username'   => $request->username,
            'start_date' => $request->start_time,
            'end_date'   => $request->end_time,
            'days'       => json_encode($request->days),
            'active_user_id' => auth()->user()->id
        ]);

        return response()->json(['message' => 'Roster added successfully!']);
    }

    public function updateEvent(Request $request)
    {
        $event = Roster::find($request->id);
        $event->start_date = $request->start;
        $event->end_date = $request->end;
        $event->active_user_id = auth()->user()->id;
        if ($request->has('days')) {
            $event->days = json_encode($request->days);
        }
        $event->save();

        return response()->json(['message' => 'Roster updated']);
    }

    public function deleteEvent(Request $request)
    {
        $event = Roster::find($request->id);
        $event->delete();
        return response()->json(['message' => 'Event deleted']);
    }
}
