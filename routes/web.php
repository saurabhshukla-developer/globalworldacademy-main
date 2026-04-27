<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/quiz', function () {
    return view('quiz');
})->name('quiz');
