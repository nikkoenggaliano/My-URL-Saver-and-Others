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
    return redirect()->route('user-dashboard');
});
// Route::get('/', function () {
//     return view('welcome');
// });




Route::get('/auth/', 'UserController@auth')->name('auth');
Route::get('/logout', 'UserController@logout')->name('logout');
Route::post('/register-user', 'UserController@signup')->name('register-user');
Route::post('/login-user', 'UserController@login')->name('login-user');


Route::middleware(['auth'])->group(function(){

	Route::get('/dashboard', function(){
		return view('users.dashboard');
	})->name('user-dashboard');

	# /user/
	Route::prefix('user')->group(function(){
		
		Route::get('add-link', function(){
			return view('users.add_link');	
		})->name('user_add_link');

		// View My Link

		Route::get('view-my-link', 'UrlController@return_url_total')->name('user_my_view_link');;

		Route::post('add-link', 'UrlController@user_store')->name('user_post_add_link');
	
		Route::get('edit-link/{id}', 'UrlController@get_edit_url')->name('edit_url_get');
		Route::post('edit-link/{id}', 'UrlController@action_edit_url')->name('edit_url_action');

		Route::post('delete-link/{id}', 'UrlController@action_delete_url')->name('delete_url');


		Route::get('pub-link', 'UrlController@return_url_public')->name('user_public_view_link');


		# /user/api/
		Route::prefix('api')->group(function(){

			Route::get('get-my-link', 'ApiActionURL@get_my_link_api');
			Route::get('get-detail-my-link/{id}', 'ApiActionURL@get_detail_link');
			Route::get('get-pub-link', 'ApiActionURL@public_link');

		});

	});

});