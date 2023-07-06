<?php
use App\Http\Controllers\TurmasController;
use Illuminate\Support\Facades\Route;
Route::get('/turmas', [TurmasController::class, 'all']);
Route::get('/turmas/{id}', [TurmasController::class, 'one']);
Route::get('/search-turmas', [TurmasController::class, 'search']);
Route::put('/turmas/{id}', [TurmasController::class, 'update']);
Route::post('/turmas', [TurmasController::class, 'create']);