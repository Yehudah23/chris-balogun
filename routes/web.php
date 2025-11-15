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

// Login page
Route::get('/login', function () {
    return view('login');
})->name('login');

// Admin page (client-side access control in the component)
Route::get('/admin', function () {
    return view('admin');
})->name('admin');
