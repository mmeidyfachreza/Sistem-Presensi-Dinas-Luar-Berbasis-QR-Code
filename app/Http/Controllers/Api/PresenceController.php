<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PresenceResource;
use App\Models\Presence;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PresenceController extends Controller
{
    public function show($employeeId)
    {
        return response()->json(new PresenceResource(Presence::getPresence($employeeId)));
    }

    public function store(Request $request)
    {
        //$employeeId = User::find($request->userId);
        if (Presence::havePresence($request->userId)) {
            $presence = Presence::getPresence($request->userId);
            $endTime = Carbon::now()->format('H:i:s');
            $time1 = Carbon::parse($presence->start_time);
            $time2 = Carbon::parse($endTime);
            $totalDuration1 =$time1->diff($endTime)->format('%i');

            $presence->update([
                'end_time' => $endTime,
                'end_location' => $request->lat.', '.$request->long,
            ]);
            return response()->json([
                'status' => 'pulang',
                'time'=>$presence->end_time,
                'work_duration' => $totalDuration1
            ]);
        }else{
            $presence = Presence::create([
                'employee_id' => $request->userId,
                'field_work_activity_id' => 1,
                'date' => Carbon::now()->format('Y-m-d'),
                'start_time' => Carbon::now()->format('H:i:s'),
                'start_location' => $request->lat.', '.$request->long,
            ]);
            return response()->json([
                'show' => false,
                'time'=>$presence->start_time
            ]);
        }
        // return response()->json(['presence'=>"ok"]);
    }
}
