<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\PersonalInfoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/student/create', [StudentController::class, 'createStudent']);

Route::get('/student/get', [StudentController::class, 'getStudent']);
Route::post('/student/update', [StudentController::class, 'update']);


Route::delete('/student/delete/{id}', [StudentController::class, 'delete']);


Route::get('/student/single/get/{id}', [StudentController::class, 'getStudentSingle']);
Route::get('/student/with-personal-info/{id}', [StudentController::class, 'getStudentWithPersonalInfo']);


Route::post('/personal-info/create', [PersonalInfoController::class, 'createPersonalInfo']);
Route::get('/personal-info/get', [PersonalInfoController::class, 'getPersonalInfo']);
Route::get('/personal-info/single/get/{id}', [PersonalInfoController::class, 'getPersonalInfoSingle']);
Route::post('/personal-info/update', [PersonalInfoController::class, 'updatePersonalInfo']);
Route::delete('/personal-info/delete/{id}', [PersonalInfoController::class, 'deletePersonalInfo']);
