<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LoginUserController;
use App\Http\Controllers\PurchaseController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

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

Route::get('/', [ProductController::class, 'index']);
Route::post('/register', [RegisteredUserController::class, 'store'])->middleware(['guest'])->name('register');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
Route::get('/item/{item_id}', [ProductController::class, 'item'])->name('products.item');


Route::middleware('auth')->group(function() {
    Route::get('/mypage', [ProfileController::class, 'index'])->name('mypage');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/item/{item_id}/comments', [CommentController::class, 'store'])->name('comments.store');

    Route::get('/purchase/{item_id}', [PurchaseController::class, 'purchase'])->name('products.purchase');
    Route::get('/purchase/address/{item_id}', [ProfileController::class, 'address'])->name('address.edit');
    Route::post('/purchase/address/', [ProfileController::class, 'addressUpdate'])->name('address.update');

    Route::get('/sell', [ProductController::class, 'sell']);
    Route::post('/sell', [ProductController::class, 'store'])->name('products.store');

    Route::post('/products/{item_id}/like', [LikeController::class, 'toggle'])->name('products.like');
});