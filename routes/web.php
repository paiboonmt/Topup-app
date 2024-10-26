<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CardController;
use App\Http\Controllers\Admin\TopupController;
use App\Http\Controllers\Admin\TrainerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Trainer\HomeController;
use App\Http\Controllers\Trainer\ScanController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('login');
});

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

    // AdminController
    Route::controller(AdminController::class)->group(function(){
        Route::get('/admin/dashboard','index')->name('admin.dashboard');
    });

    // TopupController
    Route::controller(TopupController::class)->group(function(){
        Route::get('/admin/topup_index','index')->name('admin.topup_index');
        Route::get('/admin/topup_show','topup_show')->name('admin.topup_show');
        Route::get('/admin/topup_edit/{id}','topup_edit')->name('admin.topup_edit');
        Route::post('admin/topup_check','check')->name('admin.topup_check');
        Route::post('admin/topup_store','store')->name('admin.topup_store');
    });

    // TrainerController
    Route::controller(TrainerController::class)->group(function(){
        Route::get('/admin/trainer','index')->name('admin.trainer_index');
        Route::get('/admin/trainer_create','create')->name('admin.trainer_create');
        Route::get('/admin/trainer_show/{id}','show')->name('admin.trainer_show');
        Route::post('/admin/trainer_store','store')->name('admin.trainer_store');
        Route::post('/admin/trainer_update/{id}','update')->name('admin.trainer_update');
        Route::delete('/admin/trainer_destroy/{id}','destroy')->name('admin.trainer_destroy');
    });

    // CardController
    Route::controller(CardController::class)->group(function () {
        Route::get('/admin/card', 'index')->name('admin.card_index');
        Route::post('/admin/card_create', 'create')->name('admin.card_create');
        Route::post('/admin/card_store', 'store')->name('admin.card_store');
        Route::get('/admin/card_show', 'show')->name('admin.card_show');
        Route::get('/admin/card_edit', 'edit')->name('admin.card_edit');
        Route::delete('/admin/card_destroy/{id}','destroy')->name('admin.card_destroy');
    });

    Route::controller(CardController::class)->group(function () {

    });

    //Report
    Route::get('/admin/report',[TrainerController::class,'index'])->name('admin.report_index');
});


Route::middleware(['auth','trainer'])->group(function(){
    Route::controller(HomeController::class)->group(function(){
        Route::get('/trainer/dashboard','index')->name('trainer.dashboard');
        Route::get('/trainer/qrscan','qrscan')->name('trainer.qrscan');
    });

    Route::controller(ScanController::class)->group(function(){
        Route::post('/trainer/qrcheck','check')->name('trainer.qrcheck');
    });
});

require __DIR__.'/auth.php';
