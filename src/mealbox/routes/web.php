<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Food\FoodController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Order\OrderController;

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
// ログイン未ユーザーの行動制限ミドルウェア
Route::middleware(['guest'])->group(function () {
    // ログイン画面表示
    Route::get('/', [AuthController::class, 'showLogin'])->name('login.show');
    // ログイン処理
    Route::post('login', [AuthController::class, 'login'])->name('login');
    // ユーザー新規登録画面表示
    Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup.show');
    // ユーザー新規登録処理
    Route::post('user/store', [AuthController::class, 'signup'])->name('signup');
});

// ログイン済ユーザーの行動制限ミドルウェア
Route::middleware(['auth'])->group(function () {
    // ホーム画面表示(商品一覧画面)
    Route::get('home', [FoodController::class, 'foodList'])->name('home');
    // 詳細画面表示(商品詳細)
    Route::get('/food/{id}', [FoodController::class, 'foodDetail'])->name('food.detail');
    // 詳細画面表示(ログインユーザー情報詳細)
    Route::get('/user/{id}', [AuthController::class, 'userDetail'])->name('userDetail');
    // ログアウト処理
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    // 商品購入処理
    Route::post('/purchase', [OrderController::class, 'purchase'])->name('order.purchase');
});  

// ログイン済み管理者ユーザーの行動制限ミドルウェア
Route::group(['middleware' => ['auth.admin']], function () {
    // food登録フォーム画面表示
    Route::get('/admin/food_form', [FoodController::class, 'showUploadForm'])->name('food.form');
    // food登録処理
    Route::post('/admin/upload', [FoodController::class, 'upload'])->name('food.upload');
    // food編集フォーム表示
    Route::get('/admin/food_edit/{id}', [FoodController::class, 'foodEdit'])->name('food.edit');
    // food更新処理
    Route::post('/admin/food_update', [FoodController::class, 'foodUpdate'])->name('food.update');
    // 商品管理一覧
    Route::get('/admin/food_list', [AdminController::class, 'adminFoodList'])->name('admin.food_list');
    // 注文管理一覧
    Route::get('/admin/order_list', [AdminController::class, 'adminOrderList'])->name('admin.order_list');
    // order削除処理
    Route::post('/admin/order_delete/{id}', [AdminController::class, 'adminOrderDelete'])->name('admin.order_delete');
    // food削除処理
    Route::post('/admin/food_delete/{id}', [AdminController::class, 'exeDelete'])->name('admin.food_delete');
    // 管理者側トップ
    Route::get('/admin', [AdminController::class, 'show'])->name('admin.top');
    // ログアウト実行
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
    // ユーザー一覧
    Route::get('/admin/user_list', [AdminController::class, 'showUserList'])->name('admin.user_list');
    // ユーザー詳細
    Route::get('/admin/user_detail/{id}', [AdminController::class, 'showDetail'])->name('admin.user_detail');
});

// ログイン未管理者ユーザーの行動制限ミドルウェア
Route::group(['middleware' => ['auth.check']], function () {
    // 管理者側ログインページ表示 
    Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.showLogin');
    // 管理者側ログイン処理
    Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login');
});