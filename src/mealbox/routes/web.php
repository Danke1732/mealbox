<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

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
// ログイン未ユーザの行動制限ミドルウェア
Route::middleware(['guest'])->group(function () {
    // ログイン画面表示
    Route::get('/', [AuthController::class, 'showLogin'])->name('login.show');
    // ログイン処理
    Route::post('login', [AuthController::class, 'login'])->name('login');
});

// ログイン済ユーザの行動制限ミドルウェア
Route::middleware(['auth'])->group(function () {
    // ホーム画面表示
    Route::get('home', function() {
        return view('home');
    })->name('home');
    // ログアウト処理
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});  
