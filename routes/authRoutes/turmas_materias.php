<?php
use App\Http\Controllers\TurmasMateriasController;
use Illuminate\Support\Facades\Route;
Route::get('/turmas-materias', [TurmasMateriasController::class, 'all']);
Route::get('/turmas-materias/{id}', [TurmasMateriasController::class, 'one']);
Route::get('/search-turmas-materias', [TurmasMateriasController::class, 'search']);
Route::put('/turmas-materias/{id}', [TurmasMateriasController::class, 'update']);
Route::post('/turmas-materias', [TurmasMateriasController::class, 'create']);