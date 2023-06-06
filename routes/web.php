<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

# company
Route::controller(CompanyController::class)->prefix('companies')->group(function () {
    Route::get('/', 'index')->name('companies');
    // Route::get('/create', 'create')->name('companies.create');
    Route::post('/store', 'store')->name('companies.store');
    // Route::get('/show/{company}', 'show')->name('companies.show');
    // Route::get('/edit/{company}', 'edit')->name('companies.edit');
    Route::put('/update/{company}', 'update')->name('companies.update');
    Route::delete('/destroy/{company}', 'destroy')->name('companies.destroy');
});

# employee
Route::controller(EmployeeController::class)->prefix('employees')->group(function () {
    Route::get('/', 'index')->name('employees');
    Route::post('/store', 'store')->name('employees.store');
    Route::put('/update/{company}', 'update')->name('employees.update');
    Route::delete('/destroy/{company}', 'destroy')->name('employees.destroy');
});

require __DIR__.'/auth.php';
