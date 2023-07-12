<?php
use App\Http\Controllers\GabaritoQuestoesController;
use Illuminate\Support\Facades\Route;
Route::get('/gabarito-questoes', [GabaritoQuestoesController::class, 'all']);
Route::get('/gabarito-questoes/{id}', [GabaritoQuestoesController::class, 'one']);
Route::get('/search-gabarito-questoes', [GabaritoQuestoesController::class, 'search']);
Route::put('/gabarito-questoes/{id}', [GabaritoQuestoesController::class, 'update']);
Route::post('/gabarito-questoes', [GabaritoQuestoesController::class, 'create']);