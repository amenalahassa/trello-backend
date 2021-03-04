<?php

use Illuminate\Support\Facades\Route;

// Disable all web routes

Route::fallback(function () {
//    $event = new \App\Events\TestEvent();
//    event($event);
    return "Try to access by api. Thanks ";
})->middleware('web');

