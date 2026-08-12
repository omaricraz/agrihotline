<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ComplaintImportController;
use App\Http\Controllers\ComplaintReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'store'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/complaints/create', [ComplaintController::class, 'create'])->name('complaints.create');
    Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');
    Route::get('/complaints/import', [ComplaintImportController::class, 'create'])->name('complaints.import');
    Route::post('/complaints/import', [ComplaintImportController::class, 'store'])->name('complaints.import.store');
    Route::get('/complaints/import/template', [ComplaintImportController::class, 'template'])->name('complaints.import.template');

    Route::middleware('role:admin,manager')->group(function () {
        Route::get('/complaints/report/pdf', [ComplaintReportController::class, 'pdf'])->name('complaints.report.pdf');
        Route::get('/complaints/report/excel', [ComplaintReportController::class, 'excel'])->name('complaints.report.excel');
    });

    Route::get('/complaints/{complaint}', [ComplaintController::class, 'show'])->name('complaints.show');
    Route::patch('/complaints/{complaint}', [ComplaintController::class, 'update'])->name('complaints.update');
    Route::post('/complaints/{complaint}/notes', [ComplaintController::class, 'storeNote'])
        ->name('complaints.notes.store');

    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
    });
});
