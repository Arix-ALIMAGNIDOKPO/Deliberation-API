<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\EtudiantController;
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

Route::post('/etudiants', [EtudiantController::class, 'addStudent']);
Route::get('/etudiants/{matricule}', [EtudiantController::class, 'getStudent']);

Route::post('/inscription', [EtudiantController::class, 'addStudentRegistration']);
Route::post('/connexion', [EtudiantController::class, 'studentLogin']);
