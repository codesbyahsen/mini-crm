<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\EmployeeController;

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
    # profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/avatar', [ProfileController::class, 'avatar'])->name('profile.avatar');
    Route::get('/profile/{profile}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/{profile}/upload-avatar', [ProfileController::class, 'uploadAvatar'])->name('profile.upload.avatar');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    # company
    Route::resource('companies', CompanyController::class);
    Route::get('/total/companies', [CompanyController::class, 'totalCompanies'])->name('companies.total');

    # employee
    Route::resource('employees', EmployeeController::class);
    Route::get('/total/employees', [EmployeeController::class, 'totalEmployees'])->name('employees.total');

    # project
    Route::resource('projects', ProjectController::class);
    Route::get('/total/projects', [ProjectController::class, 'totalProjects'])->name('projects.total');
});


require __DIR__ . '/auth.php';
