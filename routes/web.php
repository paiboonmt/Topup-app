<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\TopupController;
use App\Http\Controllers\Admin\TrainerController;
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
});

// Admin routes
Route::middleware(['auth','admin'])->group(function(){
    //Dashboard
    Route::get('/admin/dashboard',[AdminController::class,'index'])->name('admin.dashboard');
    //Topup
    Route::get('/admin/topup_index',[TopupController::class,'index'])->name('admin.topup_index');
    Route::get('/admin/topup_show',[TopupController::class,'topup_show'])->name('admin.topup_show');
    //Trainer
    Route::get('/admin/trainer',[TrainerController::class,'index'])->name('admin.trainer_index');
    Route::get('/admin/trainer_create',[TrainerController::class,'create'])->name('admin.trainer_create');
    Route::post('/admin/trainer_store',[TrainerController::class,'store'])->name('admin.trainer_store');
    Route::get('/admin/trainer_show/{id}',[TrainerController::class,'show'])->name('admin.trainer_show');
    Route::post('/admin/trainer_update/{id}',[TrainerController::class,'update'])->name('admin.trainer_update');
    Route::delete('/admin/trainer_destroy/{id}',[TrainerController::class,'destroy'])->name('admin.trainer_destroy');
    //Report
    Route::get('/admin/report',[TrainerController::class,'index'])->name('admin.report_index');
});

// User routes
Route::middleware(['auth','user'])->group(function(){

});

require __DIR__.'/auth.php';
