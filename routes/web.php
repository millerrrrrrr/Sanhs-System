<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\QrTesterController;
use App\Http\Controllers\ScannerController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/', [AuthController::class, 'login'])->name('loginPost')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['authCheck', 'admin'])->group(function () {

    Route::get('home', [DashboardController::class, 'home'])->name('home');


    Route::get('/changePassword', [ChangePasswordController::class, 'changePasswordIndex'])->name('changePasswordIndex');
    Route::put('/changePassword', [ChangePasswordController::class, 'changePassword'])->name('changePassword');

    Route::get('/backup', [BackupController::class, 'index'])->name('backupIndex');
    Route::post('/backup', [BackupController::class, 'backup'])->name('backup.run');

    Route::prefix('student')->controller(StudentController::class)->group(function () {

        Route::get('register', 'register')->name('register');
        Route::post('register', 'store')->name('registerStudent');
        Route::get('list', 'studentList')->name('studentList');
        Route::get('deleted', 'recentlyDeleted')->name('recentlyDeleted');

        Route::get('{id}', 'viewStudent')->name('viewStudent');
        Route::get('{id}/edit', 'edit')->name('editStudent');
        Route::put('{id}/edit', 'update')->name('updateStudent');
        Route::delete('list/{id}', 'delete')->name('studentDelete');
        Route::post('deleted/{id}', 'restoreStudent')->name('restoreStudent');
        Route::delete('deleted/{id}', 'permanentlyDelete')->name('permanentlyDelete');
    });

    Route::prefix('level')->controller(LevelController::class)->group(function () {

        Route::get('/', 'index')->name('level');
        Route::post('/', 'add')->name('levelAdd');
        Route::get('/{id}/edit', 'edit')->name('levelEdit');
        Route::patch('/{id}', 'update')->name('levelUpdate');
    });


    Route::prefix('qrTester')->controller(QrTesterController::class)->group(function () {

        Route::get('/', 'qrTesterIndex')->name('qrTesterIndex');
        Route::get('/get-student/{lrn}', 'getStudentByLrn')->name('getStudentByLrn');
    });


    // SCANNER

    Route::prefix('attendance')->controller(AttendanceController::class)->group(function () {

        Route::get('/', 'AttendanceIndex')->name('attendanceIndex');
        Route::get('/filter', 'filter')->name('attendanceFilter');
    });
});


Route::middleware(['authCheck', 'attendance'])->group(function () {
    Route::prefix('scanner')->controller(ScannerController::class)->group(function () {

        Route::get('/', 'scannerIndex')->name('scannerIndex');
        Route::get('/attendance/record/{lrn}', 'record');
    });
});


// Route::get('/get-student/{lrn}', [StudentController::class, 'getStudentByLrn']);