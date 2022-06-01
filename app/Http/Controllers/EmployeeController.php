<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeStoreUpdate;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::paginate();
        return view('employee.index',compact('employees'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAll()
    {
        $employees = Employee::onlyTrashed()->paginate();
        $trashed = true;
        return view('employee.index',compact('employees','trashed'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::select('id','name')->where('id','!=',1)->get();
        return view('employee.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeStoreRequest $request)
    {

        DB::beginTransaction();
        try {
            $employee = Employee::create($request->all());
            $user = User::create(array_merge($request->except(['password']), ['employee_id' =>$employee->id,'password'=>Hash::make($request->password)]));
            $user->assignRole($request->role_id);
            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('employee.create')->withErrors(['message'=>$e->getMessage()])->withInput(
                $request->except('password')
            );
        }
        if (isset($request->exit)&&$request->exit) {
            return redirect()->route('employee.index')->with('success','Berhasil menambahkan akun karyawan '.$employee->name);
        }
        return redirect()->route('employee.edit',$employee->id)->with('success','Berhasil menambah data');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $roles = Role::select('id','name')->where('id','!=',1)->get();
        return view('employee.edit',compact('employee','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeStoreUpdate $request, Employee $employee)
    {

        DB::beginTransaction();
        try {
            $employee->update($request->all());
            if ($request->password == null) {
                $employee->user->update(array_merge($request->except(['password']), ['employee_id' =>$employee->id]));
            }else{
                $employee->user->update(array_merge($request->except(['password']), ['employee_id' =>$employee->id,'password'=>Hash::make($request->password)]));
            }
            if (!$employee->user->hasRole('super admin')) {
                $employee->user->syncRoles($request->role_id);
            }
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('employee.edit',$employee->id)->withErrors(['message'=>$e->getMessage()]);
        }
        if (isset($request->exit)&&$request->exit) {
            return redirect()->route('employee.index')->with('success','Berhasil merubah data '.$employee->name);
        }
        return redirect()->route('employee.edit',$employee->id)->with('success','Berhasil merubah data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        if (Auth::user()->employee->id == $employee->id) {
            return redirect()->route('employee.index')->withErrors(['message'=>'Tidak dapat menghapus akun yang sedang login']);
        }
        $message = 'Berhasil menghapus akun karyawan '.$employee->name;
        $employee->delete();
        return redirect()->route('employee.index')->with('success',$message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $employee = Employee::onlyTrashed()->findOrFail($id);
        if (Auth::user()->employee->id == $employee->id) {
            return redirect()->route('employee.index')->withErrors(['message'=>'Tidak dapat menghapus akun yang sedang login']);
        }
        $message = 'Berhasil mengaktifkan kembali akun karyawan '.$employee->name;
        $employee->restore();
        return redirect()->route('employee.index.all')->with('success',$message);
    }

    public function search(Request $request)
    {
        $employees = Employee::search($request->value)->paginate();
        $search = $request->value;
        return view('employee.index',compact('employees','search'));
    }

    public function getParent(Request $request){
        $department = Department::find($request->departmentID);
        $parents = Employee::with('position','department')
            ->whereHas('position',function($q){$q->where('id',3);})
            ->whereHas('department',function($q) use ($department){$q->where('id',$department->id);})
            ->pluck('id','name');
        return response()->json($parents);
    }

    public function export()
    {
        return Excel::download(new EmployeeExport(), 'Format Import Data Siswa.xlsx');
    }
}
