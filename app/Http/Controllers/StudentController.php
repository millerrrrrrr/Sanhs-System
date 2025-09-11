<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StudentController extends Controller
{
    public function register()
    {

        $grade = Level::orderByRaw('CAST(level AS UNSIGNED) ASC')->get();

        return view('student.register', compact('grade'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'age'     => 'required|integer|min:1|max:100',
            'gender'  => 'required|in:Male,Female',
            'address' => 'required|string',
            'lrn'     => 'required|digits:12|unique:students,lrn',
            'level'   => 'required|string',
        ]);

        // Generate QR code data (only LRN)
        $qrData = $validated['lrn'];

        // Generate filename (use lrn or random string)
        $fileName = 'student-' . $validated['lrn'] . '-' . Str::random(6) . '.png';
        $filePath = public_path('qrCode/' . $fileName);

        // Generate QR code image with LRN only
        QrCode::format('png')
            ->size(300)
            ->errorCorrection('H')
            ->generate($qrData, $filePath);

        // Add qrCode path to validated data
        $validated['qrCode'] = 'qrCode/' . $fileName;

        // Now save with qrCode included
        $student = Student::create($validated);

        return redirect()->back()->with('success', 'Student registered successfully with QR Code!');
    }


    public function studentList()
    {

        $students = DB::table('students')
            ->select('*')
            ->orderByRaw('CAST(SUBSTRING_INDEX(level, " ", 1) AS UNSIGNED) ASC')
            ->paginate(10);
        return view('student.list', compact('students'));
    }

    public function viewStudent($id, Student $student)
    {

        $student = Student::findOrFail($id);

        return view('student.view', compact('student'));
    }

    public function edit($id, Student $student)
    {
        $student = Student::findOrFail($id);
        $grade = Level::orderByRaw('CAST(level AS UNSIGNED) ASC')->get();

        // Corrected compact method
        return view('student.update', compact('student', 'grade'));
    }
}
