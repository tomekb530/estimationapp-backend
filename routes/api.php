<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\EstimationController;

Route::get('/me', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum','role:superadmin'])->group(function(){
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::put('users/{id}', [UserController::class, 'update']);
});

Route::middleware(['auth:sanctum','role:admin'])->group(function(){
    Route::get('/clients', [ClientController::class, 'index']);
    Route::post('/clients', [ClientController::class, 'create']);
    Route::delete('clients/{id}', [ClientController::class, 'destroy']);
    Route::get('clients/{id}', [ClientController::class, 'show']);
    Route::post('clients/{id}', [ClientController::class, 'update']);//PHP BUG FORMDATA
    Route::get('clients/{id}/logo', [ClientController::class, 'logo']);
});

Route::middleware(['auth:sanctum','role:admin'])->group(function(){
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::post('/projects', [ProjectController::class, 'create']);
    Route::delete('projects/{id}', [ProjectController::class, 'destroy']);
    Route::get('projects/{id}', [ProjectController::class, 'show']);
    Route::post('projects/{id}', [ProjectController::class, 'update']);
});

Route::middleware(['auth:sanctum','role:admin'])->group(function(){
    Route::get('/estimations', [EstimationController::class, 'index']);
    Route::post('/estimations', [EstimationController::class, 'create']);
    Route::delete('estimations/{id}', [EstimationController::class, 'destroy']);
    Route::get('estimations/{id}', [EstimationController::class, 'show']);
    Route::put('estimations/{id}', [EstimationController::class, 'update']);
});


