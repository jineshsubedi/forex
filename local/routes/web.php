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

// Route::get('/', function () {
//     return view('theme.index');
// });

Route::group(['middleware' => ['web']], function(){
	Route::get('/', 'Theme\ThemeController@index');
	Route::post('/convert_currency', 'Theme\ThemeController@convert_currency')->name('convert_currency');
});

Auth::routes();




