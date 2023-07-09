<?php
use App\Http\Controllers\ProvasController;
use Illuminate\Support\Facades\Route;
Route::get('/provas', [ProvasController::class, 'all']);
Route::get('/provas/{id}', [ProvasController::class, 'one']);
Route::get('/search-provas', [ProvasController::class, 'search']);
Route::put('/provas/{id}', [ProvasController::class, 'update']);
Route::post('/provas', [ProvasController::class, 'create']);