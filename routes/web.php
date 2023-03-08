<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\BuffetCalculatorController;
use App\Http\Controllers\TagController;

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

    Route::get('/tasks/{code?}', [TaskController::class, 'index'])->name('tasks')->whereNumber('code');
    Route::resource('/tasks', TaskController::class);
    Route::post('/tasks/duplicate/', [TaskController::class, 'task_duplicate'])->name('task.duplicate');
    Route::patch('/tasks/done/{id}', [TaskController::class, 'task_done'])->name('task.done');
    Route::resource('/tags', TagController::class);

    Route::get('/buffet-calculator', [BuffetCalculatorController::class, 'index'])->name('buffet-calculator');
});
