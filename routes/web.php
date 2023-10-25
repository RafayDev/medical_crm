<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClientController;

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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/clients', [App\Http\Controllers\ClientController::class, 'index'])->name('clients');
Route::post('/add-client', [App\Http\Controllers\ClientController::class, 'create'])->name('add-client');
Route::get('/delete-client/{id}', [App\Http\Controllers\ClientController::class, 'delete'])->name('delete-client');
Route::post('/update-client/{id}', [App\Http\Controllers\ClientController::class, 'update'])->name('update-client');
Route::get('/catagories', [App\Http\Controllers\CatagoryController::class, 'index'])->name('catagories');
Route::post('/add-catagory', [App\Http\Controllers\CatagoryController::class, 'create'])->name('add-catagory');
Route::get('/delete-catagory/{id}', [App\Http\Controllers\CatagoryController::class, 'delete'])->name('delete-catagory');
Route::post('/edit-catagory/{id}', [App\Http\Controllers\CatagoryController::class, 'update'])->name('edit-catagory');
Route::get('/assigned-types/{id}', [App\Http\Controllers\CatagoryController::class, 'assigned_type'])->name('assigned-types');
Route::post('/assign-types', [App\Http\Controllers\CatagoryController::class, 'assign_type'])->name('assign-types');
Route::get('/category-types/{id}', [App\Http\Controllers\CatagoryController::class, 'category_types'])->name('category-types');
Route::get('/category-type-products/{category_id}/{type_id}', [App\Http\Controllers\CatagoryController::class, 'category_type_products'])->name('category-type-products');
Route::get('/types', [App\Http\Controllers\TypeController::class, 'index'])->name('types');
Route::post('/add-type', [App\Http\Controllers\TypeController::class, 'create'])->name('add-type');
Route::get('/delete-type/{id}', [App\Http\Controllers\TypeController::class, 'delete'])->name('delete-type');
Route::post('/edit-type/{id}', [App\Http\Controllers\TypeController::class, 'update'])->name('edit-type');
Route::get('/invoices', [App\Http\Controllers\InvoiceController::class, 'index'])->name('invoices');
Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products');
Route::post('/add-product', [App\Http\Controllers\ProductController::class, 'create'])->name('add-product');
Route::get('/delete-product/{id}', [App\Http\Controllers\ProductController::class, 'delete'])->name('delete-product');
Route::post('/edit-product/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('edit-product');
Route::get('/sub-types', [App\Http\Controllers\SubTypeController::class, 'index'])->name('sub-types');
Route::post('/add-sub-type', [App\Http\Controllers\SubTypeController::class, 'create'])->name('add-sub-type');
Route::get('/delete-sub-type/{id}', [App\Http\Controllers\SubTypeController::class, 'delete'])->name('delete-sub-type');
Route::post('/edit-sub-type/{id}', [App\Http\Controllers\SubTypeController::class, 'update'])->name('edit-sub-type');
Route::get('/get-sub-type-by-type/{id}', [App\Http\Controllers\SubTypeController::class, 'get_sub_type_by_type'])->name('get-sub-type-by-type');
Route::post('/add-to-cart', [App\Http\Controllers\CartController::class, 'add_to_cart'])->name('add-to-cart');
Route::get('/carts', [App\Http\Controllers\CartController::class, 'index'])->name('carts');
Route::get('/delete-cart/{id}', [App\Http\Controllers\CartController::class, 'delete'])->name('delete-cart');
Route::get('/send-query/{user_id}', [App\Http\Controllers\CartController::class, 'send_query'])->name('send-query');
Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'get_unread_notifications'])->name('notifications');
Route::get('/mark-as-read', [App\Http\Controllers\NotificationController::class, 'mark_as_read'])->name('mark-as-read');
Route::get('/queries', [App\Http\Controllers\QueryController::class, 'index'])->name('queries');
Route::get('/view-query/{id}', [App\Http\Controllers\QueryController::class, 'view'])->name('view-query');
Route::post('/approve-query', [App\Http\Controllers\QueryController::class, 'approve'])->name('approve-query');
Route::get('/get-query-products/{id}', [App\Http\Controllers\QueryController::class, 'get_query_products'])->name('get-query-products');
Route::get('/invoices',[App\Http\Controllers\InvoiceController::class, 'index'])->name('invoices');
Route::get('/view-invoice/{id}',[App\Http\Controllers\InvoiceController::class, 'view'])->name('view-invoice');
Route::get('/get-invoice-products/{id}', [App\Http\Controllers\InvoiceController::class, 'get_invoice_products'])->name('get-invoice-products');
Route::post('/update-invoice/{id}', [App\Http\Controllers\InvoiceController::class, 'update'])->name('update-invoice');
Route::get('/orders',[App\Http\Controllers\OrderController::class, 'index'])->name('orders');
Route::post('/create-order',[App\Http\Controllers\OrderController::class, 'create'])->name('create-order');
Route::post('/change-order-status',[App\Http\Controllers\OrderController::class, 'change_order_status'])->name('change-order-status');
//internals crud
Route::get('/internals',[App\Http\Controllers\InternalController::class, 'index'])->name('internals');
Route::post('/add-internal',[App\Http\Controllers\InternalController::class, 'create'])->name('add-internal');
Route::get('/delete-internal/{id}',[App\Http\Controllers\InternalController::class, 'delete'])->name('delete-internal');
Route::post('/update-internal/{id}',[App\Http\Controllers\InternalController::class, 'update'])->name('update-internal');
//get-type-by-category
Route::get('/get-type-by-category/{id}',[App\Http\Controllers\CatagoryController::class, 'get_type_by_category'])->name('get-type-by-category');
Route::get('delete-invoice/{id}',[App\Http\Controllers\InvoiceController::class, 'delete'])->name('delete-invoice');
Route::get('delete-query/{id}',[App\Http\Controllers\QueryController::class, 'delete'])->name('delete-query');
Route::match(['get', 'post'],'search-product',[App\Http\Controllers\ProductController::class, 'search'])->name('search-product');
Route::get('cart-count',[App\Http\Controllers\CartController::class, 'cart_count'])->name('cart-count');