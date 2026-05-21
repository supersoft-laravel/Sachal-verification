<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VerificationController;

// Public verification
Route::get('/verification', [VerificationController::class, 'index']);
Route::post('/verification', [VerificationController::class, 'verify'])->name('verification.check');

// Admin auth
Route::get('/admin', [AdminController::class, 'loginPage']);
Route::post('/admin/login', [AdminController::class, 'loginPost'])->name('admin.login');
Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Admin dashboard & CRUD
Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
Route::get('/admin/certificates/create', [AdminController::class, 'createPage']);
Route::post('/admin/certificates', [AdminController::class, 'store'])->name('certificates.store');
Route::get('/admin/certificates/{id}/edit', [AdminController::class, 'editPage']);
Route::put('/admin/certificates/{id}', [AdminController::class, 'update'])->name('certificates.update');
Route::delete('/admin/certificates/{id}', [AdminController::class, 'delete'])->name('certificates.delete');

// Redirect root to verification
Route::get('/', function () {
    return redirect('/verification');
});
