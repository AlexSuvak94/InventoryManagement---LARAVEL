<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;

Route::post('/deleteCars', [CarController::class, 'deleteCars']);
Route::get('/requestCars', [CarController::class, 'returnCars']); // This is called via AJAX to get the list of cars ordered by specific parameters