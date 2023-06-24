<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::group(['middleware' => 'auth'], function () {
    Route::get('/projects', [\App\Http\Controllers\ProjectController::class, 'index'])->name('project.index');
    Route::get('/projects/import', [\App\Http\Controllers\ProjectController::class, 'import'])->name('project.import');
    Route::post('/projects/import', [\App\Http\Controllers\ProjectController::class, 'importStore'])->name('project.import.store');
    Route::get('/tasks', [\App\Http\Controllers\TaskController::class, 'index'])->name('task.index');
    Route::get('/tasks/${task}/failed_list', [\App\Http\Controllers\TaskController::class, 'failedList'])->name('task.failed_list');
});
require __DIR__ . '/auth.php';
