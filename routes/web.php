<?php

use App\Http\Controllers\Admin\AnimalController;
use App\Http\Controllers\Admin\HouseholdController;
use App\Http\Controllers\Admin\LogEntryController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\SpecialistController;
use App\Http\Controllers\User\NewsController as UserNewsController;
use App\Http\Controllers\User\AnimalController as UserAnimalController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SearchController;
use App\Models\Animal;
use App\Models\Household;
use App\Models\News;
use App\Models\Partner;
use App\Models\Specialist;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
    $households = Household::where('showOnMain', true)->latest()->get();
    return view('users.index', compact('latest_news', 'animals', 'households'));
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

Route::get('/households', function (Request $request) {
    $name = Str::title($request->query('name'));
    $char = $request->query('char');

    $households = Household::when($name, fn($query) => $query->where('name', 'like', "%$name%"))
        ->when($char, fn($query) => $query->where('name', 'like', "$char%"))
        ->latest()
        ->paginate(20)
        ->appends($request->query());

    return view('users.households', compact('households'));
})->name('user.households.index');

Route::get('/households/{household}', function (Household $household) {
    $animals_for_sale = Animal::select('name')
    ->where('household_owner_id', $household->id)
    ->where('forSale', true)
    ->pluck('name')
    ->implode(', ');

    $all_animals = Animal::select('name')
    ->where('household_owner_id', $household->id)
    ->pluck('name')
    ->implode(', ');

    return view('users.household-card', compact('household', 'animals_for_sale', 'all_animals'));
})->name('user.household.show');

Route::get('/specialists', function (Request $request) {
    $name = Str::title($request->query('name'));
    $char = $request->query('char');

    $specialists = Specialist::when($name, fn($query) => $query->where('name', 'like', "%$name%"))
        ->when($char, fn($query) => $query->where('name', 'like', "$char%"))
        ->latest()
        ->paginate(20)
        ->appends($request->query());

    return view('users.specialists', compact('specialists'));
})->name('user.specialists.index');


Route::get('/specialists/{specialist}', function (Specialist $specialist) {

    return view('users.specialists-card', compact('specialist'));
})->name('user.specialist.show');;

Route::get('/sell', function () {
    $animals = Animal::where('forSale', true)->latest()->paginate(16);
    return view('users.sell', compact('animals'));
});

Route::get('/partners', function () {
    $partners = Partner::latest()->paginate(6);

    return view('users.partners', compact('partners'));
})->name('user.partners.index');

Route::get('/partners/{partner}', function (Partner $partner) {

    return view('users.partners-card', compact('partner'));
})->name('user.partner.show');

Route::get('/contacts', function () {
    return view('users.contacts');
});

Route::get('/search', [SearchController::class, 'search'])->name('users.search');

Route::get('/login', function () {
    return view('auth.login');
})
    ->middleware('guest')
    ->name('login');

Route::get('/login', [LoginController::class, 'showLogin'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.submit');
Route::get('/logout', [LoginController::class, 'signOut'])->middleware('auth')->name('logout');

Route::prefix('admin')
    ->middleware('auth')
    ->group(function () {
        Route::resource('news', NewsController::class);

        // Animals

        Route::get('/animals/all', [AnimalController::class, 'index'])->name('animals.index');

        Route::get('/animals/sale', function () {
            $animals = Animal::where('forSale', true)->latest()->paginate(16);
            return view('admin.animals.sale', compact('animals'));
        })->name('animals.index.sale');

        Route::get('/animals/create', [AnimalController::class, 'create'])->name('animals.create');

        Route::post('/animals', [AnimalController::class, 'store'])->name('animals.store');

        Route::get('/animals/{animal}/edit', [AnimalController::class, 'edit'])->name('animals.edit');

        Route::get('/animals/{animal}/{gens?}/{photo?}', [AnimalController::class, 'show'])->name('animals.show');

        Route::put('/animals/{animal}', [AnimalController::class, 'update'])->name('animals.update');

        Route::delete('/animals/{animal}', [AnimalController::class, 'destroy'])->name('animals.destroy');

        // Specialists

        Route::get('/specialists', [SpecialistController::class, 'index'])->name('specialists.index');

        Route::get('/specialists/create', [SpecialistController::class, 'create'])->name('specialist.create');

        Route::post('/specialists', [SpecialistController::class, 'store'])->name('specialist.store');

        Route::get('/specialists/{specialist}/edit', [SpecialistController::class, 'edit'])->name('specialist.edit');

        Route::get('/specialists/{specialist}', [SpecialistController::class, 'show'])->name('specialist.show');

        Route::put('/specialists/{specialist}', [SpecialistController::class, 'update'])->name('specialist.update');

        Route::delete('/specialists/{specialist}', [SpecialistController::class, 'destroy'])->name('specialist.destroy');

        // Partners

        Route::get('/partners', [PartnerController::class, 'index'])->name('partners.index');

        Route::get('/partners/create', [PartnerController::class, 'create'])->name('partner.create');

        Route::post('/partners', [PartnerController::class, 'store'])->name('partner.store');

        Route::get('/partners/{partner}/edit', [PartnerController::class, 'edit'])->name('partner.edit');

        Route::get('/partners/{partner}', [PartnerController::class, 'show'])->name('partner.show');

        Route::put('/partners/{partner}', [PartnerController::class, 'update'])->name('partner.update');

        Route::delete('/partners/{partner}', [PartnerController::class, 'destroy'])->name('partner.destroy');

        // Households

        Route::get('/households', [HouseholdController::class, 'index'])->name('households.index');

        Route::get('/households/create', [HouseholdController::class, 'create'])->name('household.create');

        Route::post('/households', [HouseholdController::class, 'store'])->name('household.store');

        Route::get('/households/{household}/edit', [HouseholdController::class, 'edit'])->name('household.edit');

        Route::get('/households/{household}', [HouseholdController::class, 'show'])->name('household.show');

        Route::put('/households/{household}', [HouseholdController::class, 'update'])->name('household.update');

        Route::delete('/households/{household}', [HouseholdController::class, 'destroy'])->name('household.destroy');

        // Log Entries

        Route::post('/log_entries', [LogEntryController::class, 'store'])->name('log_entry.store');

        Route::delete('/log_entries/{logEntry}', [LogEntryController::class, 'destroy'])->name('log_entry.destroy');
    });

Route::middleware('auth')->group(function () {
    Route::get('/admin/{days?}', function ($days = 7) {
        $animals = Animal::where('updated_at', '>=', Carbon::now()->subDays((int)$days))->paginate(20);
        return view('admin.index', compact('animals'));
    })->name('admin.index');
});
