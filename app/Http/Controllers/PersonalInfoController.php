<?php

namespace App\Http\Controllers;

use App\Models\PersonalInfo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PersonalInfoController extends Controller
{
    public function createPersonalInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id'  => 'required|integer|exists:students,id',
            'father_name' => 'required',
            'mother_name' => 'required',
            'height'      => 'nullable|numeric',
            'weight'      => 'nullable|numeric',
            'skin_color'  => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()]);
        }

        try {
            $personalInfo = new PersonalInfo();
            $personalInfo->student_id  = $request->student_id;
            $personalInfo->father_name = $request->father_name;
            $personalInfo->mother_name = $request->mother_name;
            $personalInfo->height      = $request->height;
            $personalInfo->weight      = $request->weight;
            $personalInfo->skin_color  = $request->skin_color;
            $personalInfo->save();

            return response()->json([
                'status'  => true,
                'message' => 'Personal info created successfully',
                'data'    => $personalInfo,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Error during store: ' . $e->getMessage(),
            ]);
        }
    }

    public function getPersonalInfo(Request $request)
    {
        $per_page = $request->per_page;

        $personalInfos = PersonalInfo::with('student')->orderBy('id', 'asc')->paginate($per_page);

        if (!$personalInfos->isEmpty()) {
            return response()->json([
                'status'  => true,
                'message' => 'Personal info get successfully',
                'data'    => $personalInfos,
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Personal info not found',
            ]);
        }
    }

    public function getPersonalInfoSingle($id)
    {
        $personalInfo = PersonalInfo::where('id', $id)->first();

        if ($personalInfo) {
            return response()->json([
                'status'  => true,
                'message' => 'Personal info get successfully',
                'data'    => $personalInfo,
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Personal info not found',
            ]);
        }
    }

    public function updatePersonalInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'personal_info_id' => 'required',
            'student_id'       => 'required|integer|exists:students,id',
            'height'           => 'required|numeric',
            'weight'           => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'error' => $validator->errors()]);
        }

        try {
            $personalInfo = PersonalInfo::where('id', $request->personal_info_id)->first();

            if (!$personalInfo) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Personal info not found',
                ]);
            }

            $personalInfo->student_id  = $request->student_id  ?? $personalInfo->student_id;
            $personalInfo->father_name = $request->father_name ?? $personalInfo->father_name;
            $personalInfo->mother_name = $request->mother_name ?? $personalInfo->mother_name;
            $personalInfo->height      = $request->height      ?? $personalInfo->height;
            $personalInfo->weight      = $request->weight      ?? $personalInfo->weight;
            $personalInfo->skin_color  = $request->skin_color  ?? $personalInfo->skin_color;
            $personalInfo->save();

            return response()->json([
                'status'  => true,
                'message' => 'Personal info updated successfully',
                'data'    => $personalInfo,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Error during update: ' . $e->getMessage(),
            ]);
        }
    }

    public function deletePersonalInfo($id)
    {
        $personalInfo = PersonalInfo::where('id', $id)->first();

        if ($personalInfo) {
            $personalInfo->delete();
            return response()->json([
                'status'  => true,
                'message' => 'Personal info deleted successfully',
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Personal info not found',
            ]);
        }
    }
}
