<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\JobApplicatioController;
use App\Http\Controllers\UserController;






Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Companies
    Route::resource('companies', CompanyController::class);

    // Job Categories
    Route::resource('job-categories', JobCategoryController::class);
    Route::put('job-categories/{job_category}/restore', [JobCategoryController::class, 'restore'])->name('job-categories.restore');

    // Job Vacancies
    Route::resource('job-vacancies', JobVacancyController::class);

    // Job Applications
    Route::resource('job-applications', JobApplicatioController::class);

    // Users
    Route::resource('users', UserController::class);

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
