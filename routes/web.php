<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
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

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth:web,employee,company', 'verified'])->name('dashboard');

Route::middleware('auth:web,employee,company')->group(function () {
    # profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/avatar', [ProfileController::class, 'avatar'])->name('profile.avatar');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/upload-avatar', [ProfileController::class, 'uploadAvatar'])->name('profile.upload.avatar');
    Route::patch('/profile/update-personal', [ProfileController::class, 'updatePersonal'])->name('profile.update');
    Route::patch('/profile/update-address', [ProfileController::class, 'updateAddress'])->name('profile.update.address');
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
