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
//if(Auth::check()){return Redirect::to('home');}
Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){

	Config::set('auth.default','admin');
		Route::get('login','AdminAuth@login');
		Route::post('login' ,'AdminAuth@dologin');
		Route::get('reset/password','AdminAuth@reset_password');
		Route::post('reset/password','AdminAuth@reset_password_post');
		Route::get('forget/password/{token}','AdminAuth@forgot_password');
		Route::post('forget/password/{token}','AdminAuth@forgot_password_final');

	Route::group(['middleware'=>'admin:admin'],function(){

				Route::resource('admin', 'AdminController');
				Route::delete('admin/destroy/all', 'AdminController@multi_delete');

				Route::resource('users', 'UsersController');
				Route::delete('users/destroy/all', 'UsersController@multi_delete');

				Route::get('settings','settings@setting');
				Route::post('settings','settings@setting_save');

				Route::resource('countries', 'CountriesController');
				Route::delete('countries/destroy/all', 'CountriesController@multi_delete');
				
				Route::resource('cities', 'CitiesController');
				Route::delete('cities/destroy/all', 'CitiesController@multi_delete');

				Route::resource('states', 'StateController');
				Route::delete('states/destroy/all', 'StateController@multi_delete');

				Route::resource('departments', 'DepartmentsController');
				Route::delete('departments/destroy/all', 'DepartmentsController@multi_delete');
				
				Route::resource('trademarks', 'TradeMarksController');
				Route::delete('trademarks/destroy/all', 'TradeMarksController@multi_delete');

				Route::resource('manufacturers', 'ManufacturersController');
				Route::delete('manufacturers/destroy/all', 'ManufacturersController@multi_delete');

				Route::resource('shipping', 'ShippingController');
    			Route::delete('shipping/destroy/all', 'ShippingController@multi_delete');


    		  	Route::resource('malls', 'MallsController');
    		 	Route::delete('malls/destroy/all', 'MallsController@multi_delete');

   			  	Route::resource('colors', 'ColorsController');
     			Route::delete('colors/destroy/all', 'ColorsController@multi_delete');

     			Route::resource('sizes', 'SizesController');
     			Route::delete('sizes/destroy/all', 'SizesController@multi_delete');
     			
     			Route::resource('weights', 'WeightsController');
     			Route::delete('weights/destroy/all', 'WeightsController@multi_delete');

     			Route::resource('products', 'ProductsController');
     			Route::delete('products/destroy/all', 'ProductsController@multi_delete');

				Route::get('/', function () {
						return view('admin.home');
					});
				Route::any('logout', 'AdminAuth@logout');
	});

	Route::get('lang/{lang}', function ($lang) {
				session()->has('lang')?session()->forget('lang'):'';
				$lang == 'ar'?session()->put('lang', 'ar'):session()->put('lang', 'en');
				return back();
			});
});
