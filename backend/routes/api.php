<?php

use App\Http\Controllers\ActividadController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(ActividadController::class)->group(function () {
    Route::post('/actividades/store', 'store');
    Route::post('/actividades/update/{id}', 'update');
    Route::post('/actividades/destroy/{id}', 'destroy');
    Route::get('/actividades/show/{id}', 'show');
    Route::get('/actividades/index', 'index');
});

Route::controller(UserController::class)->group(function () {
    Route::post('/usuarios/store', 'store');
    Route::get('/usuarios/index', 'index');
    Route::get('/usuarios/show/{id}', 'show');
    Route::get('/usuarios/index', 'index');
});
