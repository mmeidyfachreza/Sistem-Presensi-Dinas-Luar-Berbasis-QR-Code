<?php

namespace App\Http\Controllers;

use App\Models\FieldWorkActivity;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function show($slugString)
    {
        $link = FieldWorkActivity::findBySlug($slugString);
        $codewords =  $link->qrcode->codewords;
        $projectName = $link->project_name;
        return view('guest.qrcode',compact('codewords','projectName'));
    }
}
