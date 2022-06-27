<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RestController;
use App\Http\Controllers\ManagementController;

Route::middleware('auth')->group(function(){
    Route::get('/', [AttendanceController::class, 'index'])->name('index');
    
    Route::post('/attendance/start', [AttendanceController::class, 'start'])->name('start');
    Route::post('/attendance/end', [AttendanceController::class, 'end'])->name('end');

    Route::post('/rest/start', [AttendanceController::class, 'rest_start'])->name('rest_start');
    Route::post('/rest/end', [AttendanceController::class, 'rest_end'])->name('rest_end');
    
    Route::get('/management', [ManagementController::class, 'management'])->name('management');
    // Route::get('/management', [ManagementController::class, 'date'])->name('date');
    Route::post('/management', [ManagementController::class, 'search'])->name('search');
    Route::get('/atte', [ManagementController::class, 'show_atte'])->name('show_atte');
    Route::post('/atte/update', [ManagementController::class, 'change_atte'])->name('change_atte');
    Route::post('/atte/search', [ManagementController::class, 'atte_search'])->name('atte_search');
    Route::get('/atte/delete/{id}', [ManagementController::class, 'atte_delete'])->name('atte_delete');

    Route::get('/rest', [ManagementController::class, 'show_rest'])->name('show_rest');
    Route::post('/rest/update', [ManagementController::class, 'change_rest'])->name('change_rest');
    Route::post('/rest/search', [ManagementController::class, 'search_rest'])->name('search_rest');
    Route::get('/reward', [ManagementController::class, 'show_reward'])->name('show_reward');
    Route::get('/reward/csv', [ManagementController::class, 'show_csv'])->name('show_csv');
    Route::post('/reward/attecsv', [ManagementController::class, 'atte_csv'])->name('atte_csv');
    Route::post('/reward/restcsv', [ManagementController::class, 'rest_csv'])->name('rest_csv');
    Route::post('/graduation/dalete', [ManagementController::class, 'delete'])->name('delete');
});

require __DIR__.'/auth.php';
Route::get('/graduation', [ManagementController::class, 'graduation'])->name('graduation');
Route::post('/create', [ManagementController::class, 'create'])->name('create');
Route::get('/change', [ManagementController::class, 'aaa'])->name('aaa');
Route::post('/change', [ManagementController::class, 'bbb'])->name('bbb');
