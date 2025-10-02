<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QrTesterController extends Controller
{
    public function qrTesterIndex(){
        return view('qrTester.index');
    }
}
