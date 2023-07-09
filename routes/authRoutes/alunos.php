<?php
use App\Http\Controllers\AlunosController;
use Illuminate\Support\Facades\Route;
Route::get('/alunos', [AlunosController::class, 'all']);
Route::get('/alunos/{id}', [AlunosController::class, 'one']);
Route::get('/search-alunos', [AlunosController::class, 'search']);
Route::put('/alunos/{id}', [AlunosController::class, 'update']);
Route::post('/alunos', [AlunosController::class, 'create']);