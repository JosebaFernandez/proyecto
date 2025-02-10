<?php

use App\Http\Controllers\ActividadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('actividad', [ActividadController::class, 'store']);
