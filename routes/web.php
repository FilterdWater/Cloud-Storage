<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/my-files', [FileController::class, 'index'])->middleware(['auth', 'verified'])->name('my-files');

Route::post('/upload-file', [FileController::class, 'upload'])->name('files.upload');

Route::get('/shared', function () {
    return view('shared');
})->middleware(['auth', 'verified'])->name('shared');

Route::get('/shared-with-me', function () {
    return view('shared-with-me');
})->middleware(['auth', 'verified'])->name('shared-with-me');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
