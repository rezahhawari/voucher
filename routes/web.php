<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\KosController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\VoucherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [PagesController::class, 'home'])->name('home');
Route::post('cusdetail/connect', [PagesController::class, 'storeemail'])->name('storeemail');
Route::get('cusdetail/{transaction}/connect', [PagesController::class, 'customerdetail'])->name('customerdetail');
Route::post('cusdetail/{transaction}/connect/payment', [TransactionController::class, 'payment'])->name('payment');
Route::get('getvoucher', [PagesController::class, 'getvoucher'])->name('getvoucher');
Route::get('sentemail', [PagesController::class, 'sentemail']);
Route::post('store/payment', [TransactionController::class, 'storepayment'])->name('store.payment');

Route::middleware('auth')->group(function(){

});

Route::middleware('auth', 'isadmin')->group(function(){
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('event', [AdminController::class, 'event'])->name('admin.event');

    Route::post('upload-temp-product', [AdminController::class, 'uptempimage']);
    Route::post('upload-excel', [AdminController::class, 'uptempexcel']);

    Route::post('event/store', [EventController::class, 'store'])->name('admin.event-store');
    Route::delete('event/destroy', [EventController::class, 'destroy'])->name('admin.event-destroy');

    Route::get('kos', [AdminController::class, 'kos'])->name('admin.kos');
    Route::post('kos/store', [KosController::class, 'store'])->name('admin.kos-store');

    Route::get('venue', [AdminController::class, 'venue'])->name('admin.venue');
    Route::post('venue/store', [VenueController::class, 'store'])->name('admin.venue-store');
    Route::post('venue/changestatus', [VenueController::class, 'changestatus'])->name('admin.venue-changestatus');

    Route::get('duration', [AdminController::class, 'duration'])->name('admin.duration');
    Route::post('duration/store', [PeriodController::class, 'store'])->name('admin.duration-store');
    Route::delete('duration/destroy', [PeriodController::class, 'destroy'])->name('admin.duration-destroy');

    Route::get('voucher', [AdminController::class, 'voucher'])->name('admin.voucher');
    Route::post('voucher/findduration', [VoucherController::class, 'findduration'])->name('admin.voucher-findduration');
    Route::post('voucher/store', [VoucherController::class, 'store'])->name('admin.voucher-store');
    Route::delete('voucher/destroy', [VoucherController::class, 'destroy'])->name('admin.voucher-destroy');
    Route::post('voucher/import', [VoucherController::class, 'importexcel'])->name('admin.voucher-importexcel');

    Route::get('transaction', [AdminController::class, 'transaction'])->name('admin.transaction');
});

require __DIR__.'/auth.php';
