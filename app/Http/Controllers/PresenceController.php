<?php

namespace App\Http\Controllers;

use App\Models\FieldWorkActivity;
use App\Models\Presence;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

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

    public function print($id)
    {
        $data = Presence::with('employee','field_work_activity')
            ->where('field_work_activity_id',$id)
            ->orderBy('date')
            ->get();
        $project_name = $data->first()->field_work_activity->project_name;
        $presences = $data->groupBy([function ($val) {
            return Carbon::parse($val->date)->format('F');
        },'employee.name',function ($val) {
            return Carbon::parse($val->date)->format('d');
        }])->toArray();
        $dayInMonth = Carbon::now()->daysInMonth;
        $pdf = Pdf::loadView('print.report', compact('presences','dayInMonth','project_name'));
        return $pdf->download('rekap presensi karyawan.pdf');
        return view('print.report',compact('presences','dayInMonth','project_name'));
    }
}
