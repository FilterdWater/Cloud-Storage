<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ShareController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('welcome', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/my-files', [FileController::class, 'index'])->name('my-files');
    Route::post('/upload-file', [FileController::class, 'upload'])->name('files.upload');
    Route::post('/files/download', [FileController::class, 'download'])->name('files.download');
    Route::delete('/files/{id}/delete', [FileController::class, 'destroy'])->name('files.delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/shared', [ShareController::class, 'shared'])->middleware(['auth', 'verified'])->name('shared');
    Route::post('/share/{id}', [ShareController::class, 'store'])->name('share.store');
    Route::delete('/shared/{id}/delete', [ShareController::class, 'destroy'])->middleware(['auth', 'verified'])->name('shared.delete');
    Route::get('/shared-with-me', [ShareController::class, 'sharedWithMe'])->middleware(['auth', 'verified'])->name('shared-with-me');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
