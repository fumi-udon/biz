<?php

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
    Log::debug('Route::get _ Topページが呼ばれてるよー sessionからキー削除');
    Session::forget('auth_flg');
    return view('welcome');
});

Auth::routes();

use App\Http\Controllers\KicalcsController;
Route::get('/calcs', [KicalcsController::class, 'index']);

// コントローラを使う宣言 
use App\Http\Controllers\TaskOrderController;
Route::get('/matin8h', [TaskOrderController::class, 'matin8h']);
Route::post('/task8h', [TaskOrderController::class, 'task8h']);
Route::get('/soir15h', [TaskOrderController::class, 'soir15h']);
Route::post('/task15h', [TaskOrderController::class, 'task15h']);
Route::get('/bn_register_top', [TaskOrderController::class, 'bn_register_top'])->name('bn.register.top');
Route::post('/bn_register_store/{id?}/{params?}', [TaskOrderController::class, 'bn_register_store'])->name('bn.register.store');

use App\Http\Controllers\AdminProductionController;
Route::get('/admin/{action_message?}', [AdminProductionController::class, 'index'])->name('admin.index');
// 財務ページ adminページのリンクより
Route::get('/finance/{btn?}/{page_id?}', [AdminProductionController::class, 'finance'])->name('admin.finance');
// Ajax welcome.blade.php 管理者ページ表示前検証
Route::post('/admin_validate',[AdminProductionController::class, 'admin_validate']);
Route::post('/update/{btn}/{page_id?}',[AdminProductionController::class, 'update'])->name('update');
Route::post('/store/{btn}/{page_id?}',[AdminProductionController::class, 'store'])->name('admin.store');
Route::post('/prendre_stock/{btn}/{page_id?}',[AdminProductionController::class, 'prendre_stock'])->name('admin.prendre.stock');

//ラドさん JSONデータ取得サンプル RadoSimpleController
use App\Http\Controllers\RadoSimpleController;
Route::get('/rado', [RadoSimpleController::class, 'index'])->name('rado.index');

//食材消費量 ConsumedFoodQuantityController
use App\Http\Controllers\ConsumedFoodQuantityController;
Route::get('/conso', [ConsumedFoodQuantityController::class, 'index'])->name('conso.index');

