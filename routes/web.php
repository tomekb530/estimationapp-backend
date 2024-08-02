<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return "Estimation App Backend";
});

Route::get('/reset-password/{token}', function () {
    return "Estimation App Backend";
})->name('password.reset');
