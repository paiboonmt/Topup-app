<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\admin\BillController;
use App\Http\Controllers\Admin\CardController;
use App\Http\Controllers\admin\CartController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\FighterController;
use App\Http\Controllers\admin\PaymentController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\TopupController;
use App\Http\Controllers\Admin\TrainerController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\Md\MdController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Trainer\HomeController;
use App\Http\Controllers\Trainer\ScanController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;

// Route::get('/login', function () {
//     return view('login');
// });

Route::get('/', function () {
    return view('login');
});

Route::get('/login', function () {
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

    // DiscountController
    Route::controller(DiscountController::class)->group(function(){
        Route::get('/admin/discount','index')->name('admin.discount_index');
        Route::post('/admin/discount','store')->name('admin.discount_create');
        Route::post('/admin/discount_update','update')->name('admin.discount_update');
        Route::delete('/admin/discount/{id}','delete')->name('admin.discount_delete');
    });

    // ProductController
    Route::controller(ProductController::class)->group(function(){
        Route::get('/admin/product','index')->name('admin.product_index');
        Route::post('/admin/product','store')->name('admin.product_create');
        Route::post('/admin/product_update','update')->name('admin.product_update');
        Route::delete('admin/product/{id}','delete')->name('admin.product_delete');
    });

    // payment
    Route::controller(PaymentController::class)->group(function() {
        Route::get('/admin/payment','index')->name('admin.payment');
        Route::post('/admin/payment_create','create')->name('admin.payment_create');
        Route::post('/admin/payment_update','update')->name('admin.payment_update');
        Route::delete('/admin/paymeny_destroy/{id}','destroy')->name('admin.payment_destroy');
    });

    //CartController
    Route::controller(CartController::class)->group(function(){
        Route::get('/admin/cart','index')->name('admin.cart_index');
        Route::post('/admin/additem','addItem')->name('admin.addItem');
        Route::get('/admin/removeitem/{id}','removeItem')->name('admin.removeItem');
        Route::get('/admin/cancelcart','cancelCart')->name('admin.cancelCart');
        Route::post('/admin/checkout','checkOut')->name('admin.checkOut');
        Route::get('/admin/print','print')->name('admin.print');
    });

    // AdminController
    Route::controller(AdminController::class)->group(function(){
        Route::get('/admin/dashboard','index')->name('admin.dashboard');
    });

    // Edit Bill
    Route::controller(BillController::class)->group(function(){
        Route::get('/admin/edit_bill/{code}','index')->name('admin.edit_bill');
        Route::get('/admin/remove_item_bill/{code}/{id}','remove_item_bill')->name('admin.remove_item_bill');
        Route::get('/admin/remove_vat/{code}/{id}', 'removeVat')->name('admin.remove_vat');
        Route::post('/admin/update_bill/{code}','update')->name('admin.update_bill');
        Route::post('/admin/addItem','addItem')->name('admin.bill_additem');
        Route::get('/admin/remove_discount/{code}','remove_discount')->name('admin.remove_discount');
    });

    // CustomerController
    Route::controller(CustomerController::class)->group(function(){
        Route::get('/admin/customer','index')->name('admin.customers');
        Route::get('/admin/customer_create','create')->name('admin.customer_create');
        Route::get('/admin/customer_expired','expired')->name('admin.customer_expired');
    });

    // FighterController
    Route::controller(FighterController::class)->group(function(){
        Route::get('/admin/fighters','index')->name('admin.fighters');
        Route::get('/admin/fighter_profile','show')->name('admin.fighter_profile');
    });

    // TopupController
    Route::controller(TopupController::class)->group(function(){
        Route::get('/admin/topup_index','index')->name('admin.topup_index');
        Route::get('/admin/topup_show/{id}','show')->name('admin.topup_show');


        // Route::get('/admin/topup_show','topup_show')->name('admin.topup_show');
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

    // ReportController
    Route::controller(ReportController::class)->group(function(){
        Route::get('/admin/report_ticket','ticket')->name('admin.report_ticket');
        Route::get('/admin/report_reprint/{code}','rePrintTicket')->name('admin.reprint_ticket');
        Route::get('/admin/report_delete/{code}','reportDelete')->name('admin.reportDelete');
    });
    
});

// Trainer route
Route::middleware(['auth','trainer'])->group(function() {

    Route::controller(HomeController::class)->group(function(){
        Route::get('/trainer/dashboard','index')->name('trainer.dashboard');
        Route::get('/trainer/qrscan','qrscan')->name('trainer.qrscan');
    });

    Route::controller(ScanController::class)->group(function(){
        Route::post('/trainer/qrcheck','check')->name('trainer.qrcheck');

        // remove session
        Route::get('trainer/remove_session','removeSession')->name('trainer.remove_session');
    });

});

// Md route
Route::middleware(['auth','md'])->group(function(){
    Route::controller(MdController::class)->group(function(){
        Route::get('/md/dashboard','index')->name('md.dashboard');
        Route::get('/md/report_daily','report_daily')->name('md.report_daily');
        Route::get('/md/report_ticket','report_ticket')->name('md.report_ticket');
        Route::get('/md/report_summary','report_summary')->name('md.report_summary');
        Route::get('/md/report_checkin','report_checkin')->name('md.report_checkin');
    });
});

require __DIR__.'/auth.php';
