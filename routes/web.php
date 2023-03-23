<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\DashboardController;

use App\Http\Controllers\ClientController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CeremonyController;

use App\Http\Controllers\TaskController;
use App\Http\Controllers\TagController;

use App\Http\Controllers\BuffetCalculatorController;
use App\Http\Controllers\BuffetController;
use App\Http\Controllers\PlateController;
use App\Http\Controllers\IngredientController;

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

require_once 'fortify.php';

/*
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Route::get('/clients', [ClientController::class, 'index'])->name('clients');
    Route::resource('/clients', ClientController::class);
    Route::resource('/budgets', BudgetController::class);
    Route::resource('/ceremonies', CeremonyController::class);

    Route::resource('/tasks', TaskController::class);
    Route::post('/tasks/duplicate/', [TaskController::class, 'task_duplicate'])->name('task.duplicate');
    Route::patch('/tasks/done/{id}', [TaskController::class, 'task_done'])->name('task.done');
    Route::resource('/tags', TagController::class);

    Route::resource('/buffet-calculator', BuffetCalculatorController::class);
    // Route::resource('/buffets', BuffetController::class);
    Route::controller(BuffetController::class)->group(function () {
        Route::get('/buffets/{type?}', 'index')->name('buffets.index');
        Route::post('/buffets', 'store')->name('buffets.store');
        Route::get('/buffets/create', 'create')->name('buffets.create');
        Route::get('/buffets/{buffet}', 'show')->name('buffets.show');
        Route::put('/buffets/{buffet}', 'update')->name('buffets.update');
        Route::delete('/buffets/{buffet}', 'destroy')->name('buffets.destroy');
        Route::get('/buffets/{buffet}/edit', 'edit')->name('buffets.edit');
    });

    Route::controller(PlateController::class)->group(function () {
        Route::get('/plates/{buffet_id}', 'index')->name('plates.index');
        Route::post('/plates', 'store')->name('plates.store');
        Route::get('/plates/create', 'create')->name('plates.create');
        Route::get('/plates/{plate}', 'show')->name('plates.show');
        Route::put('/plates/{plate}', 'update')->name('plates.update');
        Route::delete('/plates/{plate}', 'destroy')->name('plates.destroy');
        Route::get('/plates/{plate}/edit', 'edit')->name('plates.edit');
    });

    Route::controller(IngredientController::class)->group(function () {
        Route::get('/ingredients/{plate_id}', 'index')->name('ingredients.index');
        Route::post('/ingredients', 'store')->name('ingredients.store');
        Route::get('/ingredients/create', 'create')->name('ingredients.create');
        Route::get('/ingredients/{ingredient}', 'show')->name('ingredients.show');
        Route::put('/ingredients/{ingredient}', 'update')->name('ingredients.update');
        Route::delete('/ingredients/{ingredient}', 'destroy')->name('ingredients.destroy');
        Route::get('/ingredients/{ingredient}/edit', 'edit')->name('ingredients.edit');
    });
    
});
