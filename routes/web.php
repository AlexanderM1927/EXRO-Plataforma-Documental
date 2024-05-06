<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GeneralController::class, 'login'])->name('login');

Route::post('/auth', [AuthController::class, 'authenticate']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/dashboard', [GeneralController::class, 'show'])
    ->name('dashboard')
    ->middleware(['auth']);


Route::middleware(['auth', 'role:admin'])->prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users');
    Route::get('/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('users.delete');
});

Route::middleware(['auth', 'role:admin'])->prefix('departments')->group(function () {
    Route::get('/', [DepartmentController::class, 'index'])->name('departments');
    Route::get('/create', [DepartmentController::class, 'create'])->name('departments.create');
    Route::post('/store', [DepartmentController::class, 'store'])->name('departments.store');
    Route::get('/edit/{id}', [DepartmentController::class, 'edit'])->name('departments.edit');
    Route::put('/update/{id}', [DepartmentController::class, 'update'])->name('departments.update');
    Route::delete('/delete/{id}', [DepartmentController::class, 'delete'])->name('departments.delete');
});

Route::middleware(['auth'])->prefix('files')->group(function () {
    Route::get('/', [FileController::class, 'index'])->name('files');
    Route::get('/search', [FileController::class, 'search'])->name('files.search');
    Route::get('/create', [FileController::class, 'create'])->name('files.create');
    Route::post('/store', [FileController::class, 'store'])->name('files.store');
    Route::get('/edit/{id}', [FileController::class, 'edit'])->name('files.edit');
    Route::put('/update/{id}', [FileController::class, 'update'])->name('files.update');
    Route::get('/download/{id}', [FileController::class, 'download'])->name('files.download');
    Route::delete('/delete/{id}', [FileController::class, 'delete'])->middleware(['role:admin'])->name('files.delete');
});
