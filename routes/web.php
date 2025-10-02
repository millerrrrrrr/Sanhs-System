<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\QrTesterController;
use App\Http\Controllers\ScannerController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});


Route::get('home', [DashboardController::class, 'home'])->name('home');


Route::prefix('student')->controller(StudentController::class)->group(function(){

    Route::get('register', 'register')->name('register');
    Route::post('register', 'store')->name('registerStudent');
    Route::get('list', 'studentList')->name('studentList');
    Route::get('deleted', 'recentlyDeleted')->name('recentlyDeleted');
    
    Route::get('{id}', 'viewStudent')->name('viewStudent');
    Route::get('{id}/edit' , 'edit')->name('editStudent');
    Route::put('{id}/edit', 'update')->name('updateStudent');
    Route::delete('list/{id}', 'delete')->name('studentDelete');
    Route::post('deleted/{id}', 'restoreStudent')->name('restoreStudent');
    Route::delete('deleted/{id}', 'permanentlyDelete')->name('permanentlyDelete');


});

Route::prefix('level')->controller(LevelController::class)->group(function(){

    Route::get('/', 'index')->name('level');
    Route::post('/', 'add')->name('levelAdd');
    Route::get('/{id}/edit', 'edit')->name('levelEdit');
    Route::patch('/{id}', 'update')->name('levelUpdate');

});


Route::prefix('qrTester')->controller(QrTesterController::class)->group(function(){

    Route::get('/', 'qrTesterIndex')->name('qrTesterIndex');

});


// SCANNER

Route::prefix('scanner')->controller(ScannerController::class)->group(function(){

    Route::get('/', 'scannerIndex')->name('scannerIndex');

});