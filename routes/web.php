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

Route::get('/', [Attecontroller::class, 'date'])->name('date');
Route::get('/stamp', [Attecontroller::class, 'stamp'])->name('stamp');
// Route::get('/stamp/start_time/{attendance}', [Attecontroller::class, 'start_time']);
Route::post('/stamp/start_time/{id}', [Attecontroller::class, 'edie'])->name('edit');
Route::post('/stamp/end_time', [Attecontroller::class, 'end_time'])->name('end_time');
Route::post('/stamp/lest_start_time', [Attecontroller::class, 'lest_start_time'])->name('lest_start_time');
Route::post('/stamp/lest_end_time', [Attecontroller::class, 'lest_end_time'])->name('lest_end_time');
Route::get('/edit/{id}', [Attecontroller::class, 'edit'])->name('edit');

