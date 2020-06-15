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
    return view('welcome');
});




Route::get('/auth/', 'UserController@auth')->name('auth');
Route::get('/logout', 'UserController@logout')->name('logout');
Route::post('/register-user', 'UserController@signup')->name('register-user');
Route::post('/login-user', 'UserController@login')->name('login-user');


Route::middleware(['auth'])->group(function(){

	Route::get('/dashboard', function(){
		return view('users.dashboard');
	})->name('user-dashboard');


	Route::prefix('user')->group(function(){
		
		Route::get('add-link', function(){
			return view('users.add_link');	
		})->name('user_add_link');

		Route::post('add-link', 'UrlController@user_store')->name('user_post_add_link');
	
	});

});