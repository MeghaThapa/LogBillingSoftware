<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;

use App\Http\Controllers\PurchaseItemController;



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
    return view('welcome');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth','middleware'=>'admin'], function () {

Route::get('/userList', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
Route::get('/userList/add', [App\Http\Controllers\UserController::class, 'add'])->name('user.create');
Route::post('/userList/store', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
Route::get('/userList/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
Route::post('/userList/update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
Route::post('/userList/editPW', [App\Http\Controllers\UserController::class, 'editPW'])->name('user.editPW');
Route::delete('/userList/delete/{id}', [App\Http\Controllers\UserController::class, 'delete'])->name('user.delete');

});
Route::get('/customer/indexAjax', [App\Http\Controllers\CustomerController::class, 'indexAjax'])->name('customer.indexAjax')->middleware('auth');
Route::get('/customer/modelData/{id}', [App\Http\Controllers\CustomerController::class, 'modelData'])->name('customer.modelData')->middleware('auth');
Route::get('/customer/trash', [App\Http\Controllers\CustomerController::class, 'trash'])->name('customer.trash')->middleware('auth');
Route::get('/customer/trashData', [App\Http\Controllers\CustomerController::class, 'trashData'])->name('customer.trashData')->middleware('auth');
Route::post('/customer/trashRecovery/{id}', [App\Http\Controllers\CustomerController::class, 'trashRecovery'])->name('customer.trashRecovery')->middleware('auth');
Route::get('/customer/trashData', [App\Http\Controllers\CustomerController::class, 'trashData'])->name('customer.trashData')->middleware('auth');
Route::delete('/customer/trashDelete/{id}', [App\Http\Controllers\CustomerController::class, 'trashDelete'])->name('customer.trashDelete')->middleware('auth');

Route::resource('customer', CustomerController::class);

Route::get('/supplier/indexAjax', [App\Http\Controllers\SupplierController::class, 'indexAjax'])->name('supplier.indexAjax')->middleware('auth');
Route::get('/supplier/modelData/{id}', [App\Http\Controllers\SupplierController::class, 'modelData'])->name('supplier.modelData')->middleware('auth');
Route::get('/supplier/trash', [App\Http\Controllers\SupplierController::class, 'trash'])->name('supplier.trash')->middleware('auth');
Route::get('/supplier/trashData', [App\Http\Controllers\SupplierController::class, 'trashData'])->name('supplier.trashData')->middleware('auth');

Route::post('/supplier/restoreSupplier/{id}', [App\Http\Controllers\SupplierController::class, 'restoreSupplier'])->name('supplier.restoreSupplier')->middleware('auth');
Route::delete('/supplier/trashDelete/{id}', [App\Http\Controllers\SupplierController::class, 'trashDelete'])->name('customer.trashDelete')->middleware('auth');
Route::resource('supplier', SupplierController::class);

Route::delete('/product/trashDelete/{id}', [App\Http\Controllers\ProductController::class, 'trashDelete'])->name('customer.trashDelete')->middleware('auth');
Route::post('/product/restoreProduct/{id}', [App\Http\Controllers\ProductController::class, 'restoreProduct'])->name('product.restoreProduct')->middleware('auth');
Route::get('/product/trash', [App\Http\Controllers\ProductController::class, 'trash'])->name('product.trash')->middleware('auth');
Route::get('/product/trashData', [App\Http\Controllers\ProductController::class, 'trashData'])->name('product.trashData')->middleware('auth');
Route::get('/product/viewData/{id}', [App\Http\Controllers\ProductController::class, 'viewData'])->name('product.viewData')->middleware('auth');
Route::post('/product/productUpdate', [App\Http\Controllers\ProductController::class, 'productUpdate'])->name('product.productUpdate')->middleware('auth');
Route::get('/product/productValueE/{id}', [App\Http\Controllers\ProductController::class, 'productValueE'])->name('product.productValueE')->middleware('auth');
Route::get('/product/indexAjax', [App\Http\Controllers\ProductController::class, 'indexAjax'])->name('product.indexAjax')->middleware('auth');
Route::resource('product', ProductController::class);

Route::get('/purchase/trash', [PurchaseController::class, 'trash'])->name('purchase.trash')->middleware('auth');
Route::get('/purchase/ajaxTableData', [PurchaseController::class, 'ajaxTableData'])->name('purchase.ajaxTableData')->middleware('auth');
Route::get('/purchase/trashTableData', [PurchaseController::class, 'trashTableData'])->name('purchase.trashTableData')->middleware('auth');
Route::get('/purchase/modelData/{id}', [PurchaseController::class,'modelData'])->name('purchase.modelData')->middleware('auth');
Route::delete('/purchase/purchaseTrashDelete/{id}', [PurchaseController::class, 'purchaseTrashDelete'])->name('purchase.purchaseTrashDelete')->middleware('auth');
Route::post('/purchase/restorePurchase/{id}', [PurchaseController::class, 'restorePurchase'])->name('product.restorePurchase')->middleware('auth');
Route::resource('purchase', PurchaseController::class);


Route::get('/purchaseItem/index/{id}', [PurchaseItemController::class, 'index'])->name('purchaseItem.index')->middleware('auth');
Route::post('/purchaseItem/saveData/{id}', [PurchaseItemController::class, 'saveData'])->name('purchaseItem.saveData')->middleware('auth');
Route::delete('/purchaseItem/delete/{id}', [PurchaseItemController::class, 'delete'])->name('purchase_item.delete')->middleware('auth');
Route::get('/purchaseItem/editData/{id}', [PurchaseItemController::class, 'editData'])->name('purchaseItem.editData')->middleware('auth');
Route::post('/purchaseItem/productItemUpdate/{id}', [PurchaseItemController::class, 'productItemUpdate'])->name('purchaseItem.productItemUpdate')->middleware('auth');
Route::post('/purchaseItem/updateSave', [PurchaseItemController::class, 'updateSave'])->name('purchaseItem.updateSave')->middleware('auth');
Route::post('/purchase/save/{id}', [purchaseController::class, 'save'])->name('purchase.save')->middleware('auth');
Route::get('/purchaseItem/purchaseBill/{id}', [PurchaseItemController::class, 'purchaseBill'])->name('purchaseItem.purchaseBill')->middleware('auth');

Route::get('/stock/stockData', [StockController::class, 'stockData'])->name('stock.stockData')->middleware('auth');

Route::resource('stock', StockController::class);




