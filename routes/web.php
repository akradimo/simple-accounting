<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PersonCategoryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ShareholderController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CashboxController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\AccountingController;
use App\Http\Controllers\BulkController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ReceiveController; // اضافه کردن این خط
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;

// صفحه اصلی
Route::get('/', function () {
    return redirect()->route('home');
});

// مسیرهای احراز هویت
Auth::routes();

// مسیر ثبت نام به صورت دستی
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// داشبورد
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

// مسیرهای مربوط به مدیریت اشخاص
Route::prefix('persons')->name('persons.')->group(function () {
    Route::get('/', [PersonController::class, 'index'])->name('index');
    Route::get('/create', [PersonController::class, 'create'])->name('create');
    Route::post('/', [PersonController::class, 'store'])->name('store');
    Route::get('/{person}', [PersonController::class, 'show'])->name('show');
    Route::get('/{person}/edit', [PersonController::class, 'edit'])->name('edit');
    Route::put('/{person}', [PersonController::class, 'update'])->name('update');
    Route::delete('/{person}', [PersonController::class, 'destroy'])->name('destroy');
    Route::post('/import', [PersonController::class, 'import'])->name('import');
    Route::get('/export', [PersonController::class, 'export'])->name('export');
    Route::get('/current-info', [PersonController::class, 'getCurrentInfo'])->name('current-info');
    Route::post('/bulk-delete', [PersonController::class, 'bulkDelete'])->name('bulk-delete');
    Route::post('/bulk-status', [PersonController::class, 'bulkStatus'])->name('bulk-status');
});

// دسته‌بندی اشخاص
Route::prefix('person-categories')->name('person-categories.')->group(function () {
    Route::get('/', [PersonCategoryController::class, 'index'])->name('index');
    Route::get('/list', [PersonCategoryController::class, 'list'])->name('list');
    Route::post('/', [PersonCategoryController::class, 'store'])->name('store');
    Route::get('/{personCategory}', [PersonCategoryController::class, 'show'])->name('show');
    Route::put('/{personCategory}', [PersonCategoryController::class, 'update'])->name('update');
    Route::delete('/{personCategory}', [PersonCategoryController::class, 'destroy'])->name('destroy');
});

// حساب‌ها و عملیات مالی
Route::resource('accounts', AccountController::class);
Route::resource('banks', BankController::class);
Route::resource('cashboxes', CashboxController::class);
Route::resource('transfers', TransferController::class);
Route::resource('deposits', DepositController::class);
Route::resource('withdrawals', WithdrawalController::class);
Route::resource('payments', PaymentController::class);
Route::resource('expenses', ExpenseController::class);

// انبار و کالا
Route::resource('products', ProductController::class);
Route::resource('services', ServiceController::class);
Route::resource('purchases', PurchaseController::class);
Route::resource('sales', SaleController::class);

// حسابداری
Route::prefix('accounting')->name('accounting.')->group(function () {
    Route::get('/', [AccountingController::class, 'index'])->name('index');
    Route::get('/entries', [AccountingController::class, 'entries'])->name('entries');
    Route::get('/new-entry', [AccountingController::class, 'create'])->name('new-entry');
    Route::post('/store-entry', [AccountingController::class, 'store'])->name('store-entry');
    Route::get('/chart-accounts', [AccountingController::class, 'chartAccounts'])->name('chart-accounts');
    Route::get('/journal', [AccountingController::class, 'journal'])->name('journal');
    Route::get('/ledger', [AccountingController::class, 'ledger'])->name('ledger');
    Route::get('/balance-sheet', [AccountingController::class, 'balanceSheet'])->name('balance-sheet');
    Route::get('/income-statement', [AccountingController::class, 'incomeStatement'])->name('income-statement');
    Route::get('/trial-balance', [AccountingController::class, 'trialBalance'])->name('trial-balance');
});

// سایر
Route::resource('shareholders', ShareholderController::class);
Route::resource('vendors', VendorController::class);
Route::resource('transactions', TransactionController::class);

// عملیات چاپ
Route::get('purchases/{purchase}/print', [PurchaseController::class, 'print'])->name('purchases.print');
Route::get('sales/{sale}/print', [SaleController::class, 'print'])->name('sales.print');

// عملیات گروهی
Route::prefix('bulk')->name('bulk.')->group(function () {
    Route::post('delete', [BulkController::class, 'delete'])->name('delete');
    Route::post('status', [BulkController::class, 'status'])->name('status');
});

// تنظیمات
Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

// مسیر دریافت
Route::get('/receive', [ReceiveController::class, 'index'])->name('receive');