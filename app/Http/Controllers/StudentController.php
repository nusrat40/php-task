<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    //

    public function createStudent(Request $request)

    {

        //  return $request;


        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:students',
            'roll_number' => 'required| integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()]);
        }
        try {

            $student = new Student();
            $student->name = $request->name;
            $student->email = $request->email;
            $student->phone = $request->phone;
            $student->roll_number = $request->roll_number;
            $student->save();

            return response()->json([
                'status' => true,
                'message' => 'student created Successfully',
                'data' => $student
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error during store: ' . $e->getMessage(),
            ]);
        }
    }


    public function getStudent(Request $request)
    {


         $per_page = $request->per_page;

        $students = Student::orderBy('id', 'asc')->paginate($per_page);


        if (!$students->isEmpty()) {

            return response()->json([
                'status' => true,
                'message' => 'students get successfully',
                'data' => $students
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'students not found',
            ]);
        }
    }



    public function Update(Request $request)
    {


        $validator = Validator::make($request->all(), [

            'student_id' => 'required',

            'name' => 'required',
            'roll_number' => 'required| integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()]);
        }
        try {


            $student = Student::where('id', $request->student_id)->first();
            // return $student ;

            $student->name = $request->name ?? $student->name;
            $student->email = $request->email ?? $student->email;
            $student->phone = $request->phone ?? $student->phone;
            $student->roll_number = $request->roll_number ?? $student->roll_number;
            $student->save();


            return response()->json([
                'status' => true,
                'message' => 'student Updated Successfully',
                'data' => $student
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error during update: ' . $e->getMessage(),
            ]);
        }
    }



      public function delete($id)
    {


        //  return $id;

        $student = Student::where('id', $id)->first();


        // return $student;


        if ($student) {

            $student->delete();
            return response()->json([
                'status' => true,
                'message' => 'student deleted successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'student not found',
            ]);
        }
    }


      public function getStudentSingle ($id)
    {


        //  return $id;

        $student = Student::where('id', $id)->first();
        // return $student;

        if ($student) {

            return response()->json([
                'status' => true,
                'message' => 'student get successfully',
                'data' =>$student,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'student not found',
            ]);
        }
    }

}
