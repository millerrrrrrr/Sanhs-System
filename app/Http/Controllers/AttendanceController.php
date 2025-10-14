<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;


class AttendanceController extends Controller
{
    public function AttendanceIndex()
    {
        $attendance = Attendance::latest()->get();
        $levels = Attendance::select('level')->distinct()->pluck('level');
        return view('attendance.index', compact('attendance', 'levels'));
    }

    public function filter(Request $request)
    {
        $query = Attendance::query();

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        $attendance = $query->latest()->get();

        return response()->json(['attendance' => $attendance]);
    }
}
