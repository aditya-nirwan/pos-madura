<?php

use App\Http\Controllers\CashierController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('cashiers', [CashierController::class, 'get_all']);
Route::get('categories', [CategoryController::class, 'get_all']);
Route::get('products', [ProductController::class, 'get_all']);

Route::get('transaksi/today', [TransactionController::class, 'today']);
Route::post('transaksi/upload', [TransactionController::class, 'upload']);

Route::post('transaksi/endclose', [TransactionController::class, 'endClosing']);

Route::post('transactions/sync', [TransactionController::class, 'syncSingle']);

Route::get('closing/today-summary', [TransactionController::class, 'getTodaySummary']);
Route::get('closing/today-sold-items', [TransactionController::class, 'getTodaySoldItems']);
Route::post('closing/end', [TransactionController::class, 'endClosing']);