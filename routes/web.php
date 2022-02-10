<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RestController;

Route::middleware('auth')->group(function(){
    Route::get('/', [AttendanceController::class, 'index'])->name('index');
    Route::get('/attendance', [AttendanceController::class, 'date'])->name('date');
    Route::post('/attendance/start', [AttendanceController::class, 'start'])->name('start');
    Route::post('/attendance/end', [AttendanceController::class, 'end'])->name('end');
    Route::post('/rest/start', [Restcontroller::class, 'start'])->name('start');
    Route::post('/rest/end', [Restcontroller::class, 'end'])->name('end');
});

require __DIR__.'/auth.php';
