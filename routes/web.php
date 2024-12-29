<?php

use App\Http\Controllers\Admin\AnimalController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\User\NewsController as UserNewsController;
use App\Http\Controllers\User\AnimalController as UserAnimalController;
use App\Http\Controllers\Auth\LoginController;
use App\Models\Animal;
use App\Models\News;
use Carbon\Carbon;
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
    $latest_news = News::inRandomOrder()->take(4)->get();
    $animals = Animal::where('showOnMain', true)->latest()->get();
    return view('users.index', compact('latest_news', 'animals'));
});

Route::get('/agenda', function () {
    $latest_news = News::inRandomOrder()->take(4)->get();
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
    $latest_news = News::inRandomOrder()->take(4)->get();
    return view('users.news-show', compact('news', 'latest_news'));
})->name('user.news.show');

Route::get('/animals', [UserAnimalController::class, 'index'])->name('user.animals.index');

Route::get('/register', function () {
    return view('users.register');
});

Route::get('/animals/{animal}/{gens?}/{photo?}', [UserAnimalController::class, 'show'])->name('user.animals.show');

Route::get('/coupling', [UserAnimalController::class, 'coupling'])->name('user.coupling');

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
    $animals = Animal::where('forSale', true)->latest()->paginate(16);
    return view('users.sell', compact('animals'));
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

Route::get('/login', [LoginController::class, 'showLogin'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'signOut'])->middleware('auth')->name('logout');

Route::prefix('admin')
    ->middleware('auth')
    ->group(function () {
        Route::resource('news', NewsController::class);

        // Animals

        Route::get('/animals/category/{category?}', [AnimalController::class, 'index'])->name('animals.index');

        Route::get('/animals/create', [AnimalController::class, 'create'])->name('animals.create');

        Route::post('/animals', [AnimalController::class, 'store'])->name('animals.store');

        Route::get('/animals/{animal}/edit', [AnimalController::class, 'edit'])->name('animals.edit');

        Route::get('/animals/{animal}/{gens?}/{photo?}', [AnimalController::class, 'show'])->name('animals.show');

        Route::put('/animals/{animal}', [AnimalController::class, 'update'])->name('animals.update');

        Route::delete('/animals/{animal}', [AnimalController::class, 'destroy'])->name('animals.destroy');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/admin/{days?}', function ($days = 7) {
            $animals = Animal::where('updated_at', '>=', Carbon::now()->subDays((int)$days))->paginate(20);
            return view('admin.index', compact('animals'));
        })->name('admin.index');
    });
