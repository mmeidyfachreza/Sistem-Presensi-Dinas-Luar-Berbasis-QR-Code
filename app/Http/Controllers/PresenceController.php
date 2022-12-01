<?php

namespace App\Http\Controllers;

use App\Models\FieldWorkActivity;
use App\Models\Presence;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PresenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $presences = Presence::with('employee','field_work_activity')->paginate();
        return view('admin.presence.index',compact('presences'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FieldWorkActivity $fieldWorkActivity)
    {
        return view('employee.create',compact('fieldWorkActivity'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Presence  $presence
     * @return \Illuminate\Http\Response
     */
    public function show(Presence $presence)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Presence  $presence
     * @return \Illuminate\Http\Response
     */
    public function destroy(Presence $presence)
    {
        //
    }

    public function print()
    {
        $presences = Presence::with('employee')
            ->orderBy('date')
            ->get()
            ->groupBy([function ($val) {
                return Carbon::parse($val->date)->format('F');
            },'employee.name',function ($val) {
                return Carbon::parse($val->date)->format('d');
            }])->toArray();
        $dayInMonth = Carbon::now()->daysInMonth;
        return view('print.report',compact('presences','dayInMonth'));
    }
}
