<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\FieldWorkActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Cviebrock\EloquentSluggable\Services\SlugService;

class FieldWorkActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fieldWorkActivities = FieldWorkActivity::paginate();
        return view('field_work_activity.index',compact('fieldWorkActivities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = Employee::select('id','name')->get();
        return view('field_work_activity.create',compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $fieldWorkActivity = FieldWorkActivity::create(array_merge($request->all(),[
                'start_date'=>explode(' - ',$request->daterange)[0],
                'end_date'=>explode(' - ',$request->daterange)[1],
                'link'=> SlugService::createSlug(FieldWorkActivity::class, 'link', $request->project_name)
            ]));
            $fieldWorkActivity->employees()->attach($request->team);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('field_work_activity.create')->withErrors(['message'=>$e->getMessage()]);
        }

        if (isset($request->exit)&&$request->exit) {
            return redirect()->route('field_work_activity.index')
            ->with('success','Berhasil menambah data ');
        }
        return redirect()->route('field_work_activity.edit')->with('success','Berhasil menambah data');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FieldWorkActivity  $fieldWorkActivity
     * @return \Illuminate\Http\Response
     */
    public function show(FieldWorkActivity $fieldWorkActivity)
    {
        $employees = $fieldWorkActivity->employees()->paginate();
        return view('field_work_activity.show',compact('fieldWorkActivity','employees'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FieldWorkActivity  $fieldWorkActivity
     * @return \Illuminate\Http\Response
     */
    public function edit(FieldWorkActivity $fieldWorkActivity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FieldWorkActivity  $fieldWorkActivity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FieldWorkActivity $fieldWorkActivity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FieldWorkActivity  $fieldWorkActivity
     * @return \Illuminate\Http\Response
     */
    public function destroy(FieldWorkActivity $fieldWorkActivity)
    {
        //
    }
}
