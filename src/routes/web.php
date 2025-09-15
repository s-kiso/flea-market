<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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

Route::get('/', [ItemController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/sell', [ItemController::class, 'register']);
    Route::post('/sell', [ItemController::class, 'registered']);
    Route::post('/item/like', [ItemController::class, 'like']);
    Route::post('/item/comment', [ItemController::class, 'comment']);
    Route::get('/purchase/:{item_id}', [PurchaseController::class, 'purchase'])->name('purchase.home');
    Route::post('/purchase/:{item_id}', [PurchaseController::class, 'purchased'])->name('purchase.submit');
    Route::get('/purchase/:{item_id}?type={type}', [PurchaseController::class, 'purchase'])->name('purchase.payment');
    Route::get('/purchase/address/:{item_id}', [PurchaseController::class, 'edit'])->name('address.modify');
    Route::post('/purchase/address/:{item_id}', [PurchaseController::class, 'edited'])->name('address.modified');
    Route::get('/mypage', [MypageController::class, 'index']);
    Route::get('/mypage/profile', [MypageController::class, 'edit']);
    Route::post('/edit', [MypageController::class, 'edited']);
    Route::get('/deal/:{item_id}', [PurchaseController::class, 'deal'])->name('item.deal');
    Route::post('/deal/:{item_id}', [PurchaseController::class, 'dealing'])->name('deal.submit');
});



Route::get('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/item/:{item_id}', [ItemController::class, 'detail'])->name('item.detail');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function(EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('mypage/profile');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');