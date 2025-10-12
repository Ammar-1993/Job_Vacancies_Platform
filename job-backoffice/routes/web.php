<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobApplicationController;






Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Companies
    Route::resource('companies', CompanyController::class);
    Route::put('companies/{id}/restore', [CompanyController::class, 'restore'])->name('companies.restore');
    Route::get('/my-company', [CompanyController::class, 'show'])->name('my-company.show');

    // Job Categories
    Route::resource('job-categories', JobCategoryController::class);
    Route::put('job-categories/{job_category}/restore', [JobCategoryController::class, 'restore'])->name('job-categories.restore');

    // Job Vacancies
    Route::resource('job-vacancies', JobVacancyController::class);
    // Restore route for soft-deleted job vacancies
    Route::put('job-vacancies/{id}/restore', [JobVacancyController::class, 'restore'])->name('job-vacancies.restore');

    // Job Applications
    Route::resource('job-applications', JobApplicationController::class);
    // Restore route for soft-deleted job applications
    Route::put('job-applications/{id}/restore', [JobApplicationController::class, 'restore'])->name('job-applications.restore');

    // Users
    Route::resource('users', UserController::class);
    Route::put('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore' );

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
