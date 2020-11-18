<?php

use Illuminate\Support\Facades\Route;

// Disable all web routes

Route::fallback(function () {
    return "Try to access by api. Thanks ";
})->middleware('web');

