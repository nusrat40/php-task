<?php

namespace App\Http\Controllers;

use App\Models\EducationalInfo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EducationalInfoController extends Controller
{
    public function createEducationalInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id'     => 'required|integer|exists:students,id',
            'school_name'    => 'required',
            'degree'         => 'required',
            // 'field_of_study' => 'nullable',
            // 'year_started'   => 'nullable|integer',
            // 'year_ended'     => 'nullable|integer',
            // 'gpa'            => 'nullable|numeric',
            'institution'    => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()]);
        }

        try {
            $educationalInfo = new EducationalInfo();
            $educationalInfo->student_id     = $request->student_id;
            $educationalInfo->school_name    = $request->school_name;
            $educationalInfo->degree         = $request->degree;
            // $educationalInfo->field_of_study = $request->field_of_study;
            // $educationalInfo->year_started   = $request->year_started;
            // $educationalInfo->year_ended     = $request->year_ended;
            // $educationalInfo->gpa            = $request->gpa;
            $educationalInfo->institution    = $request->institution;
            $educationalInfo->save();

            return response()->json([
                'status'  => true,
                'message' => 'Educational info created successfully',
                'data'    => $educationalInfo,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Error during store: ' . $e->getMessage(),
            ]);
        }
    }

    public function getEducationalInfo(Request $request)
    {
        $per_page = $request->per_page;

        $educationalInfos = EducationalInfo::with('student')->orderBy('id', 'asc')->paginate($per_page);

        if (!$educationalInfos->isEmpty()) {
            return response()->json([
                'status'  => true,
                'message' => 'Educational info get successfully',
                'data'    => $educationalInfos,
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Educational info not found',
            ]);
        }
    }

    public function getEducationalInfoSingle($id)
    {
        $educationalInfo = EducationalInfo::where('id', $id)->first();

        if ($educationalInfo) {
            return response()->json([
                'status'  => true,
                'message' => 'Educational info get successfully',
                'data'    => $educationalInfo,
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Educational info not found',
            ]);
        }
    }

    public function updateEducationalInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'educational_info_id' => 'required',
            'student_id'          => 'required|integer|exists:students,id',
            'school_name'         => 'required',
            'degree'              => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()]);
        }

        try {
            $educationalInfo = EducationalInfo::where('id', $request->educational_info_id)->first();

            if (!$educationalInfo) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Educational info not found',
                ]);
            }

            $educationalInfo->student_id     = $request->student_id     ?? $educationalInfo->student_id;
            $educationalInfo->school_name    = $request->school_name    ?? $educationalInfo->school_name;
            $educationalInfo->degree         = $request->degree         ?? $educationalInfo->degree;
            $educationalInfo->field_of_study = $request->field_of_study ?? $educationalInfo->field_of_study;
            $educationalInfo->year_started   = $request->year_started   ?? $educationalInfo->year_started;
            $educationalInfo->year_ended     = $request->year_ended     ?? $educationalInfo->year_ended;
            $educationalInfo->gpa            = $request->gpa            ?? $educationalInfo->gpa;
            $educationalInfo->institution    = $request->institution    ?? $educationalInfo->institution;
            $educationalInfo->save();

            return response()->json([
                'status'  => true,
                'message' => 'Educational info updated successfully',
                'data'    => $educationalInfo,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Error during update: ' . $e->getMessage(),
            ]);
        }
    }

    public function deleteEducationalInfo($id)
    {
        $educationalInfo = EducationalInfo::where('id', $id)->first();

        if ($educationalInfo) {
            $educationalInfo->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Educational info deleted successfully',
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Educational info not found',
            ]);
        }
    }
}
