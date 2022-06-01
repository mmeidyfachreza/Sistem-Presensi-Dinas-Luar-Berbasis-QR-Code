<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FieldWorkActivityController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});
Route::get('tes', function () {
    return view('presensi.qrcode_scanner');
});
Route::get('pusher', function () {
    return view('pusher');
});
Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class,'index'])->name('dashboard');
    Route::resource('karyawan', EmployeeController::class,[
        'names' => [
            'index' => 'employee.index',
            'create' => 'employee.create',
            'store' => 'employee.store',
            'show' => 'employee.show',
            'edit' => 'employee.edit',
            'update' => 'employee.update',
            'destroy' => 'employee.destroy'
        ]
    ]);
    Route::get('karyawan-nonaktif', [EmployeeController::class,'indexAll'])->name('employee.index.all');
    Route::put('pengaktifan-karyawan/{id}', [EmployeeController::class,'restore'])->name('employee.restore');
    Route::post('karyawan/cari',[EmployeeController::class,'search'])->name('employee.search');

    Route::get('kegiatan-kerja-lapangan/create', [FieldWorkActivityController::class,'create'])->name('field_work_activity.create');
    Route::post('kegiatan-kerja-lapangan/store', [FieldWorkActivityController::class,'store'])->name('field_work_activity.store');
    Route::get('kegiatan-kerja-lapangan', [FieldWorkActivityController::class,'index'])->name('field_work_activity.index');
    Route::get('kegiatan-kerja-lapangan/{fieldWorkActivity}/show', [FieldWorkActivityController::class,'show'])->name('field_work_activity.show');
    Route::put('kegiatan-kerja-lapangan/{fieldWorkActivity}/update', [FieldWorkActivityController::class,'index'])->name('field_work_activity.update');
    Route::get('kegiatan-kerja-lapangan/{fieldWorkActivity}/edit', [FieldWorkActivityController::class,'edit'])->name('field_work_activity.edit');
    Route::delete('kegiatan-kerja-lapangan/{fieldWorkActivity}', [FieldWorkActivityController::class,'destroy'])->name('field_work_activity.destroy');
    Route::get('kegiatan-kerja-lapangan/filter', [FieldWorkActivityController::class,'filter'])->name('field_work_activity.filter');
});
