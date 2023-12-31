<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SymptomsController;
use App\Http\Controllers\UserDiagnoseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout']);
Route::get('/auth/me', [AuthController::class, 'me']);
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{user}', [UserController::class, 'show']);
Route::delete('users/{user}', [UserController::class, 'delete']);
Route::put('users/{user}', [UserController::class, 'update']);

Route::get('/symptoms', [SymptomsController::class, 'getAllSymptoms'])->middleware('auth');
Route::post('/diagnosis', [SymptomsController::class, 'getDiagnoses'])->middleware('auth');
Route::post('/userdiagnose', [UserDiagnoseController::class, 'create'])->middleware('auth');
Route::get('/userdiagnose/{user_id}', [UserDiagnoseController::class, 'index'])->middleware('auth');
Route::delete('/userdiagnose/{diagnose_id}', [UserDiagnoseController::class, 'delete'])->middleware('auth');