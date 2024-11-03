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
    return view('users.index');
});

Route::get('/agenda', function () {
    return view('users.agenda');
});

Route::get('/faq', function () {
    return view('users.faq');
});

Route::get('/rules', function () {
    return view('users.rules');
});

Route::get('/news', function () {
    return view('users.news');
});

Route::get('/news/1', function () {
    return view('users.news-show');
});

Route::get('/animals', function () {
    return view('users.animals');
});

Route::get('/register', function () {
    return view('users.register');
});

Route::get('/animals/1', function () {
    return view('users.animal-card');
});

Route::get('/coupling', function () {
    return view('users.coupling');
});

Route::get('/households', function () {
    return view('users.households');
});

Route::get('/households/1', function () {
    return view('users.household-card');
});

Route::get('/specialists', function () {
    return view('users.specialists');
});

Route::get('/specialists/1', function () {
    return view('users.specialists-card');
});

Route::get('/sell', function () {
    return view('users.sell');
});

Route::get('/partners', function () {
    return view('users.partners');
});

Route::get('/partners/1', function () {
    return view('users.partners-card');
});
