<?php
use App\Http\Controllers\UsuariosTurmasController;
use Illuminate\Support\Facades\Route;
Route::get('/usuarios-turmas', [UsuariosTurmasController::class, 'all']);
Route::get('/usuarios-turmas/{id}', [UsuariosTurmasController::class, 'one']);
Route::get('/search-usuarios-turmas', [UsuariosTurmasController::class, 'search']);
Route::put('/usuarios-turmas/{id}', [UsuariosTurmasController::class, 'update']);
Route::post('/usuarios-turmas', [UsuariosTurmasController::class, 'create']);