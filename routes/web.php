<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('getdata',[\App\Http\Controllers\JobController::class, 'index']);
Route::post('postdata',[\App\Http\Controllers\JobController::class, 'store'])->name('job.store');
Route::get('fetchdata',[\App\Http\Controllers\JobController::class, 'fetchdata'])->name('job.fetchdata');
Route::get('removedata',[\App\Http\Controllers\JobController::class, 'removedata'])->name('job.removedata');
Route::get('massremove',[\App\Http\Controllers\JobController::class, 'massremove'])->name('job.massremove');
Route::get('datashow',[\App\Http\Controllers\JobController::class, 'datashow'])->name('job.show');

