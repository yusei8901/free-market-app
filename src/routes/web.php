<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;
use App\Models\Purchase;
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

Route::get('/', [ItemController::class, 'index'])->name('index');
Route::post('/register', [RegisteredUserController::class, 'store'])->middleware(['guest'])->name('register');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
Route::get('/item/{item_id}', [ItemController::class, 'item'])->name('items.item');
Route::get('/search', [ItemController::class, 'search'])->name('items.search');

Route::middleware('auth')->group(function() {
    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/user', [EmailVerificationController::class, 'confirm'])->name('verification.confirm');
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->middleware('signed')->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])->middleware('throttle:6,1')->name('verification.send');
});

Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/mypage', [ProfileController::class, 'index'])->name('mypage');
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/item/{item_id}/like', [LikeController::class, 'toggle'])->name('items.like');
    Route::post('/item/{item_id}/comments', [CommentController::class, 'store'])->name('comments.store');

    Route::get('/sell', [ItemController::class, 'sell']);
    Route::post('/sell', [ItemController::class, 'store'])->name('items.store');

    Route::get('/purchase/success', [PurchaseController::class, 'success'])->name('purchase.success');
    Route::get('/purchase/cancel', [PurchaseController::class, 'cancel'])->name('purchase.cancel');

    Route::get('/purchase/address/{item_id}', [ProfileController::class, 'address'])->name('address.edit');
    Route::post('/purchase/address/{item_id}', [ProfileController::class, 'addressUpdate'])->name('address.update');
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'index'])->name('items.index');
    Route::post('/purchase/{item_id}', [PurchaseController::class, 'purchase'])->name('items.purchase');

    Route::post('/purchase/{item_id}', [PurchaseController::class, 'store'])->name('purchase.store');
});