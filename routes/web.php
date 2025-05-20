<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;

Route::get('/', function () {
    return view('cars-view'); // The main view
});

Route::post('/add-car', [CarController::class, 'store']); // This handles creation of a new item (car)