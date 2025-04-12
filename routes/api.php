<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ReceiveController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\PersonController;
use App\Http\Controllers\API\CommonDescriptionController;

// Public routes (no authentication required)
Route::get('/receipts/next-number', [ReceiveController::class, 'getNextNumber']);
Route::get('/persons', [PersonController::class, 'index']);
Route::get('/projects', [ProjectController::class, 'index']);
Route::resource('persons', PersonController::class);
Route::resource('projects', ProjectController::class);