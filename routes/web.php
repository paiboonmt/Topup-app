<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\TopupController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin route
    Route::get('/admin/dashboard',[AdminController::class,'index'])->name('admin.dashboard');
    // topup
    Route::get('/admin/topup_index',[TopupController::class,'index'])->name('admin.topup_index');
    Route::get('/admin/topup_show',[TopupController::class,'topup_show'])->name('admin.topup_show');

});





require __DIR__.'/auth.php';
