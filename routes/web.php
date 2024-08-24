<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\ApiUserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\AnalyticsController;
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

Auth::routes();
Route::get('/', [ProductController::class, 'catalog'])->name('products.catalog');
Route::get('/home', [ProductController::class, 'catalog'])->name('products.catalog');
Route::get('catalog', [ProductController::class, 'catalog'])->name('products.catalog');



Route::middleware('auth')->group(function () {
    Route::get('products/{product}/buy', [PurchaseController::class, 'show'])->name('purchases.create');
    Route::post('products/{product}/buy', [PurchaseController::class, 'store'])->name('purchases.store');
    Route::get('user/{userId}/purchases', [PurchaseController::class, 'userPurchases'])->name('user.purchases');
    Route::middleware('admin:Administradores')->group(function () {
        Route::resource('products', ProductController::class);
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::get('/users/cliente_top', [UserController::class, 'clienteTop'])->name('users.cliente_top');
        Route::resource('roles', RoleController::class);
        Route::get('/fetch-users', [ApiUserController::class, 'fetchUsers'])->name('fetchUsers.index');
        Route::get('purchases', [PurchaseController::class, 'index'])->name('purchases.index');
        Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
    });
});