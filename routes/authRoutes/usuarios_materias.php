<?php
use App\Http\Controllers\UsuariosMateriasController;
use Illuminate\Support\Facades\Route;
Route::get('/usuarios-materias', [UsuariosMateriasController::class, 'all']);
Route::get('/usuarios-materias/{id}', [UsuariosMateriasController::class, 'one']);
Route::get('/search-usuarios-materias', [UsuariosMateriasController::class, 'search']);
Route::put('/usuarios-materias/{id}', [UsuariosMateriasController::class, 'update']);
Route::post('/usuarios-materias', [UsuariosMateriasController::class, 'create']);