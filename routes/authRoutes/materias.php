<?php
use App\Http\Controllers\MateriasController;
use Illuminate\Support\Facades\Route;


Route::get('/materias', [MateriasController::class, 'all']);
Route::get('/materias/{id}', [MateriasController::class, 'one']);
Route::get('/search-materias', [MateriasController::class, 'search']);
Route::put('/materias/{id}', [MateriasController::class, 'update']);
Route::post('/materias', [MateriasController::class, 'create']);
