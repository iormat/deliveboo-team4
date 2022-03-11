<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

// Auth::routes();

// user login - register - logout
Route::prefix('/') -> group(function() {
    Route::get('', 'GuestController@home')->name('home');
    Route::get('login', 'GuestController@loginRegister')->name('login-register');
    Route::post('login', 'Auth\LoginController@login') -> name('login');
    Route::post('register', 'Auth\RegisterController@register') -> name('register');
    Route::get('logout', 'Auth\LoginController@logout') -> name('logout');
});

// return dashboard page
Route::get('/dashboard', function(){
    return view('pages.dashboard');
});


// api routes
Route::prefix('/api') -> group(function() { 
    // logged users 
    Route::get('/dishes', 'ApiController@getMenu') -> name('api.dishes');
    Route::get('/categories', 'ApiController@getCategories') -> name('api.categories');
    Route::post('/store', 'ApiController@addDish');
    Route::post('/edit', 'ApiController@edit');
    Route::post('/updateDish/{id}', 'ApiController@updateDish') -> name('update');
    Route::get('/dishDelete/{id}', 'ApiController@deleteDish') -> name('delate');
    Route::get('/get/restaurant/menu/{id}', 'ApiController@getRestaurantMenu') -> name('menu');
    // guests
    Route::get('/cart/checkout', 'ApiController@checkout') -> name('api.cart.checkout');
    Route::get('/restaurants/types', 'ApiController@getTypes');
    Route::post('/user/chosen/restaurants', 'ApiController@chosenRestaurants');
    Route::get('/fav/restaurants', 'ApiController@favRestaurants');
});

// orders routes
Route::prefix('/orders') -> group(function() {
    Route::get('/generate', 'OrderController@generate');
    Route::post('/customerInfo', 'OrderController@customerInfo');
    Route::post('/createOrder', 'OrderController@createOrder');
    Route::post('/make/payment', 'OrderController@makePayment');
    Route::get('', 'OrderController@index')-> name('orders');
    Route::get('/list', 'OrderController@list');
    Route::post('/confirm', 'OrderController@confirm');
});


Route::get('/all/dishes', 'DishController@index');

Route::get('/restaurant/details/{id}', 'GuestController@getRestaurant') -> name('restaurant');

// charts routes
Route::prefix('/chart') -> group(function() { 
    Route::get('/orders', 'ChartController@getOrdersMonth');
    Route::get('/orders/year', 'ChartController@getOrdersYear');
    Route::get('/statistics', 'ChartController@statistics') ->name('statistics');
});


