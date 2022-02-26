<?php

use Illuminate\Support\Facades\Route;

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


// Auth::routes();

Route::get('/', 'GuestController@home')->name('home');
Route::get('/login', 'GuestController@loginRegister')->name('login-register');

Route::post('/login', 'Auth\LoginController@login') -> name('login');
Route::post('/register', 'Auth\RegisterController@register') -> name('register');
Route::get('/logout', 'Auth\LoginController@logout') -> name('logout');

Route::get('/dashboard', function(){
    return view('pages.dashboard');
});

Route::get('/api/dishes', 'ApiController@getMenu') -> name('api.dishes');

Route::post('/create', 'HomeController@store')->name('store');

Route::get('/api/categories', 'ApiController@getCategories') -> name('api.categories');


// Route::prefix('/api') -> group(function() {
   
// })