<?php

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
//     return view('welcome');
// });

Route::get('/view/items', [App\Http\Controllers\HomeController::class, 'items']);

Auth::routes();

// ログインページへのアクセス制御
Route::get('/login', function () {
    // URLを直接知っている場合のみログインページを表示
    if (request()->has('corporate')) {
        return view('auth.login');
    }
    // URLを知らないお客さんは商品一覧ページにリダイレクト
    return redirect('/view/items');
})->name('login');

Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');


Route::middleware('auth')->get('/', [App\Http\Controllers\ItemController::class, 'homeIndex']);

Route::prefix('items')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\ItemController::class, 'index'])->name('items');
    Route::get('/search', [App\Http\Controllers\ItemController::class, 'search']);
    Route::get('/add', [App\Http\Controllers\ItemController::class, 'addView']);
    Route::post('/add', [App\Http\Controllers\ItemController::class, 'add']);
    Route::get('/{item}', [App\Http\Controllers\ItemController::class, 'editView']);//ここ/{変数（item）}って書いてるから、/items/○○が全部ここに飛んでしまう。変数の前に/editとか、書かないといかん。この書き方良くない！
    Route::post('/{item}', [App\Http\Controllers\ItemController::class, 'edit']);  
    Route::post('/delete/{item}', [App\Http\Controllers\ItemController::class, 'destroy']);
    Route::post('/some/delete', [App\Http\Controllers\ItemController::class, 'destroy']);
});

Route::prefix('users')->middleware('auth')->group(function(){
    Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('users');
    Route::get('/edit/{user}', [App\Http\Controllers\UserController::class, 'edit']);
    Route::post('/edit/{user}', [App\Http\Controllers\UserController::class, 'edit']);
    Route::post('/someEdit/view', [App\Http\Controllers\UserController::class, 'someEdit']);
    Route::post('/someEdit', [App\Http\Controllers\UserController::class, 'someEditSave']);
    Route::post('/delete/{user}', [App\Http\Controllers\UserController::class, 'delete']);
});
