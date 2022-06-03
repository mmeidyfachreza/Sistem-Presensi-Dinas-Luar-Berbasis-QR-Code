<?php

use App\Http\Controllers\Api\PresenceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api')->group(function () {

    // Route::post('/qrcode-link', 'QRcodeController@refresh');
    // Route::post('/qrcode', 'QRcodeController@verif');

    // Route::post('/presensi','presensiController@simpan');
    // Route::get('/presensi/{id}', 'presensiController@getUpdate');
    // Route::get('/qrcode-link2/{link}', 'QRcodeController@getQR');
    // Route::get('/qrcode-status/{link}', 'QRcodeController@startQRCode');
    Route::get('presensi/{presensi}', [PresenceController::class,'show']);
    Route::post('presensi/verif-qrcode', [PresenceController::class,'store']);


});
