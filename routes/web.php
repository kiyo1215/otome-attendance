<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RestController;
// use App\Http\Controllers\Auth\uthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('auth.login');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/', [AttendanceController::class, 'index'])->name('index');
Route::get('/attendance', [AttendanceController::class, 'date'])->name('date');

Route::get('/attendance/start_time', [AttendanceController::class, 'start_edit'])->name('start_edit');
Route::post('/attendance/start_time', [AttendanceController::class, 'start_time'])->name('start_time');

Route::get('/attendance/end_time/{id}', [AttendanceController::class, 'end_edit'])->name('end_edit');
Route::post('/attendance/end_time/{id}', [AttendanceController::class, 'end_time'])->name('end_time');

Route::get('/rest/start_time/{id}', [Restcontroller::class, 'start_edit'])->name('start_edit');
Route::post('/rest/start_time/{id}', [Restcontroller::class, 'start_time'])->name('start_time');

Route::get('/rest/end_time/{id}', [Restcontroller::class, 'end_edit'])->name('end_edit');
Route::post('/rest/end_time/{id}', [Restcontroller::class, 'end_time'])->name('end_time');

