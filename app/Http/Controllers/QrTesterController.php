<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class QrTesterController extends Controller
{
    public function qrTesterIndex(){
        return view('qrTester.index');
    }

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
