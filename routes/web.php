<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dev',function () {
    return view('/dev');
})->middleware('auth')->middleware('admin');

Route::group(['middleware' => ['auth','admin']],function () {
    Route::get('/dev',function () {
        return view('/dev');
    });
    Route::post('/dev',[\App\Http\Controllers\HomeController::class,'dev'])->name('dev');
    Route::post('/verify',[\App\Http\Controllers\HomeController::class,'verify'])->name('verify');
});
