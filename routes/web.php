<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

// Route::get('/', function () {
//     return view('admin.index');
// })->middleware(['auth', 'verified'])->name('dashboard_index');

// Route::get('/home', function () {
//     return view('admin.index');
// })->middleware(['auth', 'verified'])->name('dashboard');

use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard_index');

Route::get('/home', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::get('/create', function () {
//     return view('admin.blog.create');
// });

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::resource('posts', PostController::class);
    Route::get('post-status{post}', [PostController::class, 'change_status'])->name('posts.status');

});

Route::get('/cache/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return redirect()->back()->with('success','System Cache Has Been Removed.');
  })->name('admin-cache-clear');

require __DIR__.'/auth.php';
