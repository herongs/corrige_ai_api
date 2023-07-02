<?php
use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Route;
Route::get('/Usuarios', [UsuariosController::class, 'all']);
Route::get('/Usuarios/{id}', [UsuariosController::class, 'one']);
Route::get('/search-Usuarios', [UsuariosController::class, 'search']);
Route::put('/Usuarios/{id}', [UsuariosController::class, 'update']);
Route::post('/Usuarios', [UsuariosController::class, 'create']);