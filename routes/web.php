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
