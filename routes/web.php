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
Route::post('/reg_amounts', [KicalcsController::class, 'reg_amounts']);
use App\Http\Controllers\TestDevController;
// 開発テスト
Route::get('/stock_email', [TestDevController::class, 'stock_email']);
// Gestion 
Route::get('/stock_close_input', [TestDevController::class, 'stock_close_input'])->name('stock.close.input');
Route::post('/stock_close_store/{id?}/{params?}', [TestDevController::class, 'stock_close_store'])->name('stock.close.store');
// 朝の買物リストとプレパレリスト  addnote_preparer
Route::get('/courses_matin', [TestDevController::class, 'courses_matin'])->name('courses.matin');
Route::get('/preparer_matin', [TestDevController::class, 'preparer_matin'])->name('preparer.matin');
Route::post('/addnote_courses', [TestDevController::class, 'addnote_courses'])->name('addnote.courses');
Route::post('/preparer_list', [TestDevController::class, 'preparer_list'])->name('preparer.list');
Route::post('/addnote_preparer', [TestDevController::class, 'addnote_preparer'])->name('addnote.preparer');
// ディナーのプレパレ 15時 Aicha and Andrea用
Route::get('/preparer_diner', [TestDevController::class, 'preparer_diner'])->name('preparer.diner');
Route::get('/addnote_diner_page', [TestDevController::class, 'addnote_diner_page'])->name('addnote.diner.page');
// ディナーのプレパレ 15時 Aicha and Andrea用 サト指示登録 addnote_diner_page
Route::post('/addnote_diner', [TestDevController::class, 'addnote_diner'])->name('addnote.diner');

// コントローラを使う宣言 
use App\Http\Controllers\TaskOrderController;
Route::get('/matin8h', [TaskOrderController::class, 'matin8h']);
Route::post('/task8h', [TaskOrderController::class, 'task8h']);
Route::get('/soir15h', [TaskOrderController::class, 'soir15h']);
Route::post('/task15h', [TaskOrderController::class, 'task15h']);
Route::get('/bn_register_top', [TaskOrderController::class, 'bn_register_top'])->name('bn.register.top');
Route::post('/bn_register_store/{id?}/{params?}', [TaskOrderController::class, 'bn_register_store'])->name('bn.register.store');
Route::get('/aicha_works_top', [TaskOrderController::class, 'aicha_works_top']);

// Alice 用のこと付け
Route::post('/add_note8h', [TaskOrderController::class, 'add_note8h'])->name('add.note8h');

use App\Http\Controllers\AdminProductionController;
// debug nav サンプルテスト
Route::get('/index_simple/{action_message?}', [AdminProductionController::class, 'index_simple'])->name('index.simple');

Route::get('/admin/{action_message?}', [AdminProductionController::class, 'index'])->name('admin.index');
// 財務ページ adminページのリンクより
Route::get('/index_finance/{btn?}/{page_id?}', [AdminProductionController::class, 'index_finance'])->name('admin.index.finance');
Route::post('/finance/{btn?}/{page_id?}', [AdminProductionController::class, 'finance'])->name('admin.finance');
// Ajax welcome.blade.php 管理者ページ表示前検証
Route::post('/admin_validate',[AdminProductionController::class, 'admin_validate']);
Route::post('/update/{btn}/{page_id?}',[AdminProductionController::class, 'update'])->name('update');
Route::post('/store/{btn}/{page_id?}',[AdminProductionController::class, 'store'])->name('admin.store');
Route::post('/prendre_stock/{btn}/{page_id?}',[AdminProductionController::class, 'prendre_stock'])->name('admin.prendre.stock');

//ラドさん JSONデータ取得サンプル RadoSimpleController
use App\Http\Controllers\RadoSimpleController;
Route::get('/rado', [RadoSimpleController::class, 'index'])->name('rado.index');
//注文商品データ取得
use App\Http\Controllers\SalesDataByProductController;
Route::get('/salesproductcreate', [SalesDataByProductController::class, 'create'])->name('salesproduct.create');

//食材消費量 AdminConcumedController 
use App\Http\Controllers\AdminConcumedController;
Route::get('/conso', [AdminConcumedController::class, 'index'])->name('conso.index');
Route::post('/search', [AdminConcumedController::class, 'search'])->name('conso.search');

//事務所食材 BureauItemsController   
use App\Http\Controllers\BureauItemsController;
Route::get('/bureau_index', [BureauItemsController::class, 'index'])->name('bureau.index');
Route::get('/bureau_stock_top', [BureauItemsController::class, 'bureau_stock_top'])->name('bureau.stock.top');
Route::post('/bureau_stock_store', [BureauItemsController::class, 'bureau_stock_store'])->name('bureau.stock.store');

use App\Http\Controllers\EmporterRecentController;
Route::get('/emporter_index', [EmporterRecentController::class, 'index'])->name('emporter.index');
Route::post('/emporter_search/{type?}/{shop?}', [EmporterRecentController::class, 'search'])->name('search.index');
//Route::post('/all_search/{btn_id?}/{params?}', [EmporterRecentController::class, 'all_search'])->name('allsearch.index');

//レシピ集 / マニュアル 
use App\Http\Controllers\RecettesController;
Route::get('/recettes_index', [RecettesController::class, 'recettes_index'])->name('recettes.index');
Route::get('/riz_jp', [RecettesController::class, 'riz_jp'])->name('recettes.rizjp');

//check list
use App\Http\Controllers\CheckListController;
Route::get('/close_top', [CheckListController::class, 'close_top'])->name('close.top');
Route::post('/close_step1', [CheckListController::class, 'close_step1'])->name('close.step1');
Route::post('/close_step2', [CheckListController::class, 'close_step2'])->name('close.step2');
Route::post('/close_step3', [CheckListController::class, 'close_step3'])->name('close.step3');
Route::post('/close_garantie', [CheckListController::class, 'close_garantie'])->name('close.garantie');

//開発遊び用d
use App\Http\Controllers\DevController;
Route::get('/dev_home', [DevController::class, 'index'])->name('dev.index');
Route::get('/importCSV', [DevController::class, 'importCSV'])->name('dev.import.csv');
Route::post('/importCSV2', [DevController::class, 'importCSV2'])->name('dev.import.csv2');
Route::get('/importCSV3', [DevController::class, 'importCSV3'])->name('dev.import.csv3');
Route::get('/shift_google', [DevController::class, 'shift_google'])->name('shift.google');

// [共通] 上書き追加ページ
Route::post('/common_addnote_complete', [DevController::class, 'common_addnote_complete'])->name('common.addnote.complete');
Route::get('/common_addnote/{flg_oride}/{flg_add}/{actionMessage}', [DevController::class, 'common_addnote'])->name('common.addnote');


// ディナープレパレ Cuisine  [子クラス]  
use App\Http\Controllers\TaskOrderDinerController;
Route::get('/cuisine_diner_top', [TaskOrderDinerController::class, 'cuisine_diner_top'])->name('cuisine.diner.top');
Route::post('/cuisine_diner_task', [TaskOrderDinerController::class, 'cuisine_diner_task'])->name('cuisine.diner.task');