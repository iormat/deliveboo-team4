<?php
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
    Route::get('/dishes', 'ApiController@getMenu') -> name('api.dishes');
    Route::get('/categories', 'ApiController@getCategories') -> name('api.categories');
    Route::post('/store', 'ApiController@addDish');
    Route::post('/edit', 'ApiController@edit');
    Route::post('/updateDish/{id}', 'ApiController@updateDish') -> name('update');
});

