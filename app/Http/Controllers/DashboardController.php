<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function home(){


        $today = Carbon::today();


        $numberOfStudents = Student::count();

        $morningLate = Attendance::whereDate('date', $today)->where('student_status', 'late')->count();

        $morningAbsent = Attendance::whereDate('date', $today)->whereNull('student_status')->count();

        $afternoonLate = Attendance::whereDate('date', $today)->where('student_pm_status', 'late')->count();

        $afternoonAbsent = Attendance::whereDate('date', $today)->whereNull('student_pm_status',)->count();

        return view('home', compact(
            'numberOfStudents',
            'morningLate',
            'morningAbsent',
            'afternoonLate',
            'afternoonAbsent'
     ));
    }
}
