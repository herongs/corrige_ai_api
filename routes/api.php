<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);
Route::post('/login-admin', [AuthController::class, 'loginAdmin']);


Route::middleware(['auth'])->group(function () {
  $authRoutes = glob(__DIR__ . "/authRoutes/*.php");

  foreach ($authRoutes as $authRoute) {
    Route::group([], $authRoute);
  }
});

Route::group([], function () {
  $noAuthRoutes = glob(__DIR__ . "/noAuthRoutes/*.php");

  foreach ($noAuthRoutes as $noAuthRoute) {
    Route::group([], $noAuthRoute);
  }
});
