<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CarouselController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DailyRevenuesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WerehouseProductController;
use App\Models\WerehouseProduct;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Route::get('/', function () {
//     return view('login');
// });

Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');

Route::post('/login', [UserController::class, 'login']);

Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/', [ProductController::class, 'landing'])->name('landing');
Route::get('/categories/{id}/products', [ProductController::class, 'getProducts'])->name('categories.products');
Route::get('/product/{id}', [ProductController::class, 'showDetail'])->name('product.show')->whereNumber('id');;

Route::middleware(['auth'])->group(function () {
    Route::get('home', [DashboardController::class, 'show']);

    Route::prefix('categori')->group(function () {
        Route::get('/', [CategoryController::class, 'show']);
        Route::get('create', [CategoryController::class, 'create']);
        Route::post('create', [CategoryController::class, 'store'])->name('categori.store');
        Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('categori.edit');
        Route::patch('{id}', [CategoryController::class, 'update'])->name('categori.update');
        Route::delete('{id}', [CategoryController::class, 'destroy'])->name('categori.delete');
    });

    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'show']);
        Route::get('create', [ProductController::class, 'create']);
        Route::post('create', [ProductController::class, 'store'])->name('product.store');
        Route::get('edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::patch('{id}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('{id}', [ProductController::class, 'destroy'])->name('product.delete');

        Route::get('{id}/update-harga', [ProductController::class, 'formUpdatePrice'])->name('price-form');
        Route::post('{id}/update-harga', [ProductController::class, 'updatePrice'])->name('update-price');
        Route::get('{id}/riwayat-harga', [ProductController::class, 'priceHistory'])->name('price-history');
    });

    Route::prefix('cashier')->group(function () {
        Route::get('/', [CashierController::class, 'show']);
        Route::get('create', [CashierController::class, 'create']);
        Route::post('create', [CashierController::class, 'store'])->name('cashier.store');
        Route::get('edit/{id}', [CashierController::class, 'edit'])->name('cashier.edit');
        Route::patch('{id}', [CashierController::class, 'update'])->name('cashier.update');
        Route::delete('{id}', [CashierController::class, 'destroy'])->name('cashier.delete');
    });

    Route::prefix('users')->group(function () {
        Route::get('', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::patch('/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    Route::prefix('units')->group(function () {
        Route::get('/', [UnitController::class, 'show']);
        Route::get('create', [UnitController::class, 'create']);
        Route::post('create', [UnitController::class, 'store'])->name('units.store');
        Route::get('edit/{id}', [UnitController::class, 'edit'])->name('units.edit');
        Route::patch('{id}', [UnitController::class, 'update'])->name('units.update');
        Route::delete('{id}', [UnitController::class, 'destroy'])->name('units.delete');
    });

    Route::prefix('stock')->group(function () {
        Route::get('create', [StockInController::class, 'create']);
        Route::post('create', [StockInController::class, 'store'])->name('stock_in.store');
    });

    Route::prefix('gudang')->group(function () {
        Route::get('', [WerehouseProductController::class, 'index']);
        Route::get('/create', [WerehouseProductController::class, 'create']);
        Route::post('', [WerehouseProductController::class, 'store'])->name('warehouse.store');
        Route::get('/{id}/edit', [WerehouseProductController::class, 'edit'])->name('warehouse.edit');
        Route::put('/{id}', [WerehouseProductController::class, 'update'])->name('warehouse.update');
        Route::delete('/{id}', [WerehouseProductController::class, 'destroy'])->name('warehouse.destroy');
        Route::get('/laporan', [WerehouseProductController::class, 'show'])->name('warehouse.show');
        // routes/web.php
        Route::get('{id}/pindah-toko', [WerehouseProductController::class, 'transfer'])->name('warehouse.transfer');
        Route::post('{id}/pindah-toko', [WerehouseProductController::class, 'transferStore'])->name('transfer.store');
        Route::get('/laporan/pdf', [WerehouseProductController::class, 'downloadPdf'])->name('warehouse.pdf');
        Route::get('/transfer/pdf', [WerehouseProductController::class, 'downloadTransferPdf'])->name('warehouse.transfer.pdf');
    });
    Route::get('laporan/pindah-toko', [WerehouseProductController::class, 'showTransfer']);

    Route::prefix('jabatan')->group(function () {
        Route::get('', [PositionController::class, 'index'])->name('position.index');
        Route::get('/create', [PositionController::class, 'create'])->name('position.create');
        Route::post('/store', [PositionController::class, 'store'])->name('position.store');
        Route::get('/{id}/edit', [PositionController::class, 'edit'])->name('position.edit');
        Route::patch('/{id}', [PositionController::class, 'update'])->name('position.update');
        Route::delete('/{id}', [PositionController::class, 'destroy'])->name('position.destroy');
    });

    Route::prefix('karyawan')->group(function () {
        Route::get('', [EmployeesController::class, 'index'])->name('employees.index');
        Route::get('/create', [EmployeesController::class, 'create'])->name('employees.create');
        Route::post('/store', [EmployeesController::class, 'store'])->name('employees.store');
        Route::get('/{id}/edit', [EmployeesController::class, 'edit'])->name('employees.edit');
        Route::patch('/{id}', [EmployeesController::class, 'update'])->name('employees.update');
        Route::delete('/{id}', [EmployeesController::class, 'destroy'])->name('employees.destroy');
    });


    Route::get('/product/{id}/barcode', [ProductController::class, 'barcode'])->name('product.barcode');

    Route::get('absensi', [AttendanceController::class, 'index'])->name('attend');
    Route::post('absensi/store', [AttendanceController::class, 'store'])->name('attend.store');
    Route::get('/absensi/rekap', [AttendanceController::class, 'rekap'])->name('attend.rekap');

    Route::get('gaji-karyawan', [PayrollController::class, 'show'])->name('payroll.show');
    Route::get('gaji-karyawan/create', [PayrollController::class, 'create'])->name('payrolls.create');
    Route::post('gaji-karyawan/store', [PayrollController::class, 'store'])->name('payrolls.store');
    Route::get('gaji-karyawan/rekap', [PayrollController::class, 'rekap'])->name('payrolls.rekap');
    Route::get('gaji-karyawan/tunjangan', [PayrollController::class, 'rekapTunjangan'])->name('payrolls.tunjangan');
    Route::get('gaji-karyawan/potongan', [PayrollController::class, 'rekapPotongan'])->name('payrolls.potongan');
    Route::get('/payrolls/check-code', [PayrollController::class, 'checkCode'])->name('payrolls.checkCode');

    Route::get('transaksi', [TransactionController::class, 'index'])->name('transaction');
    Route::get('transaksi/detail/{id}', [TransactionController::class, 'show'])->name('transaction.show');


    Route::get('/laporan/harian/{date?}', [ReportController::class, 'daily'])->name('laporan.harian');
    Route::get('/laporan/file/pdf', [ReportController::class, 'downloadDailyPdf'])->name('laporan.harian.pdf');

    Route::get('/laporan/bulanan/{year?}/{month?}', [ReportController::class, 'monthly'])->name('laporan.bulanan');
    Route::get('/laporan-bulanan/pdf/{year}/{month}', [ReportController::class, 'exportMonthlyPDF'])->name('laporan.bulanan.pdf');

    Route::get('/laporan/tahunan/{year?}', [ReportController::class, 'yearly'])->name('laporan.tahunan');
    Route::get('/laporan-tahunan/pdf/{year}', [ReportController::class, 'exportYearlyPDF'])->name('laporan.tahunan.pdf');

    Route::get('/laporan/pph/{year?}', [ReportController::class, 'pphReport'])->name('laporan.pph');
    Route::get('/laporan/pph/pdf/{year?}', [ReportController::class, 'pphReportPdf'])->name('laporan.pph.pdf');

    Route::get('perbandingan/bulanan/{year?}/{month?}', [ReportController::class, 'monthlyComparison'])->name('perbandingan.bulanan');
    Route::get('/laporan-perbandingan/pdf', [ReportController::class, 'exportMonthlyComparisonPDF'])->name('perbandingan.bulanan.pdf');

    Route::get('setting', [LandingController::class, 'show'])->name('setting.index');
    Route::get('setting/edit/{id}', [LandingController::class, 'edit'])->name('setting.edit');
    Route::patch('setting/{id}', [LandingController::class, 'update'])->name('setting.update');
    Route::get('landing/barcode', [LandingController::class, 'barcodeLanding']);


    Route::prefix('carousel')->group(function () {
        Route::get('', [CarouselController::class, 'index'])->name('carousel.index');
        Route::get('/create', [CarouselController::class, 'create'])->name('carousel.create');
        Route::post('/store', [CarouselController::class, 'store'])->name('carousel.store');
        Route::get('/{id}/edit', [CarouselController::class, 'edit'])->name('carousel.edit');
        Route::patch('/{id}', [CarouselController::class, 'update'])->name('carousel.update');
        Route::delete('/{id}', [CarouselController::class, 'destroy'])->name('carousel.delete');
    });

    Route::get('daily-revenues', [DailyRevenuesController::class, 'index'])->name('daily-revenues.index');
    Route::post('daily-revenues/store', [DailyRevenuesController::class, 'store'])->name('daily-revenues.store');
});