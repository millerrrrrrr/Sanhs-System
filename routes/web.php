<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});


Route::get('home', [DashboardController::class, 'home'])->name('home');


Route::prefix('student')->controller(StudentController::class)->group(function(){

    Route::get('register', 'register')->name('register');

});

Route::prefix('level')->controller(LevelController::class)->group(function(){

    Route::get('/', 'index')->name('level');
    Route::post('/', 'add')->name('levelAdd');
    Route::get('/{id}/edit', 'edit')->name('levelEdit');
    Route::patch('/{id}', 'update')->name('levelUpdate');

});