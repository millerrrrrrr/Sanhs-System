<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function AttendanceIndex(){

        $attendance = Attendance::latest()->get();

        return view('attendance.index', compact('attendance'));
    }

    public function search(Request $request)
{
    $query = $request->get('search');

    $attendance = Attendance::where('name', 'like', "%{$query}%")
        ->orWhere('level', 'like', "%{$query}%")
        ->orWhere('date', 'like', "%{$query}%")
        ->orderBy('date', 'desc')
        ->get();

    if ($attendance->count() > 0) {
        $html = '';
        foreach ($attendance as $at) {
            $html .= '
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 text-gray-800 font-medium text-center">'. $at->name .'</td>
                <td class="px-6 py-4 text-gray-600 text-center">'. $at->level .'</td>
                <td class="px-6 py-4 text-gray-600 text-center">'. $at->date .'</td>
                <td class="px-6 py-4 text-gray-600 text-center">'. ($at->time_in ?? '—') .'</td>
                <td class="px-6 py-4 text-gray-600 text-center">'. ($at->time_out ?? '—') .'</td>
                <td class="px-6 py-4 text-gray-600 text-center">'. ($at->student_status ?? 'Absent') .'</td>
                <td class="px-6 py-4 text-gray-600 text-center">'. ($at->status ?? '—') .'</td>
                <td class="px-6 py-4 text-gray-600 text-center">'. ($at->pm_time_in ?? '—') .'</td>
                <td class="px-6 py-4 text-gray-600 text-center">'. ($at->pm_time_out ?? '—') .'</td>
                <td class="px-6 py-4 text-gray-600 text-center">'. ($at->student_pm_status ?? 'Absent') .'</td>
                <td class="px-6 py-4 text-gray-600 text-center">'. ($at->pm_status ?? '—') .'</td>
            </tr>';
        }
    } else {
        $html = '<tr><td colspan="10" class="py-4 text-center bg-white text-gray-500">No students found.</td></tr>';
    }

    return $html;
}

}
