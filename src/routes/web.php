<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::prefix('products')->name('products.')->group(function () {

    // 一覧
    Route::get('/', [ProductController::class, 'index'])->name('index');

    // 検索
    Route::get('/search', [ProductController::class, 'search'])->name('search');

    // 登録
    Route::get('/register', [ProductController::class, 'create'])->name('create');
    Route::post('/register', [ProductController::class, 'store'])->name('store');

    // 詳細（編集画面）
    Route::get('/detail/{product}', [ProductController::class, 'detail'])->name('detail');

    // 更新
    Route::get('/{product}/update', [ProductController::class, 'edit'])->name('edit');
    Route::put('/{product}/update', [ProductController::class, 'update'])->name('update');

    // 削除
    Route::get('/{product}/delete', [ProductController::class, 'deleteConfirm'])->name('delete');
    Route::delete('/{product}/delete', [ProductController::class, 'destroy'])->name('destroy');
});