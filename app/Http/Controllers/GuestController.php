<?php

namespace App\Http\Controllers;

use App\Models\FieldWorkActivity;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function show($slugString)
    {
        $codewords =  FieldWorkActivity::findBySlug($slugString)->qrcode->codewords;
        return view('guest.qrcode',compact('codewords'));
    }
}
