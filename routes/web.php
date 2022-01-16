<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AtteController;
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
// Route::get('/', function () {
//     return view('atte.stamp');
// });
// Route::get('/', function () {
//     return view('atte.date');
// })->('date');
// Route::get('/', function () {
//     return view('atte.date');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/date', [Attecontroller::class, 'date'])->name('date');
Route::get('/', [Attecontroller::class, 'stamp'])->name('stamp');

Route::get('/stamp/start_time', [Attecontroller::class, 'start_edit'])->name('start_edit');
Route::post('/stamp/start_time', [Attecontroller::class, 'start_time'])->name('start_time');

Route::get('/stamp/end_time/{id}', [Attecontroller::class, 'end_edit'])->name('end_edit');
Route::post('/stamp/end_time/{id}', [Attecontroller::class, 'end_time'])->name('end_time');

Route::get('/stamp/rest_start_time/{id}', [Attecontroller::class, 'rest_start_edit'])->name('rest_start_edit');
Route::post('/stamp/rest_start_time/{id}', [Attecontroller::class, 'rest_start_time'])->name('rest_start_time');

Route::get('/stamp/rest_end_time/{id}', [Attecontroller::class, 'rest_end_edit'])->name('rest_end_edit');
Route::post('/stamp/rest_end_time/{id}', [Attecontroller::class, 'rest_end_time'])->name('rest_end_time');

