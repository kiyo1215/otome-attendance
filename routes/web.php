<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RestController;
use App\Http\Controllers\ManagementController;

Route::middleware('auth')->group(function(){
    Route::get('/', [AttendanceController::class, 'index'])->name('index');
    Route::get('/attendance', [AttendanceController::class, 'date'])->name('date');
    Route::post('/attendance', [AttendanceController::class, 'search'])->name('search');
    Route::post('/attendance/start', [AttendanceController::class, 'start'])->name('start');
    Route::post('/attendance/end', [AttendanceController::class, 'end'])->name('end');
    Route::post('/rest/start', [Restcontroller::class, 'start'])->name('start');
    Route::post('/rest/end', [Restcontroller::class, 'end'])->name('end');

    Route::get('/change/atte', [ManagementController::class, 'showAtte'])->name('showAtte');
    Route::get('/change/rest', [ManagementController::class, 'showRest'])->name('showRest');
    Route::post('/change/atte', [ManagementController::class, 'changeAtte'])->name('changeAtte');
    Route::post('/change/rest', [ManagementController::class, 'changeRest'])->name('changeRest');
});

require __DIR__.'/auth.php';
