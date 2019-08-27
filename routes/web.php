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

use Illuminate\Http\Request;


Route::group(['middleware'=> ['auth', 'tenant']], function (){ // o middleware nesse caso é chamadado antes de qlauqer controlador
	Route::resource('activities', 'ActivityController');
	$this->redirect('/', '/activities', 301);

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');