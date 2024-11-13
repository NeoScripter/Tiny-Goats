<?php

use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\User\NewsController as UserNewsController;
use App\Http\Controllers\Auth\LoginController;
use App\Models\News;
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
    $latest_news = News::latest()->take(4)->get();
    return view('users.index', compact('latest_news'));
});

Route::get('/agenda', function () {
    $latest_news = News::latest()->take(4)->get();
    return view('users.agenda', compact('latest_news'));
});

Route::get('/faq', function () {
    return view('users.faq');
});

Route::get('/rules', function () {
    return view('users.rules');
});

Route::get('/news/category/{category?}', [UserNewsController::class, 'index'])->name('user.news.index');

Route::get('/news/{news}', function (News $news) {
    $latest_news = News::latest()->take(4)->get();
    return view('users.news-show', compact('news', 'latest_news'));
})->name('user.news.show');

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

Route::get('/contacts', function () {
    return view('users.contacts');
});

Route::get('/search', function () {
    return view('users.search');
});

Route::get('/login', function () {
    return view('auth.login');
})
    ->middleware('guest')
    ->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/admin', function () {
        return view('admin.index');
    });
});

Route::get('/login', [LoginController::class, 'showLogin'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'signOut'])->middleware('auth')->name('logout');

Route::prefix('admin')
    ->middleware('auth')
    ->group(function () {
        Route::resource('news', NewsController::class);
    });
