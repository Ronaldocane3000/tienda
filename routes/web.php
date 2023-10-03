<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\RatingController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\OrderController;

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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/',[FrontendController::class, 'index']);
Route::get('/category',[FrontendController::class, 'category']);
Route::get('/category/{slug}',[FrontendController::class, 'viewcategory']);
Route::get('/category/{cate_slug}/{prod_slug}',[FrontendController::class, 'productview']);

Auth::routes(['verify' => true]);

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('add-to-cart', [CartController::class,'addproduct']);
Route::post('delete-cart-item', [CartController::class,'deleteproduct']);
Route::post('update-cart', [CartController::class,'updatecart']);

Route::post('add-to-wishlist', [WishlistController::class,'add']);
Route::post('delete-wishlist-item', [WishlistController::class,'deleteitem']);
Route::get('load-cart-data', [CartController::class,'cartcount']);
Route::get('load-wishlist-count', [WishlistController::class,'wishlistcount']);

Route::get('product-list', [FrontendController::class,'productlistAjax']);
Route::post('searchproduct', [FrontendController::class,'searchProduct']);

Route::middleware(['auth'])->group(function () {
Route::get('cart', [CartController::class,'viewcart']);
Route::get('checkout', [CheckoutController::class,'index']);
Route::post('place-order', [CheckoutController::class,'placeorder']);
Route::get('my-orders', [UserController::class,'index']);
Route::get('view-order/{id}', [UserController::class,'view']);
Route::get('wishlist', [WishlistController::class,'index']);
Route::post('proceed-to-pay', [CheckoutController::class,'razorpaycheck']);
Route::post('add-rating', [RatingController::class,'add']);
Route::get('add-review/{product_slug}/userreview', [ReviewController::class,'add']);
Route::post('add-review', [ReviewController::class,'create']);
Route::get('edit-review/{product_slug}/userreview', [ReviewController::class,'edit']);
Route::put('update-review', [ReviewController::class,'update']);
Route::get('my-profile', [FrontendController::class,'indexProfile']);
Route::put('update-profile/{id}', [FrontendController::class,'updateProfile']);
Route::get('my-orders/search', [UserController::class,'search'])->name('orderC.search');

});

 Route::middleware(['auth','isAdmin'])->group(function () {
    Route::get('/dashboard','Admin\FrontendController@index');
    Route::get('my-profileA', 'Admin\FrontendController@indexProfileA');
    Route::put('update-profileA/{id}', 'Admin\FrontendController@updateProfileA');
    Route::get('categories','Admin\CategoryController@index')->name('category.index');
    Route::get('add-category','Admin\CategoryController@add');
    Route::post('insert-category','Admin\CategoryController@insert');
    Route::get('edit-category/{id}', [CategoryController::class,'edit']);
    Route::put('update-category/{id}', [CategoryController::class,'update']);
    Route::get('delete-category/{id}', [CategoryController::class,'destroy']);

    Route::get('products', [ProductController::class,'index'])->name('products.index');
    Route::get('add-product', [ProductController::class,'add']);
    Route::post('insert-product', [ProductController::class,'insert']);

    Route::get('edit-product/{id}', [ProductController::class,'edit']);
    Route::put('update-product/{id}', [ProductController::class,'update']);
    Route::get('delete-product/{id}', [ProductController::class,'destroy']);

    Route::get('users', [FrontendController::class,'users'])->name('user.index');
    Route::get('orders', [OrderController::class,'index'])->name('order.index');
    Route::get('admin/view-order/{id}', [OrderController::class,'view'])->name('admin.view-order');
    Route::put('update-order/{id}', [OrderController::class,'updateorder']);
    Route::get('order-history', [OrderController::class,'orderhistory']);

    Route::get('users', [DashboardController::class,'users'])->name('user.index');
    Route::get('view-user/{id}', [DashboardController::class,'viewuser']);


    Route::get('categories/search', 'Admin\CategoryController@search')->name('category.search');
    Route::get('products/search', 'Admin\ProductController@search')->name('product.search');
    Route::get('orders/search', 'OrderController@search')->name('order.search');
    Route::get('users/search', 'Admin\DashboardController@search')->name('user.search');



 });
