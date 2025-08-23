<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MypageController;

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

Route::get('/', [ItemController::class, 'index']);

Route::get('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/mypage/profile', [MypageController::class, 'edit']);
Route::post('/edit', [MypageController::class, 'edited']);
Route::get('/item/:{item_id}', [ItemController::class, 'detail'])->name('item.detail');
Route::get('/sell', [ItemController::class, 'register']);
Route::post('/sell', [ItemController::class, 'registered']);
Route::get('/mypage', [MypageController::class, 'index']);

Route::post('/item/like', [ItemController::class, 'like']);
Route::post('/item/comment', [ItemController::class, 'comment']);
