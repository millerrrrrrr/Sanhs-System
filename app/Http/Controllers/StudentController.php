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
            'guardian' => 'required|string|max:255',
            'email'    => 'required|email|unique:students,email',
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
        $students = Student::orderByRaw('CAST(SUBSTRING_INDEX(level, " ", 1) AS UNSIGNED) ASC')
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

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'age'     => 'required|integer|min:1|max:100',
            'gender'  => 'required|in:Male,Female',
            'address' => 'required|string',
            'lrn'     => 'required|digits:12|unique:students,lrn,' . $student->id,
            'level'   => 'required|string',
            'guardian' => 'required|string|max:255',
            'email'    => 'required|email|unique:students,email',
        ]);

        if ($validated['lrn'] !== $student->lrn) {
            // Delete old QR code
            if ($student->qrCode && file_exists(public_path($student->qrCode))) {
                unlink(public_path($student->qrCode));
            }

            $fileName = 'student-' . $validated['lrn'] . '-' . Str::random(6) . '.png';
            $filePath = public_path('qrCode/' . $fileName);

            // Generate new QR code
            QrCode::format('png')
                ->size(300)
                ->errorCorrection('H')
                ->generate($validated['lrn'], $filePath);

            $validated['qrCode'] = 'qrCode/' . $fileName;
        } else {
            $validated['qrCode'] = $student->qrCode;
        }

        $student->update($validated);

        return redirect()->route('studentList')->with('success', 'Student updated successfully!');
    }

    public function delete($id){
        $student = Student::findOrFail($id);

        $deleted = $student->delete();
        if($deleted){
            return back()->with('success', 'Deleted Successfully');
        }
        return back()->with('error', 'Failed');

    }

    public function recentlyDeleted(){
        $students = Student::orderByRaw('CAST(SUBSTRING_INDEX(level, " ", 1) AS UNSIGNED) ASC')
        ->onlyTrashed()
        ->paginate(10);
        return view('student.recentlyDeleted', compact('students'));
    }

    public function restoreStudent($id){
        $restore = Student::onlyTrashed()->findOrFail($id)->restore();

        if ($restore){
            return back()->with('success', 'Restored Successfully');
        }
    }

    public function permanentlyDelete($id){
        $student = Student::onlyTrashed()->findOrFail($id);


        if($student->qrCode && file_exists(public_path($student->qrCode))){
            unlink(public_path($student->qrCode));
        }

        $permanentlyDelete = $student->forceDelete();

        if($permanentlyDelete){
            return back()->with('success', 'Permanently Deleted');
        }
        return back()->with('error', 'Failed Delete');

    }

    // app/Http/Controllers/StudentController.php

public function getStudentByLrn($lrn)
{
    // Find the student by LRN
    $student = Student::where('lrn', $lrn)->first();

    // If student is found, return the data
    if ($student) {
        return response()->json([
            'success' => true,
            'student' => $student
        ]);
    }

    // If student is not found, return an error message
    return response()->json([
        'success' => false,
        'message' => 'Student not found'
    ]);
}

}
