<?php

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

Route::get('/', function() {
    return view('pages.index');
})->name('index');

Route::get('list', function() {
    $users = \App\User::query()->orderBy('id', 'desc')->get();

    return view('pages.all_data', compact('users'));
})->name('list');