<?php

use App\Http\Controllers\StudentController;
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
