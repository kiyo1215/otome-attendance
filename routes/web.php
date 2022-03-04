<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RestController;
use App\Http\Controllers\ManagementController;

Route::middleware('auth')->group(function(){
    Route::get('/', [AttendanceController::class, 'index'])->name('index');
    
    Route::post('/attendance/start', [AttendanceController::class, 'start'])->name('start');
    Route::post('/attendance/end', [AttendanceController::class, 'end'])->name('end');
    Route::post('/rest/start', [Restcontroller::class, 'start'])->name('start');
    Route::post('/rest/end', [Restcontroller::class, 'end'])->name('end');

    Route::get('/management', [ManagementController::class, 'management'])->name('management');
    // Route::get('/management', [ManagementController::class, 'date'])->name('date');
    Route::post('/management', [ManagementController::class, 'search'])->name('search');
    Route::get('/atte', [ManagementController::class, 'show_atte'])->name('show_atte');
    Route::post('/atte/update', [ManagementController::class, 'change_atte'])->name('change_atte');
    Route::post('/atte/search', [ManagementController::class, 'atte_search'])->name('atte_search');
    Route::get('/rest', [ManagementController::class, 'show_rest'])->name('show_rest');
    Route::post('/rest/update', [ManagementController::class, 'change_rest'])->name('change_rest');
    Route::post('/rest/search', [ManagementController::class, 'search_rest'])->name('search_rest');
    Route::get('/reward', [ManagementController::class, 'show_reward'])->name('show_reward');
    Route::get('/reward/csv', [ManagementController::class, 'show_csv'])->name('show_csv');
    Route::post('/reward/attecsv', [ManagementController::class, 'atte_csv'])->name('atte_csv');
    Route::post('/reward/restcsv', [ManagementController::class, 'rest_csv'])->name('rest_csv');
    Route::post('/create', [ManagementController::class, 'create'])->name('create');
    Route::post('/graduation/dalete', [ManagementController::class, 'delete'])->name('delete');
});
Route::get('/graduation', [ManagementController::class, 'graduation'])->name('graduation');

require __DIR__.'/auth.php';
