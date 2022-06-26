<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PresenceResource;
use App\Models\Presence;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Events\MessageSent;
use App\Models\FieldWorkActivity;
use App\Models\Qrcode;
use Illuminate\Support\Facades\Auth;

class PresenceController extends Controller
{
    public function show($employeeId)
    {
        if(Presence::havePresence($employeeId)){
            return response()->json(new PresenceResource(Presence::getPresence($employeeId)));
        }else{
            return response()->json([
                'startTime' => 'belum tercatat',
                'endTime' => 'belum tercatat',
                'work_duration' => '-'
            ]);
        }

    }

    public function store(Request $request)
    {
        if (Qrcode::IsValidQrcode($request->qrcode,$request->userId,$request->linkId)) {
            $fieldWorkActivity = FieldWorkActivity::find($request->linkId);
            $coordinate = explode(', ',$fieldWorkActivity->geo_location);
            // $coordinate = Qrcode::getCoordinate($request->qrcode);
            if (!$this->verificationDistance($request->lat,$request->long, $coordinate[0], $coordinate[1], $fieldWorkActivity->tolerance_distance)) {
                return response()->json(['message'=>'anda terlalu jauh dari lokasi presensi yang telah ditentukan'.$request->lat.', '.$request->long],400);
            }

            if (Presence::havePresence($request->userId)) {
                $presence = Presence::getPresence($request->userId);
                $endTime = Carbon::now()->format('H:i:s');
                $time1 = Carbon::parse($presence->start_time);
                $time2 = Carbon::parse($endTime);
                $totalDuration1 =$time1->diffInSeconds($endTime);

                $presence->update([
                    'end_time' => $endTime,
                    'end_location' => $request->lat.', '.$request->long,
                    'work_duration' => $totalDuration1
                ]);
                return response()->json([
                    'status' => 'pulang',
                    'time'=>$totalDuration1,
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
                    'status' => 'hadir',
                    'show' => false,
                    'time'=>$presence->start_time
                ]);
            }
        }
        if (app()->environment(['local', 'staging'])) {
            return response()->json(['message'=>' QR Code tidak valid '.$request->linkId.'+'.$request->qrcode.'+'.$request->userId],422);
        }
        return response()->json(['message'=>' QR Code tidak valid '],422);
        // return response()->json(['presence'=>"ok"]);
    }

    function verificationDistance(
        $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $tolerance_distance, $earthRadius = 6371000)
    {
    //haversine formula
    // convert from degrees to radians
    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo = deg2rad($latitudeTo);
    $lonTo = deg2rad($longitudeTo);

    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;

    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
    $result = $angle * $earthRadius;
    if ($result >= $tolerance_distance ) {
        return false;
    }
    return true;
    }
}
