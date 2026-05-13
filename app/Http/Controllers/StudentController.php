<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    //

    public function createStudent(Request $request)

    {



        $student = new Student();
        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->roll_number = $request->roll_number;

        $student->save();

        return response()->json([
            'success' => true,
            'message' => 'Student created successfully',
            'data' => $student
        ]);
    }


    public function getStudent()
    {
        $student = Student::first();

        return response()->json([
            'success' => true,
            'message' => 'All students fetched successfully',
            'data' => $student
        ]);
    }
}
