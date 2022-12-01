<?php

use App\Events\MessageSent;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FieldWorkActivityController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\PresenceController;
use App\Models\Presence;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use function PHPSTORM_META\map;

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
Route::get('qrcode/{slugString}', [GuestController::class,'show'])->name('qrcode.show');

Route::get('bc', function () {
    // // broadcast(new MessageSent('holla'))->toOthers();
    // $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    // $randomString = '';

    // for ($i = 0; $i < 8; $i++) {
    //     $index = rand(0, strlen($characters) - 1);
    //     $randomString .= $characters[$index];
    // }
    // echo $randomString;
    // $a = Carbon::now()->format('H:i:s');
    // $a = Carbon::parse($a);
    // $a = Carbon::parse('02:30:00');
    // $b = Carbon::now()->subSeconds('30')->diffForHumans(null,true);
    // echo $a;
    // dd($b);
    $data = Presence::with('employee')
            ->orderBy('date')
            ->get()
            ->groupBy([function ($val) {
                return Carbon::parse($val->date)->format('F');
            },'employee.name',function ($val) {
                return Carbon::parse($val->date)->format('d');
            }]);
            // ->map(function ($q){
            //     return $q->groupBy(function ($val) {
            //         return Carbon::parse($val->date)->format('d');
            //     })->toArray();
            // })

    dd($data);
});
Auth::routes();

Route::get('check-auth', function () {
    return auth()->check();
});

Route::group(['middleware' => ['auth'],'prefix'=>'admin'], function () {
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
    Route::put('kegiatan-kerja-lapangan/{fieldWorkActivity}/update', [FieldWorkActivityController::class,'update'])->name('field_work_activity.update');
    Route::get('kegiatan-kerja-lapangan/{fieldWorkActivity}/edit', [FieldWorkActivityController::class,'edit'])->name('field_work_activity.edit');
    Route::delete('kegiatan-kerja-lapangan/{fieldWorkActivity}', [FieldWorkActivityController::class,'destroy'])->name('field_work_activity.destroy');
    Route::get('kegiatan-kerja-lapangan/filter', [FieldWorkActivityController::class,'filter'])->name('field_work_activity.filter');


    Route::get('presensi', [PresenceController::class,'index'])->name('presence.index');
    Route::get('presensi/{presence}/show', [PresenceController::class,'show'])->name('presence.show');
    Route::delete('presensi/{presence}', [PresenceController::class,'destroy'])->name('presence.destroy');
    Route::get('presensi/filter', [PresenceController::class,'filter'])->name('presence.filter');
    Route::get('presensi/print/{id}',[PresenceController::class,'print'])->name('presence.print');


    // Route::get('tes', function () {
    //     return view('employee.index');
    // });
});

Route::group(['middleware' => ['auth'],'prefix'=>'karyawan'], function () {
    Route::get('presensi', [FieldWorkActivityController::class,'indexEmployee'])->name('attendance.index');
    Route::get('presensi/proses/{fieldWorkActivity}', [PresenceController::class,'create'])->name('attendance.create');
});
