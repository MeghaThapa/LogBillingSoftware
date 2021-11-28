<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/userList', [App\Http\Controllers\UserController::class, 'index'])->name('user.index')->middleware('auth');
Route::get('/userList/add', [App\Http\Controllers\UserController::class, 'add'])->name('user.create')->middleware('auth');
Route::post('/userList/store', [App\Http\Controllers\UserController::class, 'store'])->name('user.store')->middleware('auth');
Route::get('/userList/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit')->middleware('auth');
Route::post('/userList/update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('user.update')->middleware('auth');
Route::post('/userList/editPW', [App\Http\Controllers\UserController::class, 'editPW'])->name('user.editPW')->middleware('auth');
Route::delete('/userList/delete/{id}', [App\Http\Controllers\UserController::class, 'delete'])->name('user.delete')->middleware('auth');

