<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\UEController;
use App\Http\Controllers\BulletinController;
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

Route::post('/ue', [UEController::class, 'add_ue']);
Route::get('/ue/{code_UE}', [EtudiantController::class, 'get_UE']);

Route::post('/note', [NoteController::class, 'noter']);

Route::post('/bulletin', [BulletinController::class, 'getBulletin']);


#Route pour afficher la note d'un etudiant dans une matiere ( avec matricule et matiere)

#Route pour afficher toutes les infos (avec le matricule et le semestre)

#connexion admin



