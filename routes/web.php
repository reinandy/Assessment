<?php

use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Auth;

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


Route::get('/', 'PagesController@index')->name('login');
Route::post('/login', 'PagesController@login')->name('login.post');
Route::get('/logout', 'PagesController@logout')->name('logout');
Route::post('/forgot', 'PagesController@forgot')->name('forgot');

Route::group(['middleware' => ['auth']], function () {
	Route::get('/dashboard', 'PagesController@dashboard')->name('dashboard');
	Route::get('/detail/{id}', 'PagesController@detail')->name('detail');
	Route::resource('roles', 'RoleController');
	Route::resource('users', 'UserController');
	// contents
	Route::resource('contents', 'ContentController');
	Route::get('contents/destroy-content-file/{id}', 'ContentController@destroyContentFile')->name('content.destroy-content-file');
	// end contents
	Route::resource('content-categories', 'ContentCategoryController');
	Route::resource('permissions', 'PermissionController');
});

// Route::get('/quick-search', 'PagesController@quickSearch')->name('quick-search');