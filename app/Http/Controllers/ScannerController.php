<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\AttendanceNotificationMail;


class ScannerController extends Controller
{
    public function scannerIndex()
    {
        return view('scanner.index');
    }


    public function record($lrn)
{
    $student = Student::where('lrn', $lrn)->first();

    if (!$student) {
        return response()->json([
            'success' => false,
            'message' => 'Student not found.',
        ]);
    }

    $today = Carbon::today('Asia/Manila');
    $now   = Carbon::now('Asia/Manila');
    $hour  = $now->hour;

    // Determine session: AM (< 12:00) or PM (>= 12:00)
    $isMorning = $hour < 12;

    // Get existing attendance record for today
    $attendance = Attendance::where('lrn', $lrn)
        ->whereDate('date', $today)
        ->first();

    /*
    |--------------------------------------------------------------------------
    | CASE 1: No attendance record yet today
    |--------------------------------------------------------------------------
    */
    if (!$attendance) {
        if ($isMorning) {
            $studentStatus = $now->format('H:i') > '07:30' ? 'Late' : 'Present';
            $attendance = Attendance::create([
                'name'            => $student->name,
                'level'           => $student->level,
                'lrn'             => $student->lrn,
                'date'            => $today,
                'time_in'         => $now,
                'status'          => 'In',
                'student_status'  => $studentStatus,
            ]);

            // --- Send email to guardian ---
            if ($student->email) {
                $attendanceData = [
                    'session'   => 'AM',
                    'status'    => $studentStatus,
                    'time_in'   => Carbon::parse($attendance->time_in)->format('h:i A'),
                    'time_out'  => '-',
                    'current'   => 'In',
                    'message'   => "Good day, {$student->name}! You have successfully timed in.",
                ];
                Mail::to($student->email)->send(
                    new AttendanceNotificationMail($student, $attendanceData)
                );
            }
        } else {
            $studentPmStatus = $now->format('H:i') > '13:00' ? 'Late' : 'Present';
            $attendance = Attendance::create([
                'name'               => $student->name,
                'level'              => $student->level,
                'lrn'                => $student->lrn,
                'date'               => $today,
                'pm_time_in'         => $now,
                'pm_status'          => 'In',
                'student_pm_status'  => $studentPmStatus,
            ]);

            // --- Send email to guardian ---
            if ($student->email) {
                $attendanceData = [
                    'session'   => 'PM',
                    'status'    => $studentPmStatus,
                    'time_in'   => Carbon::parse($attendance->pm_time_in)->format('h:i A'),
                    'time_out'  => '-',
                    'current'   => 'In',
                    'message'   => "Good afternoon, {$student->name}! You have successfully timed in.",
                ];
                Mail::to($student->email)->send(
                    new AttendanceNotificationMail($student, $attendanceData)
                );
            }
        }

        return response()->json([
            'success' => true,
            'student' => $student,
            'attendance' => [
                'session'   => $isMorning ? 'AM' : 'PM',
                'status'    => $isMorning ? $attendance->student_status : $attendance->student_pm_status,
                'time_in'   => $isMorning
                    ? Carbon::parse($attendance->time_in)->format('h:i A')
                    : Carbon::parse($attendance->pm_time_in)->format('h:i A'),
                'time_out'  => '-',
                'current'   => 'In',
                'message'   => "Good day, {$student->name}! You have successfully timed in.",
            ],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CASE 2: Already has a record for today
    |--------------------------------------------------------------------------
    */

    if ($isMorning) {
        // AM session
        if (!$attendance->time_out) {
            // Time out
            $attendance->update([
                'time_out' => $now,
                'status'   => 'Out',
            ]);

            // --- Send email to guardian ---
            if ($student->email) {
                $attendanceData = [
                    'session'   => 'AM',
                    'status'    => $attendance->student_status,
                    'time_in'   => Carbon::parse($attendance->time_in)->format('h:i A'),
                    'time_out'  => Carbon::parse($attendance->time_out)->format('h:i A'),
                    'current'   => 'Out',
                    'message'   => "Goodbye, {$student->name}! You have timed out for the morning.",
                ];
                Mail::to($student->email)->send(
                    new AttendanceNotificationMail($student, $attendanceData)
                );
            }

            return response()->json([
                'success' => true,
                'student' => $student,
                'attendance' => [
                    'session'   => 'AM',
                    'status'    => $attendance->student_status,
                    'time_in'   => Carbon::parse($attendance->time_in)->format('h:i A'),
                    'time_out'  => Carbon::parse($attendance->time_out)->format('h:i A'),
                    'current'   => 'Out',
                    'message'   => "Goodbye, {$student->name}! You have timed out for the morning.",
                ],
            ]);
        }
    } else {
        // PM session
        if (!$attendance->pm_time_in) {
            // PM time in
            $studentPmStatus = $now->format('H:i') > '13:00' ? 'Late' : 'Present';
            $attendance->update([
                'pm_time_in'        => $now,
                'pm_status'         => 'In',
                'student_pm_status' => $studentPmStatus,
            ]);

            // --- Send email to guardian ---
            if ($student->email) {
                $attendanceData = [
                    'session'   => 'PM',
                    'status'    => $studentPmStatus,
                    'time_in'   => Carbon::parse($attendance->pm_time_in)->format('h:i A'),
                    'time_out'  => '-',
                    'current'   => 'In',
                    'message'   => "Good afternoon, {$student->name}! You have successfully timed in.",
                ];
                Mail::to($student->email)->send(
                    new AttendanceNotificationMail($student, $attendanceData)
                );
            }

            return response()->json([
                'success' => true,
                'student' => $student,
                'attendance' => [
                    'session'   => 'PM',
                    'status'    => $attendance->student_pm_status,
                    'time_in'   => Carbon::parse($attendance->pm_time_in)->format('h:i A'),
                    'time_out'  => '-',
                    'current'   => 'In',
                    'message'   => "Good afternoon, {$student->name}! You have successfully timed in.",
                ],
            ]);
        } elseif (!$attendance->pm_time_out) {
            // PM time out
            $attendance->update([
                'pm_time_out' => $now,
                'pm_status'   => 'Out',
            ]);

            // --- Send email to guardian ---
            if ($student->email) {
                $attendanceData = [
                    'session'   => 'PM',
                    'status'    => $attendance->student_pm_status,
                    'time_in'   => Carbon::parse($attendance->pm_time_in)->format('h:i A'),
                    'time_out'  => Carbon::parse($attendance->pm_time_out)->format('h:i A'),
                    'current'   => 'Out',
                    'message'   => "Goodbye, {$student->name}! You have timed out for the afternoon.",
                ];
                Mail::to($student->email)->send(
                    new AttendanceNotificationMail($student, $attendanceData)
                );
            }

            return response()->json([
                'success' => true,
                'student' => $student,
                'attendance' => [
                    'session'   => 'PM',
                    'status'    => $attendance->student_pm_status,
                    'time_in'   => Carbon::parse($attendance->pm_time_in)->format('h:i A'),
                    'time_out'  => Carbon::parse($attendance->pm_time_out)->format('h:i A'),
                    'current'   => 'Out',
                    'message'   => "Goodbye, {$student->name}! You have timed out for the afternoon.",
                ],
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | CASE 3: Already completed attendance
    |--------------------------------------------------------------------------
    */
    return response()->json([
        'success' => false,
        'message' => 'Attendance already completed for today.',
    ]);
}

}