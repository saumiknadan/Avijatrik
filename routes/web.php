<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;


use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard_index');

Route::get('/home', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::prefix('admin')->middleware('auth')->group(function () {
    Route::resource('posts', PostController::class);
    Route::get('post-status{post}', [PostController::class, 'change_status'])->name('posts.status');

});


require __DIR__.'/auth.php';
