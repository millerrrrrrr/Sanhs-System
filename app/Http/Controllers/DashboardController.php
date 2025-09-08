<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function home(){

        $numberOfStudents = Student::count();

        return view('home', compact('numberOfStudents'));
    }
}
