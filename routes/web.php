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
// product routes
Route::get('/', 'FrontEndController@index')->name('product.index');
Route::get('product/{product}',
'FrontEndController@singleProduct')->name('product.single');

// cart routes
Route::prefix('cart/') -> group(function(){

    Route::post('add', 'ShoppingController@add_to_cart')->name('cart.add');
    Route::get('', 'ShoppingController@cart')->name('cart');
    Route::get('delete/{id}',
    'ShoppingController@cart_delete')->name('cart.delete');

    Route::get('increase/{pdt}/{qty}',
    'ShoppingController@increase')->name('cart.increase');

    Route::get('decrease/{pdt}/{qty}',
    'ShoppingController@decrease')->name('cart.decrease');

    Route::get('quick/add/{pdt}',
    'ShoppingController@quick_add')->name('cart.quick.add');

    Route::post('checkout', 'CheckoutController@checkout')->name('cart.checkout');

});

Route::resource('products', 'ProductController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
