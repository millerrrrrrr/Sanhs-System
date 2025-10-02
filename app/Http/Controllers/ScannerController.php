<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScannerController extends Controller
{
    public function scannerIndex(){
        return view('scanner.index');
    }
}
