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



	//Auth::routes();

	// Authentication Routes...
	Route::get('/admin', 'Auth\LoginController@showLoginForm')->name('login');
	Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
	Route::post('login', 'Auth\LoginController@login');
	Route::post('logout', 'Auth\LoginController@logout')->name('logout');

	// Password Reset Routes...
	Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
	Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
	Route::post('password/reset', 'Auth\ResetPasswordController@reset');

	// Admin Routes
	Route::get('admin/home', 'Admin\HomeController@index')->middleware('auth')->name('admin.home');
	Route::get('/admin/lang/{iso}', 'Admin\HomeController@changeLanguage')->middleware('auth');

	Route::group(['namespace' => 'Admin\Site', 'prefix' => 'admin', 'middleware' => 'auth'], function () {

		// User Models
		Route::resource('categories', 'CategoriesController', ['names' => ['index' => 'admin.categories']]);
		Route::post('categories/menu', 'CategoriesController@changeMenuOrder');

		Route::get('pages/welcome', 'PagesController@welcome');
		Route::resource('pages', 'PagesController', ['names' => ['index' => 'admin.pages']]);

		Route::get('templates/status', 'TemplatesController@statusUpdate')->name('admin.templates.status');
		Route::post('templates/category', 'TemplatesController@categoryUpdate')->name('templates.category');
		Route::resource('templates', 'TemplatesController', ['names' => ['index' => 'admin.templates']]);
		Route::resource('news', 'NoticesController', ['names' => ['index' => 'admin.news']]);

		Route::get('subscribe', 'TemplatesController@index')->name('admin.subscribe');

		Route::get('products/welcome', 'ProductsController@welcome');
		Route::resource('products', 'ProductsController', ['names' => ['index' => 'admin.products']]);

		Route::resource('gallery/galleryCategory', 'GalleryCategoriesController', ['names' => ['index' => 'admin.galleries.categories']]);
		Route::post('gallery/galleryCategory/deleteSinglePhoto', 'GalleryCategoriesController@deleteSinglePhoto');
		Route::post('gallery/menu', 'GalleryCategoriesController@changeMenuOrder');

		Route::get('gallery/welcome', 'GalleriesController@welcome');
		Route::get('gallery/list/{id}', 'GalleriesController@listcategory');
		Route::post('gallery/deletePhotos', 'GalleriesController@deleteGalleryPhotos');
		Route::resource('gallery', 'GalleriesController', ['names' => ['index' => 'admin.gallery']]);

		Route::get('payments', 'TemplatesController@index')->name('admin.payments');
	});

	Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'can:isAdmin']], function () {

		Route::resource('modules', 'ModulesController', ['names' => ['index' => 'admin.modules']]);
		Route::resource('users', 'AdminUsersController', ['names' => ['index' => 'admin.users']]);
		Route::get('languages', 'LanguagesController@index')->name('admin.languages');
		Route::get('languages/{id}/edit', 'LanguagesController@edit')->name('admin.languages.edit');
		Route::resource('socials', 'SocialsController', ['names' => ['index' => 'admin.socials']]);
		Route::get('backup', 'BackupsController@index')->name('admin.backup');
		Route::get('setup', 'AdminSetupsController@index')->name('admin.setup');
		Route::post('setup/update', 'AdminSetupsController@update')->name('admin.setup.update');
	});

	// Site Routes
	Route::group(['namespace' => 'Site'], function () {
		Route::get('/', 'HomeController@index');
	});



	// Web Home Page
	//Route::get('/home', 'HomeController@index')->name('home');
