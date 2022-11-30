<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\FieldWorkActivity;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEmployee = Employee::count();
        $totalActivity = FieldWorkActivity::count();
        $data = [
            'totalEmployee' => $totalEmployee,
            'totalActivity' => $totalActivity
        ];

        return view('dashboard',compact('data'));
    }
}
