<?php

namespace App\Http\Controllers;

use App\Models\FieldWorkActivity;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function show($slugString,Request $request)
    {
        $link = FieldWorkActivity::findBySlug($slugString);
        $codewords =  $link->qrcode->codewords;
        $projectName = $link->project_name;
        if (isset($request->errorCorrectionLevel)) {
            $errorCorrectionLevel = $request->errorCorrectionLevel;
        }else{
            $errorCorrectionLevel = 'H';
        }

        return view('guest.qrcode',compact('codewords','projectName','errorCorrectionLevel','slugString'));
    }
}
